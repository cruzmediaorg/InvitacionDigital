<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlocksType extends Model
{
    use SoftDeletes;

    protected $table = 'blocks_types';

    protected $fillable = ['name', 'fields', 'order', 'page_component', 'form_component'];

    protected $casts = [
        'fields' => 'array',
    ];

    /**
     * Get the blocks for the type.
     * @return HasMany
     */
    public function blocks(): HasMany
    {
        return $this->hasMany(Block::class);
    }

    /**
     * Get the pages type for the type.
     * @return HasMany
     */
    public function pagesType(): HasMany
    {
        return $this->hasMany(BlocksTypePagesType::class);
    }

    /**
     * Get the fields for the type.
     */
    public function blockTypesFields(): HasMany
    {
        return $this->hasMany(BlockTypesField::class);
    }

    /**
     * Get the blocks type design for the type.
     */
    public function blocksTypeDesign(): HasMany
    {
        return $this->hasMany(BlocksTypeDesign::class);
    }


}
