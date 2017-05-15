<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('askcate_id');
            $table->string('per_name');
            $table->string('per_email');
            $table->integer('age')->nullable()->default(NULL);
            $table->string('school')->nullable()->default(NULL);
            $table->string('tel_num')->nullable()->default(NULL);
            $table->string('post_num')->nullable()->default(NULL);
            $table->string('address')->nullable()->default(NULL);
			$table->string('pic_1')->nullable()->default(NULL);
            $table->string('pic_2')->nullable()->default(NULL);
            $table->text('context')->nullable()->default(NULL);
            
            $table->timestamps();
        });
        
        DB::table('contacts')->insert([
                'askcate_id' => 1,
                'per_name' => 'あいうえお',
                'per_email' => 'aaa@bbb.com',
                'school' => '愛媛大学',
                'tel_num' => '00-1111-2222',
                'context' => 'あいうえおかきくけこさしすせそ',

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
        Schema::dropIfExists('contacts');
    }
}
