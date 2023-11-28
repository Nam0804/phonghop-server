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
        Schema::create('managers', function (Blueprint $table) {
            $table->id();
            $table->string('manager_name', 100);
            $table->string('manager_email', 100);
            $table->string('manager_password', 100);
            $table->string('manager_phone', 100);
            $table->string('manager_title', 100);
            $table->foreignId('company_id')->constrained();
            $table->integer('manager_role');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('managers');
    }
};
