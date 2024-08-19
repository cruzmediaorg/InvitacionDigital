<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class BlockField extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'block_fields';

    protected $fillable = ['name', 'key', 'type', 'value', 'order', 'block_id', 'default', 'nullable', 'blocks_type_id','block_types_field_id'];

    protected $hidden = ['created_at', 'updated_at'];

    protected $appends = ['key'];

    public function getKeyAttribute()
    {
        return $this->blockTypeField->key;
    }
    /**
     * Get the block that owns the field.
     */
    public function block(): BelongsTo
    {
        return $this->belongsTo(Block::class);
    }

    /**
     * Get the block type field that owns the field.
     */
    public function blockTypeField(): BelongsTo
    {
        return $this->belongsTo(BlockTypesField::class, 'block_types_field_id');
    }
}
