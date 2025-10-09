<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Http\Enums\MaritalStatus;
use App\Http\Enums\EducationLevel;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('password');
            $table->string('national_id')->nullable();
            $table->date('date_of_birth')->nullable();

            $table->enum('marital_status', MaritalStatus::values())->nullable();
            $table->integer('family_members_count')->nullable();
            $table->enum('education_level', EducationLevel::values())->nullable();
            $table->decimal('annual_income', 15, 2)->nullable();
            $table->decimal('total_savings', 15, 2)->nullable();
            $table->string('bank_name')->nullable();


            $table->boolean('is_active')->default(1);
            $table->boolean('otp_verified')->default(0);
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
