<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('name');
            $table->string('slug')->unique();
            
            $table->timestamps();
        });
        
//        $n = 0;
//        while($n < 2) {
            DB::table('categories')->insert([
                    'name' => 'レジャー',
                    'slug' => 'leisure',
                    'created_at' => date('Y-m-d H:i:s', time()),
                    'updated_at' => date('Y-m-d H:i:s', time()),
                ]
            );
            
            DB::table('categories')->insert([
                    'name' => 'ビューティー',
                    'slug' => 'beauty',
                    'created_at' => date('Y-m-d H:i:s', time()),
                    'updated_at' => date('Y-m-d H:i:s', time()),
                ]
            );
            
            DB::table('categories')->insert([
                    'name' => 'グルメ',
                    'slug' => 'gourmet',
                    'created_at' => date('Y-m-d H:i:s', time()),
                    'updated_at' => date('Y-m-d H:i:s', time()),
                ]
            );
            
//            $n++;
//        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
