<?php
// database/seeders/LanguageSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Language;

class LanguageSeeder extends Seeder
{
    public function run(): void
    {
        $languages = [
            ['code' => 'es', 'name' => 'Spanish', 'native_name' => 'Español', 'is_active' => 1],
            ['code' => 'en', 'name' => 'English', 'native_name' => 'English', 'is_active' => 1],
            ['code' => 'fr', 'name' => 'French', 'native_name' => 'Français', 'is_active' => 1],
            ['code' => 'de', 'name' => 'German', 'native_name' => 'Deutsch', 'is_active' => 1],
            ['code' => 'it', 'name' => 'Italian', 'native_name' => 'Italiano', 'is_active' => 1],
            ['code' => 'pt', 'name' => 'Portuguese', 'native_name' => 'Português', 'is_active' => 1],
        ];

        foreach ($languages as $language) {
            Language::firstOrCreate(
                ['code' => $language['code']],
                $language
            );
        }
    }
}
