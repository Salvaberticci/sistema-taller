<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Vehicle;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VehicleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Create an authenticated user
        $user = User::factory()->create();
        $this->actingAs($user);
    }

    public function test_license_plate_is_automatically_uppercased_on_save(): void
    {
        $customer = Customer::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '04123456789',
            'address' => 'Caracas, Venezuela',
        ]);

        $vehicle = Vehicle::create([
            'customer_id' => $customer->id,
            'make' => 'Toyota',
            'model' => 'Corolla',
            'year' => 2022,
            'license_plate' => 'abc-123-xy',
            'color' => 'Red',
        ]);

        // Check it was stored as uppercase in the database
        $this->assertDatabaseHas('vehicles', [
            'id' => $vehicle->id,
            'license_plate' => 'ABC-123-XY',
        ]);
    }

    public function test_can_register_vehicle_via_controller_with_lowercase_plate_and_it_becomes_uppercase(): void
    {
        $customer = Customer::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'phone' => '04129876543',
            'address' => 'Caracas, Venezuela',
        ]);

        $response = $this->post(route('vehicles.store'), [
            'customer_id' => $customer->id,
            'make' => 'Chevrolet',
            'model' => 'Aveo',
            'year' => 2015,
            'license_plate' => 'def456gh',
            'color' => 'Blue',
        ]);

        $response->assertRedirect(route('vehicles.index'));
        $this->assertDatabaseHas('vehicles', [
            'license_plate' => 'DEF456GH',
        ]);
    }

    public function test_can_register_vehicle_with_photos(): void
    {
        \Illuminate\Support\Facades\Storage::fake('public');

        $customer = Customer::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'phone' => '04129876543',
            'address' => 'Caracas, Venezuela',
        ]);

        $file1 = \Illuminate\Http\UploadedFile::fake()->image('car1.jpg');
        $file2 = \Illuminate\Http\UploadedFile::fake()->image('car2.png');

        $response = $this->post(route('vehicles.store'), [
            'customer_id' => $customer->id,
            'make' => 'Chevrolet',
            'model' => 'Aveo',
            'year' => 2015,
            'license_plate' => 'ABC-999-ZZ',
            'color' => 'Blue',
            'photos' => [$file1, $file2]
        ]);

        $response->assertRedirect(route('vehicles.index'));
        
        $vehicle = Vehicle::where('license_plate', 'ABC-999-ZZ')->firstOrFail();
        $this->assertCount(2, $vehicle->photos()->get());

        // Assert files were stored
        foreach ($vehicle->photos()->get() as $photo) {
            \Illuminate\Support\Facades\Storage::disk('public')->assertExists($photo->photo_path);
        }
    }

    public function test_can_upload_photos_via_store_photos_endpoint(): void
    {
        \Illuminate\Support\Facades\Storage::fake('public');

        $customer = Customer::create([
            'name' => 'John Smith',
            'email' => 'johnsmith@example.com',
            'phone' => '04121111111',
            'address' => 'Caracas, Venezuela',
        ]);

        $vehicle = Vehicle::create([
            'customer_id' => $customer->id,
            'make' => 'Ford',
            'model' => 'Fiesta',
            'year' => 2018,
            'license_plate' => 'XYZ-777-BB',
            'color' => 'Black',
        ]);

        $file = \Illuminate\Http\UploadedFile::fake()->image('engine.jpg');

        $response = $this->post(route('vehicles.photos.store', $vehicle->id), [
            'photos' => [$file],
        ]);

        $response->assertRedirect();
        
        $vehicle->refresh();
        $this->assertCount(1, $vehicle->photos()->get());
        
        $photo = $vehicle->photos()->first();
        \Illuminate\Support\Facades\Storage::disk('public')->assertExists($photo->photo_path);
    }
}

