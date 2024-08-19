<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlocksTypePagesType extends Model
{

    public $timestamps = false;

    protected $fillable = ['blocks_type_id', 'pages_type_id'];

    /**
     * Get the blocks type for the page type.
     */
    public function blocksType(): BelongsTo
    {
        return $this->belongsTo(BlocksType::class);
    }

    /**
     * Get the pages type for the block type.
     */
    public function pagesType(): BelongsTo
    {
        return $this->belongsTo(PagesType::class);
    }
}
