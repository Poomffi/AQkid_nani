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
        Schema::create('timeslots', function (Blueprint $table) {
            $table->unsignedBigInteger('course_id');

            $table->id();
            $table->foreign('course_id')->references('id')->on('courses');
            $table->datetime('datetime');
            $table->enum('type', ['REGULAR', 'MAKEUP', 'UNDEFINED']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timeslots');
    }
};
