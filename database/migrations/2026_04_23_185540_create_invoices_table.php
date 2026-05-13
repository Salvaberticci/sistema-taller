<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_order_id')->constrained()->onDelete('cascade');
            $table->string('number')->unique();
            $table->decimal('total', 12, 2);
            $table->enum('status', ['unpaid', 'paid', 'partially_paid', 'voided'])->default('unpaid');
            $table->timestamp('issue_date')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
