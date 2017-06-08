<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeatureCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feature_categories', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('name')->nullable()->default(NULL);
            $table->string('slug')->unique()->nullable()->default(NULL);
            $table->boolean('status')->default(1);
            
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
        Schema::dropIfExists('feature_categories');
    }
}
