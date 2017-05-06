<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('name');
            $table->string('full_name')->nullable()->default(NULL);
            $table->string('email')->unique();
            $table->string('password');
            
            $table->string('thumbnail')->nullable()->default(NULL);
            $table->string('school')->nullable()->default(NULL);
            $table->string('charm_point')->nullable()->default(NULL);
            $table->string('hobby')->nullable()->default(NULL);
            
            $table->rememberToken();
            $table->timestamps();
        });
        
        DB::table('users')->insert([
                'name' => 'みいたけ',
                'full_name' => '武村美空',
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
        Schema::dropIfExists('users');
    }
}
