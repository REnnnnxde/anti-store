<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_proof')->nullable()->after('payment_status');
            $table->enum('payment_verification', ['pending', 'verified', 'rejected'])->default('pending')->after('payment_proof');
            $table->text('payment_notes')->nullable()->after('payment_verification');
            $table->timestamp('payment_verified_at')->nullable()->after('payment_notes');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_proof', 'payment_verification', 'payment_notes', 'payment_verified_at']);
        });
    }
};
