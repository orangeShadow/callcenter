<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatusClaimTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('status_claim', function(Blueprint $table)
        {
            $table->char('code',2)->unique();
            $table->string('title',30);
            $table->string('description',120)->nullable();
            $table->integer('sort')->nullable();
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
        Schema::drop('status_claim');
	}

}
