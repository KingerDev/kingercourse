<?php


use App\Models\Course;

test('adds given courses', function () {

    $this->assertDatabaseCount(\App\Models\Course::class, 0);

    $this->artisan('db:seed');

    $this->assertDatabaseCount(\App\Models\Course::class, 3);
    $this->assertDatabaseHas(\App\Models\Course::class, ['title' => 'Laravel For Beginners',]);
    $this->assertDatabaseHas(\App\Models\Course::class, ['title' => 'Advanced Laravel',]);
    $this->assertDatabaseHas(\App\Models\Course::class, ['title' => 'TDD The Laravel Way',]);

});

test('adds given courses only once', function () {

    $this->assertDatabaseCount(\App\Models\Course::class, 0);

    $this->artisan('db:seed');
    $this->artisan('db:seed');

    $this->assertDatabaseCount(\App\Models\Course::class, 3);
});

test('adds given videos', function () {

    $this->assertDatabaseCount(\App\Models\Video::class, 0);

    $this->artisan('db:seed');

    $laravelForBeginnersCourse = Course::where('title', 'Laravel For Beginners')->firstOrFail();
    $advancedLaravelCourse = Course::where('title', 'Advanced Laravel')->firstOrFail();
    $tddTheLaravelWayCourse = Course::where('title', 'TDD The Laravel Way')->firstOrFail();
    $this->assertDatabaseCount(\App\Models\Video::class, 8);

    expect($laravelForBeginnersCourse->videos->count())
        ->toBe(3)
        ->and($advancedLaravelCourse->videos->count())
        ->toBe(3)
        ->and($tddTheLaravelWayCourse->videos->count())
        ->toBe(2);

});

test('adds given videos only once', function () {

    $this->assertDatabaseCount(\App\Models\Video::class, 0);

    $this->artisan('db:seed');
    $this->artisan('db:seed');

    $this->assertDatabaseCount(\App\Models\Video::class, 8);

});

test('adds local test user', function () {

    App::partialMock()
        ->shouldReceive('environment')
        ->andReturn('local');
    $this->assertDatabaseCount(\App\Models\User::class, 0);

    $this->artisan('db:seed');

    $this->assertDatabaseCount(\App\Models\User::class, 1);

});

test('does not add test user for production', function () {

    $this->assertDatabaseCount(\App\Models\User::class, 0);

    $this->artisan('db:seed');

    $this->assertDatabaseCount(\App\Models\User::class, 0);

});