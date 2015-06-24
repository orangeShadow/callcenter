<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToClaims extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('claims',function(Blueprint $table){
            $table->integer('type_request')->nullable();
            $table->boolean('send_mail')->default(1);
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('claims',function(Blueprint $table){
            $table->dropColumn('type_request');
            $table->dropColumn('send_mail');
        });
	}

}
