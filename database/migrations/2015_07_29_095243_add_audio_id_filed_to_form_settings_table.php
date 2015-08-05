<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAudioIdFiledToFormSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('form_settings', function(Blueprint $table) {
            $table->string('audioIdA')->nullable();
            $table->string('audioIdB')->nullable();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('form_settings', function(Blueprint $table) {
            $table->dropColumn('audioIdA');
            $table->dropColumn('audioIdB');
        });
	}

}
