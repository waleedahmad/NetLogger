<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIpInfoToIpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ip', function (Blueprint $table) {
            $table->string('city')->after('ip')->nullable();
            $table->string('country')->after('city')->nullable();
            $table->string('region')->after('country')->nullable();
            $table->string('postal')->after('region')->nullable();
            $table->string('loc')->after('postal')->nullable();
            $table->string('org')->after('loc')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ip', function (Blueprint $table) {
            $table->dropColumn('city');
            $table->dropColumn('country');
            $table->dropColumn('postal');
            $table->dropColumn('loc');
            $table->dropColumn('org');
            $table->dropColumn('region');

        });
    }
}
