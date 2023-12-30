<?php


use App\Models\Course;

test('includes purchase details', function () {

    $course = Course::factory()->create();

    $mail = new \App\Mail\NewPurchaseMail($course);

    $mail->assertSeeInText("Thanks for purchasing $course->title");
    $mail->assertSeeInText("Login");
    $mail->assertSeeInHtml(route('login'));

});
