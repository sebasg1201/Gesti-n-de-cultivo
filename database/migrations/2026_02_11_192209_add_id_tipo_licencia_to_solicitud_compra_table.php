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
            $table->integer('id_tipo_licencia')->after('id_super_admin')->nullable();
            // Assuming 'tipo_licencia' table exists and 'id_tipo_licencia' is the PK.
            // If you wanted a foreign key constraint:
            // $table->foreign('id_tipo_licencia')->references('id_tipo_licencia')->on('tipo_licencia');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('solicitud_compra', function (Blueprint $table) {
            $table->dropColumn('id_tipo_licencia');
        });
    }
};
