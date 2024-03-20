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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('fname');
            $table->string('lname');
            $table->string('mname')->nullable();
            $table->date('dob');
            $table->string('street')->nullable();
            $table->string('date');
            $table->string('sex');
            $table->unsignedBigInteger('provider_id')->nullable(); // Allow NULL for now
            $table->string('audio');
            $table->unsignedBigInteger('external_id')->nullable(); // Allow NULL for now
            $table->timestamps();
            // Define foreign key constraints
            $table->foreign('provider_id')->references('id')->on('providers')
                  ->onDelete('SET NULL'); // Change to SET NULL to handle nullable column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
