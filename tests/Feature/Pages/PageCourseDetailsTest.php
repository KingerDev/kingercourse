<?php

use function Pest\Laravel\get;

test('does not find unreleased course', function () {

    $course = \App\Models\Course::factory()->create();

    get(route('pages.course-details', $course))
        ->assertNotFound();

});

test('shows course details', function () {

    $course = \App\Models\Course::factory()->released()->create();

    get(route('pages.course-details', $course))
        ->assertOk()
        ->assertSeeText([
            $course->title,
            $course->description,
            $course->tagline,
            ...$course->learnings,
        ])
        ->assertSee(asset('images/'.$course->image_name));

});

test('shows course video count', function () {

    $course = \App\Models\Course::factory()->released()
        ->has(\App\Models\Video::factory()->count(3))
        ->create();

    get(route('pages.course-details', $course))
        ->assertOk()
        ->assertSeeText('3 videos');

});

test('includes paddle checkout button', function () {

    config()->set('services.paddle.vendor-id', 'vendor-id');
    $course = \App\Models\Course::factory()->released()
        ->create([
            'paddle_product_id' => 'product-id',
        ]);

    get(route('pages.course-details', $course))
        ->assertOk()
        ->assertSee('<script src="https://cdn.paddle.com/paddle/paddle.js"></script>', false)
        ->assertSee('Paddle.Setup({ vendor: vendor-id });', false)
        ->assertSee('<a href="#!" class="paddle_button" data-product="product-id">Buy Now!</a>', false);

});