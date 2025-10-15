<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LanguageFactory extends Factory
{
    public function definition(): array
    {
        // Solo crear idiomas si es necesario, pero en los tests usaremos los existentes
        return [
            'code' => 'xx',
            'name' => 'Test Language',
            'native_name' => 'Test Language Native',
            'is_active' => true,
        ];
    }

    // Mantener estos métodos por si acaso, pero en tests usaremos idiomas existentes
    public function testLanguage()
    {
        return $this->state([
            'code' => 'test_' . uniqid(),
            'name' => 'Test Language',
            'native_name' => 'Test Language Native',
        ]);
    }
}
