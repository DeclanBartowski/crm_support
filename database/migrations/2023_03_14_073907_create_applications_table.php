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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('comment')->nullable();
            $table->text('text_application')->nullable();
            $table->text('name_firm')->nullable();
            $table->date('date')->nullable();
            $table->date('chance_date')->nullable();
            $table->string('type_client')->nullable();
            $table->string('status')->nullable();
            $table->string('probability')->nullable();
            $table->string('from')->nullable();
            $table->boolean('active')->default(false);
            $table->boolean('archive')->default(false);
            $table->foreignId('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applications');
    }
};
