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
        Schema::table('cultivo', function (Blueprint $table) {
            if (!Schema::hasColumn('cultivo', 'id_estado')) {
                $table->integer('id_estado')->default(1)->after('id_cosecha');
            }
        });

        Schema::table('registro_trabajo', function (Blueprint $table) {
            if (!Schema::hasColumn('registro_trabajo', 'id_cultivo')) {
                $table->integer('id_cultivo')->nullable()->after('id_insumo_cosecha');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('cultivo', 'id_estado')) {
            DB::statement('ALTER TABLE cultivo DROP COLUMN id_estado');
        }

        if (Schema::hasColumn('registro_trabajo', 'id_cultivo')) {
            DB::statement('ALTER TABLE registro_trabajo DROP COLUMN id_cultivo');
        }
    }
};
