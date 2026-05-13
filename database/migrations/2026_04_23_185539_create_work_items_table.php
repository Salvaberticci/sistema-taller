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
        Schema::create('work_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_order_id')->constrained()->onDelete('cascade');
            $table->string('description');
            $table->enum('type', ['part', 'labor', 'external_service']);
            $table->decimal('quantity', 10, 2)->default(1);
            $table->decimal('unit_price', 12, 2);
            $table->decimal('total', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_items');
    }
};
