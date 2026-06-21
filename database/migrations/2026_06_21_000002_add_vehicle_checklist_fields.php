<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->unsignedBigInteger('mileage')->nullable()->after('color');
            $table->enum('fuel_level', ['empty', 'quarter', 'half', 'three_quarters'])->nullable()->after('mileage');
            $table->foreignId('assigned_mechanic_id')->nullable()->constrained('users')->nullOnDelete()->after('fuel_level');
            $table->foreignId('make_id')->nullable()->constrained('vehicle_makes')->nullOnDelete()->after('assigned_mechanic_id');
            $table->foreignId('model_id')->nullable()->constrained('vehicle_models')->nullOnDelete()->after('make_id');
        });
    }

    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropForeign(['assigned_mechanic_id']);
            $table->dropForeign(['make_id']);
            $table->dropForeign(['model_id']);
            $table->dropColumn(['mileage', 'fuel_level', 'assigned_mechanic_id', 'make_id', 'model_id']);
        });
    }
};
