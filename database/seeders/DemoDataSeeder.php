<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample Customer
        $customer = \App\Models\Customer::create([
            'name' => 'Juan Pérez',
            'email' => 'juan@example.com',
            'phone' => '123456789',
            'address' => 'Calle Principal 123'
        ]);

        // Sample Vehicle
        $vehicle = \App\Models\Vehicle::create([
            'customer_id' => $customer->id,
            'make' => 'Toyota',
            'model' => 'Corolla',
            'year' => 2022,
            'license_plate' => 'AB123CD',
            'color' => 'Gris'
        ]);

        // Sample Parts
        \App\Models\Part::create([
            'name' => 'Filtro de Aceite',
            'sku' => 'OIL-FIL-001',
            'stock' => 50,
            'price' => 15.50,
            'category' => 'Filtros'
        ]);

        \App\Models\Part::create([
            'name' => 'Pastillas de Freno',
            'sku' => 'BRA-PAD-001',
            'stock' => 10,
            'price' => 45.00,
            'category' => 'Frenos'
        ]);
    }
}
