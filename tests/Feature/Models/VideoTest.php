<?php


test('gives back readable video duration', function () {

    $video = \App\Models\Video::factory()->make([
        'duration_in_min' => 10,
    ]);

    expect($video->getReadableDuration())->toEqual('10min');

});

test('belongs to a course', function () {

    $video = \App\Models\Video::factory()
        ->has(\App\Models\Course::factory())
        ->create();

    expect($video->course)
        ->toBeInstanceOf(\App\Models\Course::class);

});

test('tells if current user has not yet watched a given video', function () {

    $video = \App\Models\Video::factory()->create();

    loginAsUser();
    expect($video->alreadyWatchedByCurrentUser())->toBeFalse();

});

test('tells if current user has watched a given video', function () {

    $user = \App\Models\User::factory()
        ->has(\App\Models\Video::factory(), 'watchedVideos')
        ->create();

    loginAsUser($user);
    expect($user->watchedVideos()->first()->alreadyWatchedByCurrentUser())->toBeTrue();

});