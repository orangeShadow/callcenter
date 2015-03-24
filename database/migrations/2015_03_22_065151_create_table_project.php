<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProject extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('projects', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title',120);
			$table->char('status',2);
			$table->text('text')->nullable();
			$table->text('note')->nullable();
			$table->integer('client_id')->unsigned()->nullable();
			$table->integer('manager_id')->unsigned()->nullable();
            $table->integer('update_by')->unsigned()->nullable();
			$table->timestamps();

			$table->foreign('client_id')
				  ->references('id')
				  ->on('users')
				  ->onDelete('SET NULL');

            $table->foreign('manager_id')
                ->references('id')
                ->on('users')
                ->onDelete('SET NULL');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('projects');
	}

}
