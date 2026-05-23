<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\ServiceOrder;
use App\Models\Vehicle;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Customer $customer;
    protected Vehicle $vehicle;
    protected ServiceOrder $serviceOrder;

    protected function setUp(): void
    {
        parent::setUp();
        // Create an authenticated user
        $this->user = User::factory()->create();
        $this->actingAs($this->user);

        // Setup base relationship models
        $this->customer = Customer::create([
            'name' => 'Cliente Factura',
            'email' => 'cliente@factura.com',
            'phone' => '04120000000',
            'address' => 'Caracas, Venezuela',
        ]);

        $this->vehicle = Vehicle::create([
            'customer_id' => $this->customer->id,
            'make' => 'Toyota',
            'model' => 'Fortuner',
            'year' => 2021,
            'license_plate' => 'PAY-333',
            'color' => 'Silver',
        ]);

        $this->serviceOrder = ServiceOrder::create([
            'customer_id' => $this->customer->id,
            'vehicle_id' => $this->vehicle->id,
            'description' => 'Servicio Mayor',
            'status' => 'pending',
            'total_amount' => 500.00,
        ]);
    }

    public function test_can_generate_invoice_for_service_order(): void
    {
        $response = $this->post(route('invoices.store'), [
            'service_order_id' => $this->serviceOrder->id,
        ]);

        $invoice = Invoice::first();
        $this->assertNotNull($invoice);
        $response->assertRedirect(route('invoices.show', $invoice));
        
        $this->assertEquals(500.00, $invoice->total);
        $this->assertEquals('unpaid', $invoice->status);
    }

    public function test_can_register_payment_on_invoice(): void
    {
        $invoice = Invoice::create([
            'service_order_id' => $this->serviceOrder->id,
            'number' => 'FAC-2026-0001',
            'total' => 500.00,
            'status' => 'unpaid',
            'issue_date' => now(),
        ]);

        $response = $this->post(route('invoices.payment', $invoice), [
            'amount' => 200.00,
            'method' => 'Transferencia',
            'reference' => 'REF123456',
            'notes' => 'Pago inicial',
        ]);

        $response->assertRedirect();
        
        $this->assertDatabaseHas('payments', [
            'invoice_id' => $invoice->id,
            'amount' => 200.00,
            'method' => 'Transferencia',
            'status' => 'pendiente',
            'reference' => 'REF123456',
        ]);

        // Invoice status shouldn't change yet because the payment is pending confirmation
        $invoice->refresh();
        $this->assertEquals('unpaid', $invoice->status);
    }

    public function test_can_confirm_payment_and_invoice_recalculates_status(): void
    {
        $invoice = Invoice::create([
            'service_order_id' => $this->serviceOrder->id,
            'number' => 'FAC-2026-0001',
            'total' => 500.00,
            'status' => 'unpaid',
            'issue_date' => now(),
        ]);

        $payment = Payment::create([
            'invoice_id' => $invoice->id,
            'amount' => 250.00,
            'method' => 'Efectivo',
            'payment_date' => now(),
            'status' => 'pendiente',
        ]);

        $response = $this->patch(route('payments.confirm', $payment));
        $response->assertRedirect();

        $payment->refresh();
        $invoice->refresh();

        $this->assertEquals('confirmado', $payment->status);
        $this->assertNotNull($payment->confirmed_at);
        $this->assertEquals('partially_paid', $invoice->status);

        // Add another payment to complete the full invoice amount
        $payment2 = Payment::create([
            'invoice_id' => $invoice->id,
            'amount' => 250.00,
            'method' => 'Efectivo',
            'payment_date' => now(),
            'status' => 'pendiente',
        ]);

        $this->patch(route('payments.confirm', $payment2));
        
        $invoice->refresh();
        $this->assertEquals('paid', $invoice->status);
    }

    public function test_can_reject_payment_and_invoice_status_recalculates(): void
    {
        $invoice = Invoice::create([
            'service_order_id' => $this->serviceOrder->id,
            'number' => 'FAC-2026-0001',
            'total' => 500.00,
            'status' => 'partially_paid',
            'issue_date' => now(),
        ]);

        $payment = Payment::create([
            'invoice_id' => $invoice->id,
            'amount' => 250.00,
            'method' => 'Efectivo',
            'payment_date' => now(),
            'status' => 'pendiente',
        ]);

        $response = $this->patch(route('payments.reject', $payment));
        $response->assertRedirect();

        $payment->refresh();
        $invoice->refresh();

        $this->assertEquals('rechazado', $payment->status);
        // The total confirmed remains 0, so invoice status is unpaid
        $this->assertEquals('unpaid', $invoice->status);
    }

    public function test_can_view_global_payments_history(): void
    {
        $invoice = Invoice::create([
            'service_order_id' => $this->serviceOrder->id,
            'number' => 'FAC-2026-0001',
            'total' => 500.00,
            'status' => 'unpaid',
            'issue_date' => now(),
        ]);

        Payment::create([
            'invoice_id' => $invoice->id,
            'amount' => 100.00,
            'method' => 'Efectivo',
            'payment_date' => now(),
            'status' => 'confirmado',
        ]);

        Payment::create([
            'invoice_id' => $invoice->id,
            'amount' => 150.00,
            'method' => 'Transferencia',
            'payment_date' => now(),
            'status' => 'pendiente',
        ]);

        $response = $this->get(route('payments.history'));
        $response->assertOk();
        $response->assertViewHas('payments');
        $response->assertViewHas('totalConfirmed', 100.00);
        $response->assertViewHas('totalPending', 150.00);
    }
}
