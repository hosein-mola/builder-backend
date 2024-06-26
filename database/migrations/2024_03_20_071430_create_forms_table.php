<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('published')->default(false);
            $table->string('description')->default('');
            $table->integer('visit')->default(0);
            $table->integer('submission')->default(0);
            $table->string('share_url')->unique()->nullable();
            $table->unsignedBigInteger('parent_id')->index()->nullable();
            $table->foreign('parent_id')->references('id')->on('forms');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forms');
    }
};
