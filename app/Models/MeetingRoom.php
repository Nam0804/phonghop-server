<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class MeetingRoom extends Model
{
    use HasApiTokens, HasFactory, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'location',
        'floor',
        'capacity',
        'equipment',
        'image',
        'availability',
        'company_id',
    ];


//    relationship with one company

    public function company(){
        return $this->belongsTo(Company::class);
    }

}
