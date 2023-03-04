<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('date')->nullable();
            $table->text('sport')->nullable();
            $table->time('sport_time')->nullable();
            $table->text('additional_info')->nullable();
            $table->foreignId('customer_id')->nullable();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreignId('platform_id')->nullable();
            $table->foreign('platform_id')->references('id')->on('platforms')->onDelete('cascade');
            $table->foreignId('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('attachment_to_agreement')->nullable();
            $table->boolean('is_canceled')->default(0);
            $table->text('cancel_reason')->nullable();
            $table->text('cancel_reason_official')->nullable();
            $table->string('cancel_stage')->nullable();
            $table->string('cancel_reason_list')->nullable();
            $table->boolean('is_agreement')->default(0);
            $table->boolean('is_payed')->default(0);
            $table->boolean('is_archive')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
};
