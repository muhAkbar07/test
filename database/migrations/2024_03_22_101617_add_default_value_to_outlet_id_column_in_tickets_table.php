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
        Schema::table('tickets', function (Blueprint $table) {
            $table->unsignedBigInteger('outlet_id')->default(1)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->unsignedBigInteger('outlet_id')->nullable(false)->change();
        });
    }
};