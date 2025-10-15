<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Models\User;
use App\Services\Admin\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $userService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userService = new UserService();
    }

    /** @test */
    public function it_creates_user_with_temp_password()
    {
        $userData = [
            'name' => 'Test User',
            'last_name' => 'Test Last',
            'email' => 'test@example.com',
            'dni' => '12345678',
            'phone' => '987654321',
            'role' => 'user',
        ];

        $result = $this->userService->createUser($userData, 1);

        $this->assertInstanceOf(User::class, $result['user']);
        $this->assertNotEmpty($result['temp_password']);
        $this->assertTrue($result['user']->is_temp_password);
        $this->assertEquals(1, $result['user']->created_by);
        $this->assertTrue(Hash::check($result['temp_password'], $result['user']->password));
    }

    /** @test */
    public function it_updates_user_with_temp_password_reset()
    {
        $user = User::factory()->create();

        $updateData = [
            'name' => 'Updated Name',
            'last_name' => 'Updated Last',
            'email' => 'updated@example.com',
            'role' => 'librarian',
            'dni' => '87654321',
            'phone' => '123456789',
            'is_active' => true,
            'reset_temp_password' => true,
        ];

        $result = $this->userService->updateUser($user, $updateData);

        $user->refresh();

        $this->assertNotEmpty($result['temp_password']);
        $this->assertEquals('Updated Name', $user->name);
        $this->assertTrue($user->is_temp_password);
        $this->assertTrue(Hash::check($result['temp_password'], $user->password));
    }

    /** @test */
    public function it_updates_user_with_permanent_password()
    {
        $user = User::factory()->create();

        $updateData = [
            'name' => $user->name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'role' => $user->role,
            'dni' => $user->dni,
            'phone' => $user->phone,
            'is_active' => true,
            'password' => 'newpassword123',
        ];

        $result = $this->userService->updateUser($user, $updateData);

        $user->refresh();

        $this->assertEmpty($result);
        $this->assertFalse($user->is_temp_password);
        $this->assertTrue(Hash::check('newpassword123', $user->password));
    }

    /** @test */
    public function it_deletes_user_and_related_data()
    {
        $user = User::factory()->create();

        // Crear datos relacionados (simplificado para el ejemplo)
        // En un test real crearías factories para todas las relaciones

        $this->userService->deleteUser($user);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    /** @test */
    public function it_handles_user_creation_with_institutional_email()
    {
        $userData = [
            'name' => 'Test User',
            'last_name' => 'Test Last',
            'email' => 'test@example.com',
            'institutional_email' => 'test@institution.edu',
            'dni' => '12345678',
            'phone' => '987654321',
            'role' => 'user',
        ];

        $result = $this->userService->createUser($userData, 1);

        $this->assertEquals('test@institution.edu', $result['user']->institutional_email);
    }
}
