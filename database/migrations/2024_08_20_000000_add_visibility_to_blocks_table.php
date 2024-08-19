<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blocks', function (Blueprint $table) {
            $table->boolean('is_visible')->default(true)->after('order');
        });
    }

    public function down(): void
    {
        Schema::table('blocks', function (Blueprint $table) {
            $table->dropColumn('is_visible');
        });
    }
};