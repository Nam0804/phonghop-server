<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Booking extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'meeting_room_id',
        'from_time',
        'to_time',
        'topic',
        'type_of_booking',
        'agenda',
        'objective',
        'material',
        'sharing_confirmation',
        'booking_name',
        'booking_email',
        'booking_title',
        'booking_company',
        'register_status'
    ];

    // relationship 1-many with meeting room
    public function meetingRoom()
    {
        return $this->belongsTo(MeetingRoom::class);
    }
    // relationship 1-many with guest
    public function guests()
    {
        return $this->hasMany(Guest::class);
    }
}
