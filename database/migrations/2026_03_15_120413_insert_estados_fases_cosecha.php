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
        DB::table('estado')->insert([
            ['nombre_estado' => 'Siembra'],
            ['nombre_estado' => 'Vegetativo'],
            ['nombre_estado' => 'Floración'],
            ['nombre_estado' => 'Llenado'],
            ['nombre_estado' => 'Cosecha'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('estado')->whereIn('nombre_estado', [
            'Siembra',
            'Vegetativo',
            'Floración',
            'Llenado',
            'Cosecha',
        ])->delete();
    }
};
