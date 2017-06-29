<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('nick_name')->nullable()->default(NULL);
            $table->string('email')->unique();
            $table->string('password');

            //$table->integer('authority');
            
            $table->rememberToken();
            $table->timestamps();
        });
        
        DB::table('admins')->insert([
                'name' => 'cute-admin',
				'email' => 'cute@cute.com',
                'password' => bcrypt('locofull123C'),
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        );
        
        DB::table('admins')->insert([
                'name' => 'opal',
				'email' => 'opal@frank.fam.cx',
                'password' => bcrypt('aaaaa111'),
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
