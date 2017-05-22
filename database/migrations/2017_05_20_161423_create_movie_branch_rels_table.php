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
            $table->string('folder_name')->nullable()->default(NULL);
            $table->string('area_info')->nullable()->default(NULL);
            $table->boolean('combine_status');
        
            $table->timestamps();
        });
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
