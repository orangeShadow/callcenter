<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPhonesTextSongFieldsToFormSettingsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('form_settings', function(Blueprint $table)
        {
            $table->string('defaultPhone')->nullable();
            $table->text('phones')->nullable();
            $table->string('textA')->nullable();
            $table->string('textB')->nullable();
            $table->string('audioFileA')->nullable();
            $table->string('audioFileB')->nullable();
            $table->boolean('record')->default(true);
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
            $table->dropColumn('defaultPhone');
            $table->dropColumn('phones');
            $table->dropColumn('textA');
            $table->dropColumn('textB');
            $table->dropColumn('audioFileA');
            $table->dropColumn('audioFileB');
            $table->dropColumn('record');
        });

    }


}
