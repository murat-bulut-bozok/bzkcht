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
        Schema::table('messages', function (Blueprint $table) {
            // Add nullable column
            $table->unsignedBigInteger('web_template_id')->nullable()->after('template_id');

            // Add foreign key constraint
            $table->foreign('web_template_id')
                  ->references('id')
                  ->on('web_templates')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign(['web_template_id']);
            $table->dropColumn('web_template_id');
        });
    }
};
