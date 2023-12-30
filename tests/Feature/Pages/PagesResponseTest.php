<?php

use function Pest\Laravel\get;

test('gives back successful response for home page', function () {

    get(route('pages.home'))
        ->assertOk();

});

test('gives back successful response for details page', function () {

    $course = \App\Models\Course::factory()->released()->create();

    get(route('pages.course-details', $course))
        ->assertOk();

});

test('gives back successful response for dashboard page', function () {

    loginAsUser();
    get(route('pages.dashboard'))
        ->assertOk();

});

test('gives successful response for videos page', function () {

    $course = \App\Models\Course::factory()
        ->released()
        ->has(\App\Models\Video::factory())
        ->create();

    loginAsUser();
    get(route('page.course-videos', $course))
        ->assertOk();

});