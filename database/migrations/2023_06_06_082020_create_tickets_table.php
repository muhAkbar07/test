<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('priority_id')->index('priority_id');
            $table->unsignedBigInteger('outlet_id')->index('outlet_id');
            $table->unsignedBigInteger('unit_id')->index('tickets_unit_id_index');
            $table->unsignedBigInteger('owner_id')->index('owner_id');
            $table->unsignedBigInteger('problem_category_id')->index('problem_category_id');
            $table->string('title');
            $table->text('description');
            $table->string('asset_number')->nullable();
            $table->string('serial_number')->nullable();
            $table->unsignedBigInteger('ticket_statuses_id')->index('ticket_statuses_id');
            $table->unsignedBigInteger('responsible_id')->nullable()->index('responsible_id');
            $table->timestamps();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('solved_at')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
};