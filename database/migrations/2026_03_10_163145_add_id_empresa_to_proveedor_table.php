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
        Schema::table('proveedor', function (Blueprint $table) {
            $table->string('id_empresa', 20)->nullable()->after('id_proveedor');
            // Adding index to improve query performance since it will be filtered by id_empresa
            $table->index('id_empresa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proveedor', function (Blueprint $table) {
            $table->dropIndex(['id_empresa']);
            $table->dropColumn('id_empresa');
        });
    }
};
