<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldToClaimsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('claims', function(Blueprint $table)
		{
			$table->tinyInteger('missed_call')->nullbale()->after('status');
            $table->tinyInteger('without_contacts')->nullbale()->after('missed_call');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('claims', function(Blueprint $table)
		{
			$table->dropColumn('missed_call');
            $table->dropColumn('without_contacts');
		});
	}

}
