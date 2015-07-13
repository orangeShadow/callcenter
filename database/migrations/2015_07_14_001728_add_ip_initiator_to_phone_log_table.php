<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIpInitiatorToPhoneLogTable extends Migration {

    public function up()
    {
        Schema::table('phone_logs', function(Blueprint $table)
        {
            $table->string('ip')->nullable();
            $table->integer('initiator')->nullable();
        });
    }


    public function down()
    {
        Schema::table('phone_logs', function(Blueprint $table)
        {
            $table->dropColumn('ip');
            $table->dropColumn('initiator');
        });
    }

}
