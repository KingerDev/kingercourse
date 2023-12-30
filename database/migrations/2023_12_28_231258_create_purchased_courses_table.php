<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('purchased_courses', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(\App\Models\Course::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignIdFor(\App\Models\User::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchased_courses');
    }
};
