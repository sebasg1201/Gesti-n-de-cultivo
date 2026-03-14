<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ya se aplicó manualmente vía Tinker:
        // DB::statement('ALTER TABLE riego MODIFY COLUMN fecha_programada DATETIME');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // DB::statement('ALTER TABLE riego MODIFY COLUMN fecha_programada DATE');
    }
};
