<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tipo_riego', function (Blueprint $table) {
            $table->string('id_empresa', 20)->nullable()->after('id_tipo_riego');
            $table->foreign('id_empresa')->references('id_empresa')->on('empresa')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('tipo_riego', function (Blueprint $table) {
            $table->dropForeign(['id_empresa']);
            $table->dropColumn('id_empresa');
        });
    }
};
