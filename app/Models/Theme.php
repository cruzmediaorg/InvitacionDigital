<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Theme extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'path',
        'text_color',
        'background_color',
        'font_family',
    ];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * Get the pages for the theme.
     */
    public function pages(): HasMany
    {
        return $this->hasMany(Page::class);
    }

    /**
     * Get the blocks for the theme.
     */
}
