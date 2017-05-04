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
            $table->integer('admin_id');
            $table->boolean('del_status');
            
            $table->integer('cate_id');
            $table->string('tag_id')->nullable()->default(NULL);
            $table->string('title');
            $table->string('slug')->unique();
            
            $table->string('thumbnail')->nullable()->default(NULL);
            
            $table->boolean('open_status');
            $table->timestamp('open_date')->nullable()->default(NULL);
            
            $table->integer('view_count');
            
            $table->timestamps();
        });
        
        $n = 0;
        while($n < 3) {
            DB::table('articles')->insert([
                    'admin_id' => 1,
                    'del_status' => 0,
                    
                    'cate_id' => 1,
                    'tag_id' => '1,3',
                    'title' => 'みいたけのお気に入り-'. $n,
                    'slug' => 'miitake-favorite-'. $n,

					'thumbnail' => '',
                   	
                    'open_status' => 1,
                    'open_date' => date('Y-m-d H:i:s', time()),
                    'view_count' => $n+3,
                    
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
