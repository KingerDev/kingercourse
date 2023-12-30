<?php

namespace Database\Factories;

use App\Models\PurchasedCourse;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PurchasedCourseFactory extends Factory
{
    protected $model = PurchasedCourse::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
