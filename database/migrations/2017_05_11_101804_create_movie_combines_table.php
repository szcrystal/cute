<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovieCombinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movie_combines', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('model_id');
            $table->integer('cate_id');
            $table->integer('rel_id');
            $table->integer('music_id');
            $table->integer('filter_id');
            
            $table->string('movie_path')->nullable()->default(NULL);
            //$table->string('movie_thumb')->nullable()->default(NULL);
            $table->string('area')->nullable()->default(NULL);
            $table->string('title')->nullable()->default(NULL);
            
            //$table->text('basic_info')->nullable()->default(NULL);
            
            $table->boolean('atcl_status')->nullable()->default(NULL);
            
//            $table->boolean('yt_up');
//            $table->boolean('sns_up');
            
            //$table->integer('view_count');
            
            $table->timestamps();
        });
        
//        DB::table('movie_combines')->insert([
//                'model_id' => 2,
//                'cate_id' => 1,
//                'rel_id' => 99999,
//                'music_id' => 1,
//                'filter_id' => 1,
//                
//                'movie_path' => 'public/movie/1/20170101.mp4',
//                //'movie_thumb' => '',
//                'area' => '愛媛',
//                'title' => 'みいたけのお気に入り',
//                
//                'atcl_status' => 0,
////                'yt_up' => 0,
////                'sns_up' => 0,
//                
//                'created_at' => date('Y-m-d H:i:s', time()),
//                'updated_at' => date('Y-m-d H:i:s', time()),
//            ]
//        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movie_combines');
    }
}
