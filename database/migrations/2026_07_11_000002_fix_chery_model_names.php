<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $cheryId = \DB::table('vehicle_makes')->where('name', 'Chery')->value('id');
        if ($cheryId) {
            \DB::statement("UPDATE vehicle_models SET name = REPLACE(name, 'Chery ', '') WHERE vehicle_make_id = ? AND name LIKE 'Chery %'", [$cheryId]);
        }
    }

    public function down(): void
    {
        // Not needed
    }
};
