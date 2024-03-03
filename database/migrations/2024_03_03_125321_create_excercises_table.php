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
        Schema::create('excercises', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('exerciseable_id')->nullable();
            // $table->string('exerciseable_type')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('type'); 
            $table->foreignId('user_id')->nullable();
            $table->string('created_by')->nullable();
            // $table->boolean('is_lock')->default(false)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('excercises');
    }
};
