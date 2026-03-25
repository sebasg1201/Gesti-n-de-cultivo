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
        if (!Schema::hasColumn('insumo', 'created_at')) {
            Schema::table('insumo', function (Blueprint $table) {
                $table->timestamps();
            });
        }

        if (!Schema::hasColumn('terreno', 'created_at')) {
            Schema::table('terreno', function (Blueprint $table) {
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('insumo', function (Blueprint $table) {
            $table->dropTimestamps();
        });

        Schema::table('terreno', function (Blueprint $table) {
            $table->dropTimestamps();
        });
    }
};
