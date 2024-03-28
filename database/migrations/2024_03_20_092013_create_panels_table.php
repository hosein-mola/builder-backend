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
        Schema::create('panels', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('cols')->default('1');
            $table->string('span')->default('1');
            $table->unsignedBigInteger('component_id')->index();
            $table->foreign('component_id')->references('id')->on('components');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('panels');
    }
};
