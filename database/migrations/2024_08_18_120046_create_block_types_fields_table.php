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
        Schema::create('block_types_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(BlocksType::class)->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('key');
            $table->string('type');
            $table->string('default')->nullable();
            $table->boolean('required')->default(false);
            $table->boolean('nullable')->default(true);
            $table->integer('order');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('block_types_fields');
    }
};
