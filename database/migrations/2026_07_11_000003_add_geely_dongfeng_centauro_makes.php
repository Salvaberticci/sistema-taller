<?php

use App\Models\VehicleMake;
use App\Models\VehicleModel;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $brands = [
            'Geely' => ['Emgrand', 'Azkarra', 'Coolray', 'Tugella', 'Okavango', 'Geometry C', 'Xingyue', 'Binrui', 'Boyue', 'Monjaro'],
            'Dongfeng' => ['AX4', 'AX7', 'S30', 'H30', '580', 'Glory 580', 'Fengon 500', 'Fengon 580', 'Fengon S560', 'Fengshun'],
            'Centauro' => ['King 150', 'King 200', 'Raptor 150', 'Raptor 250', 'Thunder 200', 'Titan 150', 'Titan 200', 'GT 150'],
        ];

        foreach ($brands as $makeName => $models) {
            $make = VehicleMake::firstOrCreate(['name' => $makeName]);
            foreach ($models as $modelName) {
                VehicleModel::firstOrCreate([
                    'vehicle_make_id' => $make->id,
                    'name' => $modelName,
                ]);
            }
        }
    }

    public function down(): void
    {
        // Not needed
    }
};
