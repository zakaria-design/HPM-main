<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
        public function up()
    {
        Schema::table('skt', function (Blueprint $table) {
            $table->string('marketing')->after('nama_customer');
        });
    }

    public function down()
    {
        Schema::table('skt', function (Blueprint $table) {
            $table->dropColumn('marketing');
        });
    }
};
