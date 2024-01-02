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
        'register_status',
        'repeat_type'
    ];

    // relationship 1-many with meeting room
    public function meeting_room()
    {
        return $this->belongsTo(MeetingRoom::class);
    }
    // relationship 1-many with guest
    public function guests()
    {
        return $this->hasMany(Guest::class);
    }
    // relationship many-many with user
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function materials()
    {
        return $this->hasMany(Material::class);
    }
    public function meeting_notes()
    {
        return $this->hasMany(MeetingNote::class);
    }
}
