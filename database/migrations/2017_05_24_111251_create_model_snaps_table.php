<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelSnapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('model_snaps', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('model_id');
            
            $table->string('snap_path')->nullable()->default(NULL);
            $table->string('ask')->nullable()->default(NULL);
            $table->text('answer')->nullable()->default(NULL);
    
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
        Schema::dropIfExists('model_snaps');
    }
}
