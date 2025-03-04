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
        Schema::create('rule_scenarios', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\PointRule::class)->onDelete('cascade');
    
            $table->json('conditions');
            $table->json('actions');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rule_scenarios');
    }
};
