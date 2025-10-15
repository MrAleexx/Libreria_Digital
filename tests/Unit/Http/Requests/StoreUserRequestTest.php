<?php

namespace Tests\Unit\Http\Requests;

use Tests\TestCase;
use App\Http\Requests\Admin\users\StoreUserRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreUserRequestTest extends TestCase
{
    use RefreshDatabase;

    /** 
     * @test 
     */
    public function it_validates_correct_data()
    {
        $data = [
            'name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'role' => 'user',
            'dni' => '12345678',
            'phone' => '987654321',
        ];

        $request = new StoreUserRequest();
        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->fails());
    }

    /** 
     * @test 
     */
    public function it_fails_with_invalid_email()
    {
        $data = [
            'name' => 'John',
            'last_name' => 'Doe',
            'email' => 'invalid-email',
            'role' => 'user',
            'dni' => '12345678',
            'phone' => '987654321',
        ];

        $request = new StoreUserRequest();
        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('email', $validator->errors()->toArray());
    }

    /** 
     * @test 
     */
    public function it_fails_with_invalid_dni_length()
    {
        $data = [
            'name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'role' => 'user',
            'dni' => '123', // Muy corto
            'phone' => '987654321',
        ];

        $request = new StoreUserRequest();
        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('dni', $validator->errors()->toArray());
    }

    /** 
     * @test 
     */
    public function it_allows_null_institutional_email()
    {
        $data = [
            'name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'institutional_email' => null,
            'role' => 'user',
            'dni' => '12345678',
            'phone' => '987654321',
        ];

        $request = new StoreUserRequest();
        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->fails());
    }

    /** 
     * @test 
     */
    public function it_fails_with_duplicate_email()
    {
        // Crear un usuario existente para probar la regla unique
        \App\Models\User::factory()->create(['email' => 'existing@example.com']);

        $data = [
            'name' => 'John',
            'last_name' => 'Doe',
            'email' => 'existing@example.com', // Email duplicado
            'role' => 'user',
            'dni' => '87654321', // DNI diferente
            'phone' => '123456789', // Teléfono diferente
        ];

        $request = new StoreUserRequest();
        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('email', $validator->errors()->toArray());
    }
}
