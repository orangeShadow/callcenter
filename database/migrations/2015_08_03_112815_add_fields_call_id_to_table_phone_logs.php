<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsCallIdToTablePhoneLogs extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('phone_logs', function(Blueprint $table)
		{
		    $table->string('call_id',64)->nullable();
            $table->increments('id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('phone_logs', function(Blueprint $table)
		{
			$table->dropColumn('call_id');
            $table->dropColumn('id');
		});
	}

}
