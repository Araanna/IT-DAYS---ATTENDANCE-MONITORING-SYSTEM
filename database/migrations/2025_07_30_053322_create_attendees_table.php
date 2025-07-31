<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendeesTable extends Migration
{
    public function up(): void
    {
        Schema::create('attendees', function (Blueprint $table) {
            $table->id();

            // Basic Info
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('course');
            $table->enum('gender', ['Male', 'Female', 'Other']); // capitalized

            // Foreign Key to year_levels
            $table->foreignId('year_level_id')->constrained()->onDelete('cascade');

            // QR & Attendance
            $table->string('qr_code_path')->nullable();
            $table->boolean('has_attended')->default(false);

            // Role & Position
            $table->enum('role', ['Attendee', 'SBO'])->default('Attendee'); // capitalized
            $table->string('position')->nullable(); // for SBOs only

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendees');
    }
}
