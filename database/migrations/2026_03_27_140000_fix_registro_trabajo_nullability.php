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
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE registro_trabajo MODIFY id_fase INT(11) NULL");
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE registro_trabajo MODIFY id_riego INT(11) NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE registro_trabajo MODIFY id_fase INT(11) NOT NULL");
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE registro_trabajo MODIFY id_riego INT(11) NOT NULL");
    }
};
