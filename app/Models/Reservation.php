<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

     /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'rsvp_questions' => 'array',
    ];

    protected $guarded = [];

    public function groups() {
        return $this->hasMany(GuestGroup::class);
    }

    public function guests() {
        return $this->hasManyThrough(Guest::class, GuestGroup::class);
    }
}
