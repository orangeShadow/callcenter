<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('roles', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('title',30);
            $table->string('code',30);
            $table->string('description',120)->nullable();
            $table->integer('sort')->nullabel();
            $table->boolean('visible')->default(true);
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
        Schema::drop('roles');
	}

}
