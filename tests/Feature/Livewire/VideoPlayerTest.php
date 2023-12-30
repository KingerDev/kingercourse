<?php

function createCourseWithVideo(int $count = 1)
{
    return \App\Models\Course::factory()
        ->has(\App\Models\Video::factory($count))
        ->create();
}

beforeEach(function () {
    $this->loggedInUser = loginAsUser();
});

test('shows details for given video', function () {

    $course = createCourseWithVideo();

    $video = $course->videos()->first();

    \Livewire\Livewire::test(\App\Livewire\VideoPlayer::class, ['video' => $video])
        ->assertSeeText([
            $video->title,
            $video->description,
            "({$video->duration_in_min}min)",
        ]);

});

test('shows given video', function () {

    $course = createCourseWithVideo();

    $video = $course->videos()->first();

    \Livewire\Livewire::test(\App\Livewire\VideoPlayer::class, ['video' => $video])
        ->assertSeeHtml('<iframe src="https://player.vimeo.com/video/'.$video->vimeo_id.'"');

});

test('shows list of all course videos', function () {

    $course = createCourseWithVideo(5);

    \Livewire\Livewire::test(\App\Livewire\VideoPlayer::class, ['video' => $course->videos()->first()])
        ->assertSeeTextInOrder([
            ...$course->videos()->pluck('title')->toArray(),
        ])->assertSeeHtml([
            route('page.course-videos', [ 'course' => $course, 'video' => $course->videos[1] ]),
            route('page.course-videos', [ 'course' => $course, 'video' => $course->videos[2] ]),
            route('page.course-videos', [ 'course' => $course, 'video' => $course->videos[3] ]),
            route('page.course-videos', [ 'course' => $course, 'video' => $course->videos[4] ]),
        ]);

});

test('does not include route for current video', function () {

    $course = createCourseWithVideo(5);

    \Livewire\Livewire::test(\App\Livewire\VideoPlayer::class, ['video' => $course->videos()->first()])
        ->assertSeeTextInOrder([
            ...$course->videos()->pluck('title')->toArray(),
        ])->assertDontSeeHtml([
            route('page.course-videos', $course->videos[0]),
        ]);

});

test('marks video as completed', function () {

    $course = createCourseWithVideo();

    $this->loggedInUser->purchasedCourses()->attach($course);

    expect($this->loggedInUser->watchedVideos)->toHaveCount(0);

    Livewire::test(\App\Livewire\VideoPlayer::class, ['video' => $course->videos()->first()])
        ->assertMethodWired('markVideoAsCompleted')
        ->call('markVideoAsCompleted')
        ->assertMethodNotWired('markVideoAsCompleted')
        ->assertMethodWired('markVideoAsNotCompleted');

    $this->loggedInUser->refresh();
    expect($this->loggedInUser->watchedVideos)
        ->toHaveCount(1)
        ->first()->title->toEqual($course->videos()->first()->title);

});

test('marks video as not completed', function () {

    $course = createCourseWithVideo();

    $this->loggedInUser->purchasedCourses()->attach($course);
    $this->loggedInUser->watchedVideos()->attach($course->videos()->first());

    expect($this->loggedInUser->watchedVideos)->toHaveCount(1);

    Livewire::test(\App\Livewire\VideoPlayer::class, ['video' => $course->videos()->first()])
        ->assertMethodWired('markVideoAsNotCompleted')
        ->call('markVideoAsNotCompleted')
        ->assertMethodNotWired('markVideoAsNotCompleted')
        ->assertMethodWired('markVideoAsCompleted');

    $this->loggedInUser->refresh();

    expect($this->loggedInUser->watchedVideos)->toHaveCount(0);

});