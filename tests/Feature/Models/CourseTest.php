<?php

test('only returns released courses scope', function () {

    \App\Models\Course::factory()->released()->create();
    \App\Models\Course::factory()->create();

    expect(\App\Models\Course::released()->get())
        ->toHaveCount(1)
        ->first()->id->toEqual(1);

});

test('has videos relationship', function () {

    $course = \App\Models\Course::factory()->create();

    \App\Models\Video::factory()->count(3)->create([
        'course_id' => $course->id,
    ]);

    expect($course->videos)
        ->toHaveCount(3)
        ->each->toBeInstanceOf(\App\Models\Video::class);

});