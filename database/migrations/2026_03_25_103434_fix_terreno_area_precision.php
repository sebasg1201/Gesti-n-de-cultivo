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
        // Limpiar fechas inválidas que causan error en modo estricto de MySQL
        \Illuminate\Support\Facades\DB::statement("UPDATE terreno SET updated_at = NULL WHERE CAST(updated_at AS CHAR) = '0000-00-00 00:00:00'");
        \Illuminate\Support\Facades\DB::statement("UPDATE terreno SET created_at = NOW() WHERE CAST(created_at AS CHAR) = '0000-00-00 00:00:00'");
        
        \Illuminate\Support\Facades\DB::statement('ALTER TABLE terreno MODIFY area_m2 DECIMAL(15,2) NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('terreno', function (Blueprint $table) {
            //
        });
    }
};
