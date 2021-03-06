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
            $table->integer('state_id');
            $table->string('name');
            $table->string('full_name')->nullable()->default(NULL);
            $table->string('email')->unique();
            $table->string('password');
            
            $table->string('model_thumb')->nullable()->default(NULL);
            $table->string('twitter')->nullable()->default(NULL);
            $table->string('instagram')->nullable()->default(NULL);
            $table->string('school')->nullable()->default(NULL);
            $table->text('per_info')->nullable()->default(NULL);
            //$table->string('hobby')->nullable()->default(NULL);
            
            $table->rememberToken();
            $table->timestamps();
        });
        
        DB::table('users')->insert([
        		'state_id' => 1,
                'name' => '編集部',
                'full_name' => 'CuteCampus編集部',
				'email' => 'cute@cute.com',
                'password' => bcrypt('cutecute'),
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        );
        
        DB::table('users')->insert([
        		'state_id' => 1,
                'name' => 'トライアル',
                'full_name' => 'トライアルトラ',
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
