<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Create an authenticated user
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->withoutExceptionHandling();
    }

    public function test_can_register_customer_with_id_card(): void
    {
        $response = $this->post(route('customers.store'), [
            'name' => 'John Doe',
            'id_card' => 'V-99999999',
            'email' => 'john@example.com',
            'phone' => '04123456789',
            'address' => 'Caracas, Venezuela',
        ]);

        $response->assertRedirect(route('customers.index'));
        $this->assertDatabaseHas('customers', [
            'name' => 'John Doe',
            'id_card' => 'V-99999999',
        ]);
    }

    public function test_can_update_customer_id_card(): void
    {
        $customer = Customer::create([
            'name' => 'Jane Smith',
            'id_card' => 'V-11111111',
            'email' => 'jane@example.com',
            'phone' => '04149876543',
            'address' => 'Maracaibo, Venezuela',
        ]);

        $response = $this->put(route('customers.update', $customer->id), [
            'name' => 'Jane Smith Updated',
            'id_card' => 'V-22222222',
            'email' => 'jane@example.com',
            'phone' => '04149876543',
            'address' => 'Maracaibo, Venezuela',
        ]);

        $response->assertRedirect(route('customers.index'));
        $this->assertDatabaseHas('customers', [
            'id' => $customer->id,
            'name' => 'Jane Smith Updated',
            'id_card' => 'V-22222222',
        ]);
    }

    public function test_customer_views_show_id_card(): void
    {
        $customer = Customer::create([
            'name' => 'Test Customer',
            'id_card' => 'V-33333333',
            'email' => 'test@example.com',
            'phone' => '04161112222',
            'address' => 'Valencia, Venezuela',
        ]);

        // Check index view contains id_card
        $indexResponse = $this->get(route('customers.index'));
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee('V-33333333');

        // Check show view contains id_card
        $showResponse = $this->get(route('customers.show', $customer->id));
        $showResponse->assertStatus(200);
        $showResponse->assertSee('V-33333333');
    }
}
