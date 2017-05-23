<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_items', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('cate_id')->nullable()->default(NULL);
			$table->integer('item_num')->nullable()->default(NULL);
            $table->string('title')->nullable()->default(NULL);
            $table->integer('second')->nullable()->default(NULL);
            
            $table->timestamps();
        });
        
        DB::table('category_items')->insert(
            [
                'cate_id' => 1,
                'item_num' => 1,
                'title' => '行きの道中',
                'second' => 5,
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        );
        
        DB::table('category_items')->insert(
            [
                'cate_id' => 1,
                'item_num' => 2,
                'title' => '到着',
                'second' => 3,
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        );
        
        DB::table('category_items')->insert(
            [
                'cate_id' => 1,
                'item_num' => 3,
                'title' => '体験',
                'second' => 15,
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        );
        
        DB::table('category_items')->insert(
            [
                'cate_id' => 1,
                'item_num' => 4,
                'title' => '感想',
                'second' => 10,
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        );
        
        DB::table('category_items')->insert(
            [
                'cate_id' => 1,
                'item_num' => 5,
                'title' => '帰り',
                'second' => 3,
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
        Schema::dropIfExists('category_items');
    }
}
