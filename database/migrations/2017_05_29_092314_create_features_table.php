<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('features', function (Blueprint $table) {
            $table->increments('id');
            
            //$table->integer('model_id');
            
            $table->string('title')->nullable()->default(NULL);
            $table->string('slug')->unique()->nullable()->default(NULL);
            $table->string('address')->nullable()->default(NULL);
            $table->string('movie_path')->nullable()->default(NULL);
            $table->string('thumb_path')->nullable()->default(NULL);
            $table->string('contents')->nullable()->default(NULL);
            $table->boolean('open_status')->default(1);
            $table->integer('view_count')->nullable()->default(0);;
            
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
        Schema::dropIfExists('features');
    }
}
