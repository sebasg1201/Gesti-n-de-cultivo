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
        Schema::table('tipo_cosecha', function (Blueprint $table) {
            $table->dropForeign('tipo_cosecha_ibfk_2');
            $table->renameColumn('id_riego', 'id_tipo_riego');
        });

        Schema::table('tipo_cosecha', function (Blueprint $table) {
            $table->foreign('id_tipo_riego')->references('id_tipo_riego')->on('tipo_riego');
        });
    }

    public function down(): void
    {
        Schema::table('tipo_cosecha', function (Blueprint $table) {
            $table->dropForeign(['id_tipo_riego']);
            $table->renameColumn('id_tipo_riego', 'id_riego');
        });

        Schema::table('tipo_cosecha', function (Blueprint $table) {
            $table->foreign('id_riego', 'tipo_cosecha_ibfk_2')->references('id_riego')->on('riego');
        });
    }
};
