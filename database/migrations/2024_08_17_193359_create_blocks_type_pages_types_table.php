<?php

use App\Models\BlocksType;
use App\Models\Page;
use App\Models\PagesType;
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
        Schema::create('blocks_type_pages_types', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(BlocksType::class)->constrained();
            $table->foreignIdFor(PagesType::class)->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blocks_type_pages_types');
    }
};
