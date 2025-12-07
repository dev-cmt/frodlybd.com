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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('plan_id')->constrained('pricing_plans');
            $table->string('invoice_number')->unique();

            $table->decimal('amount', 10, 2)->default(0);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            // Independent domain limits
            $table->integer('allowed_domains')->default(0);
            $table->integer('used_domains')->default(0);
            $table->integer('request_limit')->default(0);
            $table->integer('total_requests')->default(0);

            $table->enum('status', ['pending','active','expired'])->default('pending');
            $table->timestamps();

            $table->index('invoice_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
