<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->unique();
            $table->string('last_name')->nullable();
            $table->string('password');
            $table->string('phone_number')->nullable()->unique();
            $table->enum('type', [
                'مشرف', 'مدير',
                'طالب'
            ])->default('طالب');
            $table->rememberToken();
            $table->timestamps();
        });
        DB::table('users')->insert([
            'first_name' => 'admin',
            'type' => 'مدير',
            'password' => Hash::make('admin1234'),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
