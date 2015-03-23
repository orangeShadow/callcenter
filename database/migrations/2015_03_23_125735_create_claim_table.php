<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClaimTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('claim', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name',120);
            $table->char('phone',2);
            $table->text('text')->nullable();
            $table->text('note')->nullable();
            $table->integer('project_id')->unsigned()->nullable();
            $table->dateTime('backcall_at')->nullable();
            $table->char('status',2);
            $table->timestamps();

            $table->foreign('project_id')
                ->references('id')
                ->on('projects')
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
        Schema::drop('claim');
    }

}
