<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(\App\Models\Course::class, 'course_id')
                ->constrained('courses')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('slug')->unique();
            $table->string('vimeo_id');
            $table->string('title');
            $table->text('description');
            $table->integer('duration_in_min');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
