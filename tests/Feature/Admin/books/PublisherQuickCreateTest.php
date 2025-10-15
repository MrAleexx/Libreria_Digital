<?php
// tests/Feature/PublisherQuickCreateTest.php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Publisher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublisherQuickCreateTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['role' => 'admin']);
    }

    /** @test */
    public function admin_can_quick_create_publisher()
    {
        $response = $this->actingAs($this->admin)
            ->postJson(route('admin.publishers.quick-create'), [
                'name' => 'Nueva Editorial Test',
                'country' => 'Perú',
                'city' => 'Lima'
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'publisher' => [
                    'name' => 'Nueva Editorial Test'
                ]
            ]);

        $this->assertDatabaseHas('publishers', [
            'name' => 'Nueva Editorial Test',
            'country' => 'Perú',
            'city' => 'Lima'
        ]);
    }

    /** @test */
    public function quick_create_publisher_requires_name()
    {
        $response = $this->actingAs($this->admin)
            ->postJson(route('admin.publishers.quick-create'), [
                'country' => 'Perú'
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function quick_create_publisher_requires_unique_name()
    {
        Publisher::factory()->create(['name' => 'Editorial Existente']);

        $response = $this->actingAs($this->admin)
            ->postJson(route('admin.publishers.quick-create'), [
                'name' => 'Editorial Existente',
                'country' => 'Perú'
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }
}
