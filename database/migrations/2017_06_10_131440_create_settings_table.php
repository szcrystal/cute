<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('all_area');
            $table->string('name')->nullable()->default(NULL);
            $table->string('email')->nullable()->default(NULL);
            $table->text('mail_header')->nullable()->default(NULL);
            $table->text('mail_footer')->nullable()->default(NULL);
            
            $table->integer('snap_count');
            $table->integer('item_count');
            
            $table->timestamps();
        });
        
        DB::table('settings')->insert(
            [
            	'all_area' => '四国',
                'snap_count' => 7,
                'item_count' => 7,
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
        Schema::dropIfExists('settings');
    }
}
