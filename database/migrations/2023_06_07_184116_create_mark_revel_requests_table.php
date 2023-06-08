<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarkRevelRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mark_revel_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId("student_id")->references("id")->on("students")->cascadeOnDelete();
            $table->foreignId("section_year_id")->references("id")->on("section_years")->cascadeOnDelete();
            $table->string("no_financial_receipt");
            $table->string("date_financial_receipt");
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
        Schema::dropIfExists('mark_revel_requests');
    }
}
