<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('insumo', function (Blueprint $table) {
            $table->string('tipo_insumo')->nullable()->after('Nombre')
                ->comment('Semillas, Abono, Químicos, Venenos/Plaguicidas, Herbicidas, Fungicidas, Herramientas, Otro');
        });
    }

    public function down(): void
    {
        Schema::table('insumo', function (Blueprint $table) {
            $table->dropColumn('tipo_insumo');
        });
    }
};
