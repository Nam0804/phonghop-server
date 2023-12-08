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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meeting_room_id')->constrained();
            $table->string('from_time');
            $table->string('to_time');
            $table->string('topic');
            $table->string('type_of_booking'); // Meeting, personal use
            $table->json('guests')->nullable();
            $table->string('agenda')->nullable();
            $table->string('objective')->nullable();
            $table->string('material')->nullable();
            $table->integer('sharing_confirmation')->default(0);
            $table->string('booking_name');
            $table->string('booking_email');
            $table->string('booking_title');
            $table->string('booking_company');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
