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
        Schema::create('components', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->bigInteger('parentId');
            $table->bigInteger('page');
            $table->bigInteger('text_id')->nullable();
            $table->bigInteger('panel_id')->nullable();
            $table->foreign('text_id')->references('id')->on('text_fields');
            $table->foreign('panel_id')->references('id')->on('panels');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('components');
    }
};
