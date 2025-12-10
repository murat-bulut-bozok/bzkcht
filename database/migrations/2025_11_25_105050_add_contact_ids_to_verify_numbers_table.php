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
        Schema::table('verify_numbers', function (Blueprint $table) {
            // Add the contact_ids column, assuming it will store multiple IDs as JSON
            $table->json('contact_ids')->nullable()->after('device_id'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('verify_numbers', function (Blueprint $table) {
            $table->dropColumn('contact_ids');
        });
    }
};
