<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSectionYearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('section_years', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->references('id')->on('sections')->cascadeOnDelete();
            $table->foreignId('year_id')->references('id')->on('years')->cascadeOnDelete();
            $table->timestamps();
        });
        DB::table('section_years')->insert([
            'section_id' => 1,
            'year_id' => 1
        ]);
        DB::table('section_years')->insert([
            'section_id' => 1,
            'year_id' => 2
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('section_years');
    }
}
