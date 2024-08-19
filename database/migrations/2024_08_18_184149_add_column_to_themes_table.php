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
        Schema::table('themes', function (Blueprint $table) {
            $table->string('h_text_color')->nullable();
            $table->string('p_text_color')->nullable();
            $table->string('h_font_family')->nullable();
            $table->string('p_font_family')->nullable();
            $table->string('h1_font_size')->nullable();
            $table->string('h2_font_size')->nullable();
            $table->string('h3_font_size')->nullable();
            $table->string('p_font_size')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('themes', function (Blueprint $table) {
            $table->dropColumn('h_text_color');
            $table->dropColumn('p_text_color');
            $table->dropColumn('h_font_family');
            $table->dropColumn('p_font_family');
            $table->dropColumn('h1_font_size');
            $table->dropColumn('h2_font_size');
            $table->dropColumn('h3_font_size');
            $table->dropColumn('p_font_size');
        });
    }
};
