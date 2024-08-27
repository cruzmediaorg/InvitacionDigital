<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Guest extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];


    protected $with = ['guestGroup'];

    /*
    * Generate a unique RSVP code of 8 characters
    */
    public static function generateRsvpCode()
    {
        return Str::lower(Str::random(8));  
    }

    public function guestGroup() {
        return $this->belongsTo(GuestGroup::class);
    }
    /*
    * Get the reservation for the guest
    */
    public function reservation() {
        return $this->hasOneThrough(Reservation::class, GuestGroup::class, 'id', 'id', 'guest_group_id', 'reservation_id');
    }

}
