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
        Schema::table('payments', function (Blueprint $table) {
            $table->string('status')->default('pendiente')->after('method'); // pendiente, confirmado
            $table->timestamp('confirmed_at')->nullable()->after('status');
            $table->string('reference')->nullable()->after('confirmed_at'); // Referencia del pago (N° transacción, etc.)
            $table->text('notes')->nullable()->after('reference'); // Notas adicionales
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['status', 'confirmed_at', 'reference', 'notes']);
        });
    }
};
