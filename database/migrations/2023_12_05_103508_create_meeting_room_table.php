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
        Schema::create('meeting_room', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location',500);
            $table->string('floor')->nullable();
            $table->integer('capacity');
            $table->string('equipment',500)->nullable();
            $table->string('image',500)->nullable();
            $table->string('availability')->default(1);
            // default 1 means available
            $table->foreignId('company_id')->constrained();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_room');
    }
};
