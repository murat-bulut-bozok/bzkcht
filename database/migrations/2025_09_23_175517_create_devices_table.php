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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->string('name'); 
            $table->string('whatsapp_session')->nullable();  
            $table->string('phone_number');                 
            $table->string('jid')->nullable();            
            $table->enum('status', ['pending', 'needs_qr_scan', 'connected', 'logged_out', 'blocked'])->default('pending');
            $table->boolean('account_protection')->default(true);
            $table->boolean('message_logging')->default(true);
            $table->boolean('read_incoming')->default(false);
            $table->string('webhook_url')->nullable();
            $table->timestamp('connected_at')->nullable();
            $table->timestamp('disconnected_at')->nullable();
            $table->tinyInteger('active_for_chat')->default(0)->comment('0 inactive, 1 active');
            $table->timestamp('active_for_chat_time')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('devices');
    }
};
