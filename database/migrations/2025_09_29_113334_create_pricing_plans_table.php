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
        Schema::create('pricing_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Free, Team, etc.
            $table->string('slug')->unique(); // For tag like "For Individuals"
            $table->integer('domain_count')->nullable(); // For tag like "For Individuals"
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('regular_price', 10, 2)->default(0);
            $table->string('billing_cycle')->default('monthly'); // monthly or yearly
            $table->text('description')->nullable();
            $table->json('features')->nullable();
            $table->boolean('status')->default(true); // Plan is active or inactive
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_plans');
    }
};
