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
        Schema::create('component_form', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("form_id");
            $table->foreign('form_id')->references('id')->on('forms');
            $table->ulid('component_id')->index();
            $table->foreign('component_id')->references('id')->on('components');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('form_panel', function (Blueprint $table) {
            //
        });
    }
};
