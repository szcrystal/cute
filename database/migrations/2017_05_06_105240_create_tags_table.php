<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('name');
            $table->string('slug')->unique();
            
            $table->timestamps();
        });
        
        $n = 0;
        while($n < 2) {
            DB::table('tags')->insert([
                    'name' => '古着_'.$n,
                    'slug' => 'old-fas-'.$n,
                    //'view_count' => $n+5,
                    'created_at' => date('Y-m-d H:i:s', time()),
                    'updated_at' => date('Y-m-d H:i:s', time()),
                ]
            );
            
            DB::table('tags')->insert([
                    'name' => '松山_'.$n,
                    'slug' => 'matsuyama-'.$n,
                    'created_at' => date('Y-m-d H:i:s', time()),
                    'updated_at' => date('Y-m-d H:i:s', time()),
                ]
            );
            
            DB::table('tags')->insert([
                    'name' => 'パン_'.$n,
                    'slug' => 'bread-'.$n,
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
        Schema::dropIfExists('tags');
    }
}
