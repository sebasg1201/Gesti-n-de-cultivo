<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('insumo', function (Blueprint $table) {
            // Drop old columns if they exist
            if (Schema::hasColumn('insumo', 'producto')) {
                $table->dropColumn('producto');
            }
            if (Schema::hasColumn('insumo', 'tipo_insumo')) {
                $table->dropColumn('tipo_insumo');
            }

            $table->unsignedBigInteger('id_tipo_insumo')->nullable()->after('Nombre');
            $table->foreign('id_tipo_insumo')->references('id_tipo_insumo')->on('tipo_insumo')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('insumo', function (Blueprint $table) {
            $table->dropForeign(['id_tipo_insumo']);
            $table->dropColumn('id_tipo_insumo');
            $table->string('producto')->nullable();
        });
    }
};
