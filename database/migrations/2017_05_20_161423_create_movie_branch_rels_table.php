<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovieBranchRelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movie_branch_rels', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('model_id');
            $table->integer('cate_id');
            //$table->integer('music_id');
            //$table->integer('filter_id');
            $table->string('memo')->nullable()->default(NULL);
            $table->string('folder_name')->nullable()->default(NULL);
            $table->string('area_info')->nullable()->default(NULL);
            $table->boolean('combine_status');
            $table->boolean('complete');
        
            $table->timestamps();
        });
        
//        DB::table('movie_branch_rels')->insert([
//                'model_id' => 2,
//                'cate_id' => 1,
//
//                'memo' => 'abcde',
//                'floder_name' => '11111',
//                'area_info' => '',
//                
//                'combine_status' => 0,
//                //'movie_thumb' => '',
//                'complete' => 0,
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
        Schema::dropIfExists('movie_branch_rels');
    }
}
