<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Block extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'content', 'blocks_type_id', 'order', 'is_visible'];

    protected $casts = [
        'content' => 'array',
        'is_visible' => 'boolean',
    ];


    /**
     * Get the page that owns the block.
     */
    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    /**
     * Get the type of the block.
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(BlocksType::class, 'blocks_type_id');
    }

    /**
     * Get the fields for block.
     */
    public function fields(): HasMany
    {
        return $this->hasMany(BlockField::class);
    }

    /**
     * Get the blocks type design for the block.
     */
    public function blocksTypeDesign(): BelongsTo
    {
        return $this->belongsTo(BlocksTypeDesign::class);
    }
}