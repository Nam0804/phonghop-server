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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->integer('type');
//            2 types: 1 for manager, 2 for employee
            $table->string('password');
            $table->foreignId('company_id')->constrained();
            $table->rememberToken();
            $table->integer('is_first_login');
            // 1 for first login, 0 for not first login
            $table->string('email_verified_token')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
