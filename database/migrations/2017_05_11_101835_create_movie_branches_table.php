<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovieBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movie_branches', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('rel_id');
            
            $table->string('title')->nullable()->default(NULL);
            $table->string('second')->nullable()->default(NULL);
            
            $table->string('org_name')->nullable()->default(NULL);
            $table->float('duration')->nullable()->default(NULL);
            $table->string('movie_path')->nullable()->default(NULL);
            $table->string('sub_text')->nullable()->default(NULL);
            
            $table->integer('number')->nullable()->default(NULL);
            
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
        Schema::dropIfExists('movie_branches');
    }
}
