<?php

use App\Models\BlocksType;
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
        $blockType = BlocksType::where('name', 'Home')->first();

        if ($blockType) {
            $blockType->blockTypesFields()->create([
                'key' => 'main_image',
                'name' => 'Main Image',
                'default' => null,
                'type' => 'image',
                'order' => 6,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $blockType = BlocksType::where('name', 'Home')->first();

        if ($blockType) {
            $blockType->blockTypesFields()->where('name', 'main_image')->delete();
        }
    }
};
