<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('form_settings', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('client_id');
            $table->integer('colors')->default(1);
            $table->integer('top')->nullable();
            $table->integer('sop_interval')->nullable(); //s
            $table->integer('swe_interval')->nullable();
            $table->string('time_work')->nullable();
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
		Schema::drop('form_settings');
	}

}
