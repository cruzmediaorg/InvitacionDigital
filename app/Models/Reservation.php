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

    protected $appends = [
        'count_attending',
        'count_not_attending',
        'count_pending',
        'count_total_guests',
        'page_title',   
    ];

    public function page() {
        return $this->belongsTo(Page::class);
    }

    public function groups() {
        return $this->hasMany(GuestGroup::class);
    }

    public function guests() {
        return $this->hasManyThrough(Guest::class, GuestGroup::class);
    }

    public function getCountAttendingAttribute() {
        return $this->guests()->where('is_attending', true)->count();
    }

    public function getCountNotAttendingAttribute() {
        return $this->guests()->where('is_attending', false)->count();
    }

    public function getCountPendingAttribute() {
        return $this->guests()->where('is_attending', null)->count();
    }

    public function getCountTotalGuestsAttribute() {
        return $this->guests()->count();
    }

    public function getPageTitleAttribute() {
        return $this->page->title;
    }
}
