<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('clients', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title');
            $table->string('href');
            $table->string('key',32);
            $table->string('sip',10);
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->unique('key');
            $table->index(['href','key']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('clients');
	}

}
