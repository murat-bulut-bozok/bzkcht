<?php

use App\Enums\VerifyNumberStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('verify_numbers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('device_id')->nullable();
            $table->unsignedBigInteger('contact_list_id')->nullable();
            $table->unsignedBigInteger('segment_id')->nullable();

            $table->string('name')->nullable();
            $table->integer('total_contact')->default(0);
            $table->integer('total_verify')->default(0);
            $table->integer('total_unverify')->default(0);

            $table->enum('status', VerifyNumberStatusEnum::values())
                  ->default(VerifyNumberStatusEnum::PROCESSING->value);

            $table->json('contact_list_ids')->nullable();
            $table->json('segment_ids')->nullable();

            $table->timestamps();

            // Foreign keys
            $table->foreign('client_id')
                ->references('id')
                ->on('clients')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('contact_list_id')
                ->references('id')
                ->on('contacts_lists')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('segment_id')
                ->references('id')
                ->on('segments')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verify_numbers');
    }
};
