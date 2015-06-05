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
            $table->integer('client_id')->unsigned();
            $table->integer('colors')->default(1);
            $table->integer('top')->nullable();
            $table->integer('sop_interval')->nullable(); //set open interval
            $table->integer('swe_interval')->nullable(); //set waiting interval
            $table->string('time_work')->nullable(); //time work json start : end
			$table->timestamps();

            $table->primary('client_id');
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
