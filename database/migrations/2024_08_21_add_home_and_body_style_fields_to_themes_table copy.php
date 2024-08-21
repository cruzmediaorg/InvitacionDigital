<?php

use App\Models\Theme;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('themes', function (Blueprint $table) {
            // Home styles
            $table->string('home_h_text_color')->nullable();
            $table->string('home_p_text_color')->nullable();
            $table->string('home_h_font_family')->nullable();
            $table->string('home_p_font_family')->nullable();
            $table->integer('home_h1_font_size')->nullable();
            $table->integer('home_h2_font_size')->nullable();
            $table->integer('home_h3_font_size')->nullable();
            $table->integer('home_p_font_size')->nullable();

            // Body styles
            $table->string('body_h_text_color')->nullable();
            $table->string('body_p_text_color')->nullable();
            $table->string('body_h_font_family')->nullable();
            $table->string('body_p_font_family')->nullable();
            $table->integer('body_h1_font_size')->nullable();
            $table->integer('body_h2_font_size')->nullable();
            $table->integer('body_h3_font_size')->nullable();
            $table->integer('body_p_font_size')->nullable();
        });

        foreach (Theme::all() as $theme) {
            $theme->update([
                // Home
                'home_h_text_color' => $theme->h_text_color,
                'home_p_text_color' => $theme->p_text_color,
                'home_h_font_family' => $theme->h_font_family,
                'home_p_font_family' => $theme->p_font_family,
                'home_h1_font_size' => $theme->h1_font_size,
                'home_h2_font_size' => $theme->h2_font_size,
                'home_h3_font_size' => $theme->h3_font_size,
                'home_p_font_size' => $theme->p_font_size,

                // Body
                'body_h_text_color' => $theme->h_text_color,
                'body_p_text_color' => $theme->p_text_color,
                'body_h_font_family' => $theme->h_font_family,
                'body_p_font_family' => $theme->p_font_family,
                'body_h1_font_size' => $theme->h1_font_size,
                'body_h2_font_size' => $theme->h2_font_size,
                'body_h3_font_size' => $theme->h3_font_size,
                'body_p_font_size' => $theme->p_font_size,
            ]);
        }

        // drop old columns
        Schema::table('themes', function (Blueprint $table) {
            $table->dropColumn([
                'h_text_color', 'p_text_color', 'h_font_family', 'p_font_family',
                'h1_font_size', 'h2_font_size', 'h3_font_size', 'p_font_size',
            ]);
        });

        
    }

    public function down()
    {
        Schema::table('themes', function (Blueprint $table) {
            $table->dropColumn([
                'home_h_text_color', 'home_p_text_color', 'home_h_font_family', 'home_p_font_family',
                'home_h1_font_size', 'home_h2_font_size', 'home_h3_font_size', 'home_p_font_size',
                'body_h_text_color', 'body_p_text_color', 'body_h_font_family', 'body_p_font_family',
                'body_h1_font_size', 'body_h2_font_size', 'body_h3_font_size', 'body_p_font_size',
            ]);

            // add old columns
            $table->string('h_text_color')->nullable();
            $table->string('p_text_color')->nullable();
            $table->string('h_font_family')->nullable();
            $table->string('p_font_family')->nullable();
            $table->integer('h1_font_size')->nullable();
            $table->integer('h2_font_size')->nullable();
            $table->integer('h3_font_size')->nullable();
            $table->integer('p_font_size')->nullable();
        });
    }
};