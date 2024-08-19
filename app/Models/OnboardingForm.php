<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OnboardingForm extends Model
{

    protected $fillable = [
        'name','component'
    ];

    public function pageType(): BelongsTo
    {
        return $this->belongsTo(PagesType::class);
    }
}
