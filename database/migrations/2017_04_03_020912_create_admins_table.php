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
            
            $table->string('model_thumb')->nullable()->default(NULL);
            $table->string('school')->nullable()->default(NULL);
            $table->string('charm_point')->nullable()->default(NULL);
            $table->string('hobby')->nullable()->default(NULL);
            
            
            
            $table->integer('authority');
            
            $table->rememberToken();
            $table->timestamps();
        });
        
        DB::table('admins')->insert([
                'name' => 'cute-admin',
				'email' => 'cute@cute.com',
                'password' => bcrypt('cutecute'),
                'authority' => 99,
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
