<?php

namespace Database\Seeders;

use App\Models\VehicleMake;
use App\Models\VehicleModel;
use Illuminate\Database\Seeder;

class VehicleMakeSeeder extends Seeder
{
    public function run(): void
    {
        $makes = [
            'Toyota' => ['Corolla', 'Camry', 'Hilux', 'Fortuner', 'Yaris', 'Etios', 'Rav4', 'Land Cruiser', 'Tacoma', 'Prado'],
            'Chevrolet' => ['Spark', 'Sail', 'Aveo', 'Onix', 'Cruze', 'Tracker', 'Tahoe', 'Silverado', 'D-Max', 'Captiva', 'Blazer', 'Malibu', 'Camaro'],
            'Ford' => ['Fiesta', 'Focus', 'Escape', 'Explorer', 'Ranger', 'F-150', 'Edge', 'Mustang', 'EcoSport'],
            'Hyundai' => ['Elantra', 'Accent', 'Tucson', 'Santa Fe', 'Grand i10', 'Grand i20', 'Creta', 'Sonata', 'Azera'],
            'Nissan' => ['Sentra', 'Versa', 'March', 'Frontier', 'NP300', 'Pathfinder', 'X-Trail', 'Murano', 'Altima'],
            'Suzuki' => ['Swift', 'Vitara', 'Grand Vitara', 'S-Cross', 'Ignis', 'Baleno', 'Jimny', 'Celerio'],
            'Volkswagen' => ['Jetta', 'Gol', 'Vento', 'Polo', 'T-Cross', 'Tiguan', 'Amarok', 'Beetle', 'Passat', 'Golf'],
            'Jeep' => ['Wrangler', 'Grand Cherokee', 'Cherokee', 'Renegade', 'Compass', 'Gladiator'],
            'Kia' => ['Rio', 'Picanto', 'Sportage', 'Sorento', 'Cerato', 'Forte', 'Soul', 'Mohave'],
            'Mitsubishi' => ['Lancer', 'Montero', 'Outlander', 'L200', 'ASX', 'Eclipse Cross'],
            'Renault' => ['Sandero', 'Logan', 'Duster', 'Koleos', 'Kwid', 'Stepway', 'Alaskan', 'Captur'],
            'Honda' => ['Civic', 'Accord', 'CR-V', 'HR-V', 'Pilot', 'Fit', 'Odyssey'],
            'Mazda' => ['Mazda2', 'Mazda3', 'Mazda6', 'CX-5', 'CX-3', 'CX-9', 'MX-5'],
            'Chrysler' => ['300', 'Town & Country', 'Pacific', 'Voyager'],
            'Dodge' => ['Challenger', 'Charger', 'Durango', 'Journey', 'Grand Caravan'],
            'Fiat' => ['Palio', 'Siena', 'Strada', 'Uno', 'Mobi', 'Toro'],
            'SsangYong' => ['Korando', 'Tivoli', 'Rexton', 'Korando Family', 'Actyon'],
            'Great Wall' => ['Wingle', 'Hover', 'M4', 'V200', 'Steed'],
            'Yamaha (Motos)' => ['XTZ 125', 'XTZ 250', 'FZ 16', 'MT-03', 'MT-07', 'YZF-R3', 'YZF-R6', 'BWS 125'],
            'Empire (Motos)' => ['Horse 250', 'Rider 200', 'Cargo 250', 'Speed 200'],
            'Bera (Motos)' => ['Scooter 150', 'BR 200', 'Motorcycle 250'],
            'Chery' => ['Chery Tiggo 2', 'Chery Tiggo 3', 'Chery Tiggo 5', 'Chery Tiggo 7', 'Chery Tiggo 8', 'Chery Arrizo 5', 'Chery Arrizo 6', 'Chery QQ', 'Chery eQ1', 'Chery iCar'],
            'Mopad' => ['Magnum 125', 'Magnum 150', 'City 125', 'City 150', 'Sport 200', 'Cross 250'],
        ];

        foreach ($makes as $makeName => $models) {
            $make = VehicleMake::create(['name' => $makeName]);
            foreach ($models as $modelName) {
                VehicleModel::create([
                    'vehicle_make_id' => $make->id,
                    'name' => $modelName,
                ]);
            }
        }
    }
}
