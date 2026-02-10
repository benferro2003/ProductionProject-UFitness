<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->string('exercise_db_id')->unique(); // ExerciseDB ID
            $table->string('name');
            $table->string('body_part'); // e.g., "chest", "back", "legs"
            $table->string('equipment'); // e.g., "barbell", "dumbbell", "body weight"
            $table->string('target'); // e.g., "pectorals", "lats", "quads"
            $table->string('gif_url')->nullable(); // URL to exercise GIF
            $table->json('secondary_muscles')->nullable(); // Array of secondary muscles
            $table->json('instructions')->nullable(); // Array of instruction steps
            $table->timestamps();
            
            // Indexes for faster queries
            $table->index('body_part');
            $table->index('equipment');
            $table->index('target');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercises');
    }
};
