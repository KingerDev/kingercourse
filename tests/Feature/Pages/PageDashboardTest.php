<?php

use function Pest\Laravel\get;

test('cannot be accessed by guest', function () {

    get(route('pages.dashboard'))
        ->assertRedirect(route('login'));

});

test('lists purchased courses', function () {

    $user = \App\Models\User::factory()
        ->has(\App\Models\Course::factory()->count(2)->state(
            new \Illuminate\Database\Eloquent\Factories\Sequence(
                ['title' => 'First Course'],
                ['title' => 'Second Course'],
            )), 'purchasedCourses')
        ->create();

    loginAsUser($user);
    get(route('pages.dashboard'))
        ->assertOk()
        ->assertSee('First Course')
        ->assertSee('Second Course');

});

test('does not list any other courses', function () {

    $course = \App\Models\Course::factory()->create();

    loginAsUser();
    get(route('pages.dashboard'))
        ->assertOk()
        ->assertDontSee($course->title);

});

test('shows latest purchased course first', function () {

    $user = \App\Models\User::factory()->create();
    $firstPurchasedCourse = \App\Models\Course::factory()->create();
    $lastPurchasedCourse = \App\Models\Course::factory()->create();

    $user->purchasedCourses()->attach($firstPurchasedCourse, ['created_at' => \Carbon\Carbon::yesterday()]);
    $user->purchasedCourses()->attach($lastPurchasedCourse, ['created_at' => \Carbon\Carbon::now()]);

    loginAsUser($user);
    get(route('pages.dashboard'))
        ->assertOk()
        ->assertSeeInOrder([$lastPurchasedCourse->title, $firstPurchasedCourse->title]);

});

test('includes link to product videos', function () {

    $user = \App\Models\User::factory()
        ->has(\App\Models\Course::factory(), 'purchasedCourses')
        ->create();

    $this->actingAs($user);
    get(route('pages.dashboard'))
        ->assertOk()
        ->assertSeeText('Watch videos')
        ->assertSee(route('page.course-videos', \App\Models\Course::first()));
});