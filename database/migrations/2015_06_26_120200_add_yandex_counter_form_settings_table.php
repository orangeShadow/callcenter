<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddYandexCounterFormSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('form_settings', function(Blueprint $table)
        {
            $table->string('yandex_cn')->nullable();
            $table->string('yandex_goal')->nullable();
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
            $table->dropColumn('yandex_cn');
            $table->dropColumn('yandex_goal');
        });

	}

}
