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
        Schema::create('topics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained()->cascadeOnDelete();
            $table->string('topic_number', 50);
            $table->string('title', 255);
            $table->longText('content')->nullable();
            $table->string('file_path')->nullable();
            $table->string('original_filename')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['lesson_id', 'order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topics');
    }
};
