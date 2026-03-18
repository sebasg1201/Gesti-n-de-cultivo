<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Insertar el estado "En Proceso" con id 17
        DB::table('estado')->insertOrIgnore([
            'id_estado' => 17,
            'nombre_estado' => 'En Proceso',
        ]);
    }

    public function down(): void
    {
        DB::table('estado')->where('id_estado', 17)->delete();
    }
};
