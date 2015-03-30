<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('properties', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('title');
            $table->string('description',250);
            $table->string('type');

            $table->string('model_goal');
            $table->string('model_initiator');
            $table->integer('link_id')->nullable();

            $table->integer('sort');
            $table->boolean('multiple')->default(false);
            $table->json('values');
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
        Schema::drop('properties');
	}

}
