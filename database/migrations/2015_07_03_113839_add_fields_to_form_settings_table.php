<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToFormSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('form_settings', function(Blueprint $table)
		{
            $table->integer('page_count')->nullable();
            $table->integer('client_count_show')->nullable();
            $table->integer('visit_count')->nullable();
            $table->integer('site_time')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('form_settings', function(Blueprint $table)
		{
            $table->dropColumn('page_count');
            $table->dropColumn('client_count_show');
            $table->dropColumn('visit_count');
            $table->dropColumn('site_time');
		});
	}

}
