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
        Schema::table('solicitud_compra', function (Blueprint $table) {
            // Assuming 'tipo_licencia' is the table name and 'id_tipo_licencia' is the PK key.
            // Also assuming both are compatible types (likely unsigned big integer or integer).
            // Based on previous sql dump, 'tipo_licencia' -> 'id_tipo_licencia' is 'int(14)'.
            // 'solicitud_compra' -> 'id_tipo_licencia' was created as 'integer' (int 11 usually).
            // We might need to ensure types match exactly. 
            // However, Laravel's integer() usually creates INT.

            $table->foreign('id_tipo_licencia')
                ->references('id_tipo_licencia')
                ->on('tipo_licencia')
                ->onDelete('set null'); // or cascade/restrict depending on requirement. Set null is safer if license types are deleted.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('solicitud_compra', function (Blueprint $table) {
            $table->dropForeign(['id_tipo_licencia']);
        });
    }
};
