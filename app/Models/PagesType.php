<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PagesType extends Model
{
    use SoftDeletes;

    protected $fillable = ['name'];

    /**
     * Get the pages for the type.
     * @return HasMany
     */
    public function pages(): HasMany
    {
        return $this->hasMany(Page::class);
    }

    /**
     * Get the blocks type for the type.
     */
    public function blocksType(): BelongsToMany
    {
        return $this->belongsToMany(BlocksType::class, 'blocks_type_pages_types');
    }

    /**
     * Get the onboarding forms for the type.
     * @return HasMany
     */
    public function pageOnboardingForms(): HasMany
    {
        return $this->hasMany(OnboardingForm::class);
    }

}
