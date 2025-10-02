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
        Schema::create('risk_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('has_investment_experience')->nullable();
            $table->boolean('willing_to_risk_capital')->nullable();
            $table->boolean('has_stable_income')->nullable();
            $table->boolean('plans_short_term_withdrawal')->nullable();
            $table->boolean('prefers_high_risk_high_return')->nullable();
            $table->boolean('consults_financial_advisor')->nullable();
            $table->integer('risk_score')->default(0);
            $table->enum('risk_profile', ['conservative', 'moderate', 'aggressive'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('risk_assessments');
    }
};
