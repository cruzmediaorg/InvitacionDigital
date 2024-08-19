<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BlocksTypeDesign extends Model
{
    use HasFactory;

    protected $fillable = [
        'blocks_type_id',
        'name',
        'component'
    ];

    public function blocksType(): BelongsTo
    {
        return $this->belongsTo(BlocksType::class);
    }

    public function blocks(): HasMany
    {
        return $this->hasMany(Block::class);
    }
}
