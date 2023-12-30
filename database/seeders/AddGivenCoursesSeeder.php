<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AddGivenCoursesSeeder extends Seeder
{
    public function run(): void
    {
        if ($this->isDataAlreadyGiven()) {
            return;
        }

        Course::create([
            'paddle_product_id' => 'pro_01hjxwwpk3t4272vn3vyz23qj2',
            'slug' => Str::slug('Laravel For Beginners'),
            'title' => 'Laravel For Beginners',
            'description' => 'This course will get you started with Laravel.',
            'tagline' => 'Get started with Laravel',
            'image_name' => 'laravel_for_beginners.png',
            'learnings' => [
                'How to start with Laravel',
                'Where to start with Laravel',
                'Build your first Laravel application',
            ],
            'released_at' => now()
        ]);

        Course::create([
            'paddle_product_id' => 'pro_01hjxwz0rvr6bthfme725hbmkb',
            'slug' => Str::slug('Advanced Laravel'),
            'title' => 'Advanced Laravel',
            'description' => 'A video course on advanced Laravel.',
            'tagline' => 'Level up your Laravel skills',
            'image_name' => 'advanced_laravel.png',
            'learnings' => [
                'How to use service container',
                'Pipelines in laravel',
                'Secure your application',
            ],
            'released_at' => now()
        ]);

        Course::create([
            'paddle_product_id' => 'pro_01hjxx11s2hnq8py4d2a5pmr6m',
            'slug' => Str::slug('TDD The Laravel Way'),
            'title' => 'TDD The Laravel Way',
            'description' => 'Video course on TDD in Laravel.',
            'tagline' => 'Learn TDD in Laravel',
            'image_name' => 'tdd_laravel.png',
            'learnings' => [
                'What is TDD and why you should use it',
                'Using TDD in Laravel',
                'How to write tests in Laravel',
            ],
            'released_at' => now()
        ]);
    }

    private function isDataAlreadyGiven(): bool
    {
        return Course::where('title', 'Laravel For Beginners')->exists()
            && Course::where('title', 'Advanced Laravel')->exists()
            && Course::where('title', 'TDD The Laravel Way')->exists();
    }
}
