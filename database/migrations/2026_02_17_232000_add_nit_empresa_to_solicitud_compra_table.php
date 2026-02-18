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
        Schema::table('solicitud_compra', function (Blueprint $table) {
            $table->string('nit_empresa', 14)->after('id_solicitud')->nullable();
            
            // Adding foreign key constraint
            $table->foreign('nit_empresa')
                  ->references('id_empresa')
                  ->on('empresa')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('solicitud_compra', function (Blueprint $table) {
            $table->dropForeign(['nit_empresa']);
            $table->dropColumn('nit_empresa');
        });
    }
};
