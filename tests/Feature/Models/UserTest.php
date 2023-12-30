<?php

test('has courses', function () {

    $user = \App\Models\User::factory()
        ->has(\App\Models\Course::factory(2), 'purchasedCourses')
        ->create();

    expect($user->purchasedCourses)
        ->toHaveCount(2)
        ->each->toBeInstanceOf(\App\Models\Course::class);

});

test('has videos', function () {

    $user = \App\Models\User::factory()
        ->has(\App\Models\Video::factory(2), 'watchedVideos')
        ->create();

    expect($user->watchedVideos)
        ->toHaveCount(2)
        ->each->toBeInstanceOf(\App\Models\Video::class);

});
