<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

//use Illuminate\Support\Facades\Crypt;

class CreateTwAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tw_accounts', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('model_id');
            
            $table->string('name')->nullable()->default(NULL);
            $table->string('pass', 255)->nullable()->default(NULL);
            $table->string('consumer_key')->nullable()->default(NULL);
            $table->string('consumer_secret')->nullable()->default(NULL);
            $table->string('access_token')->nullable()->default(NULL);
            $table->string('access_token_secret')->nullable()->default(NULL);
            
            
//            $name = 'cute_campus'; //y.yamasaki@crepus.jp
//            //$pass = '14092ugaAC';
//            $v = Crypt::encrypt('14092ugaAC');
//            $pass = Crypt::decrypt($v);
//            
//            
//            $consumer_key = 'a50OiN3f4hoxXFSS2zK2j6mTK';
//            $consumer_secret = 'DKKhv9U1755hu0zzxbklyPA3GpuAsTTqedoNCFTUKyACshPuOE';
//            $access_token = '2515940671-scGnBAVUnURLykOpp0C9uxsmOz6zg1iTkILVqZa';
//            $access_token_secret = '7LMe9izK6Cu514gNnn3Kfl2f9QCtoFr5PLBg8oj0A9XTy';
            
            $table->timestamps();
        });
        
        
        DB::table('tw_accounts')->insert(
            [
                'model_id' => 1,
                
                'name' =>'cute_campus',
                'pass' => encrypt('14092ugaAC'),
                'consumer_key' => 'a50OiN3f4hoxXFSS2zK2j6mTK',
                'consumer_secret' => 'DKKhv9U1755hu0zzxbklyPA3GpuAsTTqedoNCFTUKyACshPuOE',
                'access_token' => '2515940671-scGnBAVUnURLykOpp0C9uxsmOz6zg1iTkILVqZa',
                'access_token_secret' => '7LMe9izK6Cu514gNnn3Kfl2f9QCtoFr5PLBg8oj0A9XTy',
                
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
        Schema::dropIfExists('tw_accounts');
    }
}
