<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactCatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_cates', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('cate_name');
            
            $table->timestamps();
        });
        
        DB::table('contact_cates')->insert([
                'cate_name' => 'モデル募集',

                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        );
        
        DB::table('contact_cates')->insert([
                'cate_name' => 'スタッフ募集',

                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        );
        
        DB::table('contact_cates')->insert([
                'cate_name' => '掲載・取材依頼',

                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        );
        
        DB::table('contact_cates')->insert([
                'cate_name' => 'お問合わせ',

                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        );
        
        DB::table('contact_cates')->insert([
                'cate_name' => 'その他',

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
        Schema::dropIfExists('contact_cates');
    }
}
