<?php

use App\Models\Course;

use function Pest\Laravel\get;

test('shows courses overview', function () {

    // Arrange
    $first_course = Course::factory()->released()->create();
    $second_course = Course::factory()->released()->create();
    $third_course = Course::factory()->released()->create();

    // Act & Assert
    get(route('pages.home'))
        ->assertOk()
        ->assertSeeText([
            $first_course->title,
            $first_course->description,
            $second_course->title,
            $second_course->description,
            $third_course->title,
            $third_course->description,
        ]);

});

test('shows only released courses', function () {

    $released_course = Course::factory()->released()->create();
    $not_released_course = Course::factory()->create();

    get(route('pages.home'))
        ->assertSeeText($released_course->title)
        ->assertDontSeeText($not_released_course->title);

});

test('shows courses by release date', function () {

    $second_course = Course::factory()->released(\Carbon\Carbon::yesterday())->create();
    $first_course = Course::factory()->released(\Carbon\Carbon::now())->create();

    get(route('pages.home'))
        ->assertSeeInOrder([$first_course->title, $second_course->title]);

});

test('includes login if not logged in', function () {

    get(route('pages.home'))
        ->assertOk()
        ->assertSeeText('Login')
        ->assertSee(route('login'));

});

test('includes logout if logged in', function () {

    loginAsUser();
    get(route('pages.home'))
        ->assertOk()
        ->assertSeeText('Log out')
        ->assertSee(route('logout'));

});

test('does not find JetStream registration page', function () {

    get('register')
        ->assertNotFound();

});

test('includes logout', function () {

    loginAsUser();
    get(route('pages.dashboard'))
        ->assertOk()
        ->assertSeeText('Log Out')
        ->assertSee(route('logout'));

});

test('includes courses links', function () {

    $first_course = Course::factory()->released()->create();
    $second_course = Course::factory()->released()->create();
    $last_course = Course::factory()->released()->create();

    get(route('pages.home'))
        ->assertOk()
        ->assertSeeText($first_course->title)
        ->assertSeeText($second_course->title)
        ->assertSeeText($last_course->title)
        ->assertSee(route('pages.course-details', $first_course))
        ->assertSee(route('pages.course-details', $second_course))
        ->assertSee(route('pages.course-details', $last_course));

});