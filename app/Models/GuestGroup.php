<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestGroup extends Model
{
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

    public function guests() {
        return $this->hasMany(Guest::class);
    }

    public function reservation() {
        return $this->belongsTo(Reservation::class);
    }
}
