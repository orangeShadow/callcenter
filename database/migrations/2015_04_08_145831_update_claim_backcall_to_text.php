<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateClaimBackcallToText extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('claims', function($table)
        {
            $table->dropColumn("backcall_at");
        });

        Schema::table('claims', function($table)
        {
            $table->string("backcall_at");
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('claims', function($table)
        {
            $table->dropColumn("backcall_at");
        });

        Schema::table('claims', function($table)
        {
            $table->dateTime('backcall_at')->nullable();
        });
	}

}
