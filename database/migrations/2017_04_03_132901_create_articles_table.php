<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('model_id');
            //$table->boolean('del_status');
            
            $table->integer('cate_id');
            $table->integer('movie_id');
            //$table->string('tag_id')->nullable()->default(NULL);
            $table->string('title')->nullable()->default(NULL);
            //$table->string('sub_title')->nullable()->default(NULL);
            $table->string('slug')->unique()->nullable()->default(NULL);
            $table->string('area_info')->nullable()->default(NULL);
            
            $table->string('post_thumb')->nullable()->default(NULL);
            
            $table->text('basic_info')->nullable()->default(NULL);
            
            $table->boolean('open_status');
            $table->timestamp('open_date')->nullable()->default(NULL);
            
            $table->boolean('yt_up');
            $table->boolean('sns_up');
            
            $table->integer('view_count');
            
            $table->timestamps();
        });
        
        $n = 0;
        while($n < 3) {
            DB::table('articles')->insert(
            	[
                    'model_id' => 2,
                    
                    'cate_id' => 1,
                    'movie_id' => 1,
                    'title' => 'みいたけのお気に入り-'. $n,
                    'slug' => 'miitake-favorite-'. $n,

					//'post_thumb' => '',
                    
                    'basic_info' =>'',
                   	
                    'open_status' => 1,
                    'open_date' => date('Y-m-d H:i:s', time()),
                    'view_count' => $n+3,
                    
                    'yt_up' => 0,
                	'sns_up' => 0,
                    
                    'created_at' => date('Y-m-d H:i:s', time()),
                    'updated_at' => date('Y-m-d H:i:s', time()),
                ]
            );
            
            $n++;
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
