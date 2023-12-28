<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Guest extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'booking_id',
        'email',
    ];
    // relationship with booking
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

}
