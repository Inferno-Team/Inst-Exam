<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateYearTermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('year_terms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('year_id')->references('id')->on('years')->cascadeOnDelete();
            $table->string('name');
            $table->timestamps();
        });
        DB::table('year_terms')->insert([
            'year_id' => 1,
            'name' => 'الفصل الأول'
        ]);
        DB::table('year_terms')->insert([
            'year_id' => 1,
            'name' => 'الفصل الثاني'
        ]);
        DB::table('year_terms')->insert([
            'year_id' => 2,
            'name' => 'الفصل الأول'
        ]);
        DB::table('year_terms')->insert([
            'year_id' => 2,
            'name' => 'الفصل الثاني'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('year_terms');
    }
}
