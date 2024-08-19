<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlockTypesField extends Model
{

    protected $table = 'block_types_fields';

    protected $fillable = ['name', 'key', 'type', 'order', 'block_type_id', 'default', 'nullable'];

    protected $hidden = ['created_at', 'updated_at'];
    /**
     * Get the block type that owns the field.
     * @return BelongsTo
     */
    public function blockType(): BelongsTo
    {
        return $this->belongsTo(BlocksType::class);
    }

}
