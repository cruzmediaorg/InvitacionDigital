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
        Schema::table('block_fields', function (Blueprint $table) {
            $table->longText('value')->nullable()->change();
        });
        Schema::table('block_types_fields', function (Blueprint $table) {
            $table->longText('default')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('block_fields', function (Blueprint $table) {
            $table->text('value')->nullable()->change();
        });
        Schema::table('block_types_fields', function (Blueprint $table) {
            $table->text('default')->nullable()->change();
        });
    }
};
