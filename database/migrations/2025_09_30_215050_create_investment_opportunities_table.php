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
        Schema::create('investment_opportunities', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->text('description');
            $table->decimal('current_price', 15, 2);
            $table->decimal('entry_price', 15, 2);
            $table->decimal('expected_return_percentage', 5, 2);
            $table->enum('market', ['saudi', 'american', 'global']);
            $table->enum('sector', ['energy', 'banking', 'technology', 'healthcare', 'real_estate']);
            $table->boolean('is_halal')->default(true);
            $table->enum('risk_level', ['low', 'medium', 'high']);
            $table->boolean('is_active')->default(true);
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investment_opportunities');
    }
};
