<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteSendMailFromClaimTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('claims',function(Blueprint $table){
            $table->dropColumn('send_mail');

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
            $table->boolean('send_mail')->default(1);
        });
	}

}
