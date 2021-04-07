<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_messages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->morphs('notifiable');
            $table->string('status')->nullable();
            $table->string('message_id')->index()->nullable();
            $table->string('tag')->nullable();
            $table->string('to')->nullable();
            $table->integer('opens')->default(0);
            $table->integer('clicks')->default(0);
            $table->timestamp('last_open_at')->nullable();
            $table->timestamp('last_click_at')->nullable();
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
        Schema::dropIfExists('mail_messages');
    }
}
