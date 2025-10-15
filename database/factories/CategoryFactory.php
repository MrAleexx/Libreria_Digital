<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true),
            'slug' => fake()->slug(),
            'description' => fake()->paragraph(),
            'parent_id' => null,
            'sort_order' => fake()->numberBetween(1, 100),
            'is_active' => true,
            'image' => null,
            'meta_title' => null,
            'meta_description' => null,
        ];
    }

    public function inactive()
    {
        return $this->state(fn(array $attributes) => [
            'is_active' => false,
        ]);
    }

    public function withParent($parentId)
    {
        return $this->state(fn(array $attributes) => [
            'parent_id' => $parentId,
        ]);
    }
}
