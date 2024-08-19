<?php

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
        Schema::create('onboarding_forms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('component')->nullable();
            $table->integer('order')->default(1);
            $table->foreignIdFor(PagesType::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('onboarding_forms');
    }
};
