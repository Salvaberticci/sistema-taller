<?php

use App\Models\VehicleMake;
use App\Models\VehicleModel;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // ── Chery ──
        $chery = VehicleMake::firstOrCreate(['name' => 'Chery']);
        $cheryModels = [
            'Chery Tiggo 2', 'Chery Tiggo 3', 'Chery Tiggo 5', 'Chery Tiggo 7', 'Chery Tiggo 8',
            'Chery Arrizo 5', 'Chery Arrizo 6', 'Chery QQ', 'Chery eQ1', 'Chery iCar',
        ];
        foreach ($cheryModels as $model) {
            VehicleModel::firstOrCreate([
                'vehicle_make_id' => $chery->id,
                'name' => $model,
            ]);
        }

        // Rename old Chery models that were created without the "Chery " prefix
        \DB::table('vehicle_models')
            ->where('vehicle_make_id', $chery->id)
            ->where('name', 'Tiggo 2')
            ->update(['name' => 'Chery Tiggo 2']);
        \DB::table('vehicle_models')
            ->where('vehicle_make_id', $chery->id)
            ->where('name', 'Tiggo 3')
            ->update(['name' => 'Chery Tiggo 3']);
        \DB::table('vehicle_models')
            ->where('vehicle_make_id', $chery->id)
            ->where('name', 'Tiggo 5')
            ->update(['name' => 'Chery Tiggo 5']);
        \DB::table('vehicle_models')
            ->where('vehicle_make_id', $chery->id)
            ->where('name', 'Tiggo 7')
            ->update(['name' => 'Chery Tiggo 7']);
        \DB::table('vehicle_models')
            ->where('vehicle_make_id', $chery->id)
            ->where('name', 'Tiggo 8')
            ->update(['name' => 'Chery Tiggo 8']);
        \DB::table('vehicle_models')
            ->where('vehicle_make_id', $chery->id)
            ->where('name', 'Arrizo 5')
            ->update(['name' => 'Chery Arrizo 5']);
        \DB::table('vehicle_models')
            ->where('vehicle_make_id', $chery->id)
            ->where('name', 'Arrizo 6')
            ->update(['name' => 'Chery Arrizo 6']);
        \DB::table('vehicle_models')
            ->where('vehicle_make_id', $chery->id)
            ->where('name', 'QQ')
            ->update(['name' => 'Chery QQ']);
        \DB::table('vehicle_models')
            ->where('vehicle_make_id', $chery->id)
            ->where('name', 'eQ1')
            ->update(['name' => 'Chery eQ1']);
        \DB::table('vehicle_models')
            ->where('vehicle_make_id', $chery->id)
            ->where('name', 'iCar')
            ->update(['name' => 'Chery iCar']);

        // ── Mopad ──
        $mopad = VehicleMake::firstOrCreate(['name' => 'Mopad']);
        $mopadModels = ['Magnum 125', 'Magnum 150', 'City 125', 'City 150', 'Sport 200', 'Cross 250'];
        foreach ($mopadModels as $model) {
            VehicleModel::firstOrCreate([
                'vehicle_make_id' => $mopad->id,
                'name' => $model,
            ]);
        }
    }

    public function down(): void
    {
        // Not needed
    }
};
