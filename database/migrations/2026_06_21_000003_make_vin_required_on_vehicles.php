<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Set a temporary VIN for existing vehicles that have none
        DB::statement("UPDATE vehicles SET vin = CONCAT('TMP', LPAD(id, 13, '0')) WHERE vin IS NULL OR vin = ''");
        // Truncate any VINs longer than 17 chars
        DB::statement("UPDATE vehicles SET vin = UPPER(LEFT(vin, 17)) WHERE LENGTH(vin) > 17");

        Schema::table('vehicles', function (Blueprint $table) {
            $table->string('vin', 17)->nullable(false)->change();
        });

        // Add unique index on vin
        Schema::table('vehicles', function (Blueprint $table) {
            $table->unique('vin');
        });
    }

    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropUnique(['vin']);
        });

        Schema::table('vehicles', function (Blueprint $table) {
            $table->string('vin', 50)->nullable()->change();
        });
    }
};
