<?php

use App\Livewire\VideoPlayer;
use function Pest\Laravel\get;

test('cannot be accessed by guest', function () {

    $course = \App\Models\Course::factory()->create();

    get(route('page.course-videos', $course))
        ->assertRedirect(route('login'));

});

test('includes video player', function () {

    $course = \App\Models\Course::factory()
        ->has(\App\Models\Video::factory())
        ->create();

    loginAsUser();
    get(route('page.course-videos', $course, ))
        ->assertOk()
        ->assertSeeLivewire(VideoPlayer::class);

});

test('shows first course video by default', function () {

    $course = \App\Models\Course::factory()
        ->has(\App\Models\Video::factory())
        ->create();

    loginAsUser();
    get(route('page.course-videos', [
        'course' => $course,
        'video' => $course->videos()->orderByDesc('id')->first()
    ]))
        ->assertOk()
        ->assertSee("<h3>{$course->videos()->first()->title}", false);

});

test('shows provided course video', function () {

    $course = \App\Models\Course::factory()
        ->has(
            \App\Models\Video::factory()->state(new \Illuminate\Database\Eloquent\Factories\Sequence(
                ['title' => 'First video'],
                ['title' => 'Second video'],
            ))
                ->count(2)
        )
        ->create();

    loginAsUser();
    get(route('page.course-videos', [
        'course' => $course,
        'video' => $course->videos()->orderByDesc('id')->first()
    ]))
        ->assertOk()
        ->assertSeeText('Second video');

});