<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('ticket_ref')->unique();
            $table->string('customer_name');
            $table->text('problem_description');
            $table->string('email');
            $table->string('phone_no', 25);
            $table->unsignedInteger('agent_id')->nullable();
            $table->unsignedTinyInteger('status')->default(0)->comment("0 => pending, 1 => opened, 2 => closed");
            $table->dateTime('read_at')->nullable();
            $table->timestamps();
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
}
