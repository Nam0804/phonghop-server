<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Company extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_name',
        'company_address',
        'company_domain',
        'tax_code',
    ];


//    relationship with many users
    public function users()
    {
        return $this->hasMany(User::class, 'company_id', 'id');
    }

    public function manager(){
        return $this->hasOne(User::class, 'company_id', 'id')->where('role', 1);
    }

//    relationship with many meeting rooms
    public function meetingRooms(){
        return $this->hasMany(MeetingRoom::class, 'company_id', 'id');
    }
}
