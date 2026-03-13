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
        \Illuminate\Support\Facades\DB::statement('ALTER TABLE tipo_suelo MODIFY id_tipo_suelo INT UNSIGNED NOT NULL AUTO_INCREMENT');
    }

    public function down(): void
    {
        \Illuminate\Support\Facades\DB::statement('ALTER TABLE tipo_suelo MODIFY id_tipo_suelo INT UNSIGNED NOT NULL');
    }
};
