<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSectionYearTermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('section_year_terms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->references('id')->on('sections')->cascadeOnDelete();
            $table->foreignId('year_term_id')->references('id')->on('year_terms')->cascadeOnDelete();
            $table->timestamps();
        });
        DB::table('section_year_terms')->insert([
            'section_id' => 1,
            'year_term_id' => 1
        ]);
        DB::table('section_year_terms')->insert([
            'section_id' => 1,
            'year_term_id' => 2
        ]);
        DB::table('section_year_terms')->insert([
            'section_id' => 1,
            'year_term_id' => 3
        ]);
        DB::table('section_year_terms')->insert([
            'section_id' => 1,
            'year_term_id' => 4
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('section_year_terms');
    }
}
