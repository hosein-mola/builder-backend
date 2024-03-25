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
        Schema::create('component_panel', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('component_id');
            $table->bigInteger('panel_id');
            $table->foreign('component_id')->references('id')->on('components');
            $table->foreign('panel_id')->references('id')->on('panels');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('component_panel', function (Blueprint $table) {
            //
        });
    }
};
