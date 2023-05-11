<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYearSectionModetatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('year_section_modetators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('moderator_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignId('year_id')->references('id')->on('years')->cascadeOnDelete();
            $table->foreignId('section_id')->references('id')->on('sections')->cascadeOnDelete();
            $table->unique(['moderator_id','section_id', 'year_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('year_section_modetators');
    }
}
