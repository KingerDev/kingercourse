<?php

namespace App\Http\Controllers;

use App\Models\Course;

class PageCourseDetailsController extends Controller
{
    public function __invoke(Course $course)
    {
        $course->loadCount('videos');

        if (! $course->released_at) {
            abort(404);
        }

        return view('pages.course-details', compact('course'));
    }
}
