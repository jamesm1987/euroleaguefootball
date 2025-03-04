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
        Schema::table('competitions', function (Blueprint $table) {
            $table->enum('type', ['league', 'cup'])->after('country');
            $table->unsignedBigInteger('winner_team_id')->nullable()->after('type');
            $table->foreign('winner_team_id')->references('id')->on('teams')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('competitions', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropForeign(['winner_team_id']);
            $table->dropColumn('winner_team_id');
        });
    }
};
