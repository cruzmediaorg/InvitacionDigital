<?php

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
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('home_h2_font_size');
            $table->dropColumn('home_h3_font_size');
            $table->dropColumn('body_h1_font_size');
            $table->dropColumn('body_h3_font_size');
        });

        Schema::table('themes', function (Blueprint $table) {
            $table->dropColumn('home_h2_font_size');
            $table->dropColumn('home_h3_font_size');
            $table->dropColumn('body_h1_font_size');
            $table->dropColumn('body_h3_font_size');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->integer('home_h2_font_size')->nullable();
            $table->integer('home_h3_font_size')->nullable();
            $table->integer('body_h1_font_size')->nullable();
            $table->integer('body_h3_font_size')->nullable();
        });

        Schema::table('themes', function (Blueprint $table) {
            $table->dropColumn('home_h2_font_size');
            $table->dropColumn('home_h3_font_size');
            $table->dropColumn('body_h1_font_size');
            $table->dropColumn('body_h3_font_size');
        });
    }
};
