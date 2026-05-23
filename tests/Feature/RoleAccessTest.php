<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Part;
use App\Models\ServiceOrder;
use App\Models\Vehicle;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $receptionist;
    protected User $mechanic;

    protected function setUp(): void
    {
        parent::setUp();

        // Create users for each role
        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->receptionist = User::factory()->create(['role' => 'receptionist']);
        $this->mechanic = User::factory()->create(['role' => 'mechanic']);
    }

    public function test_admin_has_full_access(): void
    {
        $this->actingAs($this->admin);

        $response = $this->get(route('dashboard'));
        $response->assertOk();

        $response = $this->get(route('staff.index'));
        $response->assertOk();

        $response = $this->get(route('customers.index'));
        $response->assertOk();

        $response = $this->get(route('vehicles.index'));
        $response->assertOk();

        $response = $this->get(route('orders.index'));
        $response->assertOk();

        $response = $this->get(route('inventory.index'));
        $response->assertOk();

        $response = $this->get(route('invoices.index'));
        $response->assertOk();

        $response = $this->get(route('appointments.index'));
        $response->assertOk();
    }

    public function test_receptionist_has_access_to_most_but_blocked_from_admin_sections(): void
    {
        $this->actingAs($this->receptionist);

        $response = $this->get(route('dashboard'));
        $response->assertOk();

        $response = $this->get(route('customers.index'));
        $response->assertOk();

        $response = $this->get(route('vehicles.index'));
        $response->assertOk();

        $response = $this->get(route('orders.index'));
        $response->assertOk();

        $response = $this->get(route('inventory.index'));
        $response->assertOk();

        $response = $this->get(route('appointments.index'));
        $response->assertOk();

        // ─── Admin-only sections are blocked (403) ───

        // Staff
        $response = $this->get(route('staff.index'));
        $response->assertStatus(403);

        // Billing
        $response = $this->get(route('invoices.index'));
        $response->assertStatus(403);

        // Reports
        $response = $this->get(route('reports.dashboard'));
        $response->assertStatus(403);

        // Inventory write
        $response = $this->get(route('inventory.create'));
        $response->assertStatus(403);
    }

    public function test_mechanic_has_highly_restricted_access(): void
    {
        $this->actingAs($this->mechanic);

        // Dashboard is accessible
        $response = $this->get(route('dashboard'));
        $response->assertOk();

        // Orders are accessible
        $response = $this->get(route('orders.index'));
        $response->assertOk();

        // Inventory (read) is accessible
        $response = $this->get(route('inventory.index'));
        $response->assertOk();

        // AI Chat is accessible
        $response = $this->get(route('ai.chat'));
        $response->assertOk();

        // ─── Everything else is blocked (403) ───

        // Customers
        $response = $this->get(route('customers.index'));
        $response->assertStatus(403);

        // Vehicles
        $response = $this->get(route('vehicles.index'));
        $response->assertStatus(403);

        // Billing
        $response = $this->get(route('invoices.index'));
        $response->assertStatus(403);

        // Appointments
        $response = $this->get(route('appointments.index'));
        $response->assertStatus(403);

        // Staff
        $response = $this->get(route('staff.index'));
        $response->assertStatus(403);

        // Reports
        $response = $this->get(route('reports.dashboard'));
        $response->assertStatus(403);

        // Inventory write
        $response = $this->get(route('inventory.create'));
        $response->assertStatus(403);
    }

    public function test_admin_can_access_billing_reports_and_inventory_write(): void
    {
        $this->actingAs($this->admin);

        $response = $this->get(route('invoices.index'));
        $response->assertOk();

        $response = $this->get(route('reports.dashboard'));
        $response->assertOk();

        $response = $this->get(route('inventory.create'));
        $response->assertOk();
    }
}
