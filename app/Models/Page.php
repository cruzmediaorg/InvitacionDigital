<?php

namespace App\Models;

use App\Traits\GenerateUniqueSlugTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

class Page extends Model
{
    use SoftDeletes, GenerateUniqueSlugTrait;

    protected $fillable = [
        'title', 'slug', 'user_id', 'pages_type_id', 'theme_id', 'content',
        'home_h_text_color', 'home_p_text_color', 'home_h_font_family', 'home_p_font_family',
        'home_h1_font_size', 'home_h2_font_size', 'home_h3_font_size', 'home_p_font_size',
        'body_h_text_color', 'body_p_text_color', 'body_h_font_family', 'body_p_font_family',
        'body_h1_font_size', 'body_h2_font_size', 'body_h3_font_size', 'body_p_font_size',
        'published_at',
    ];

    protected $casts = [
        'content' => 'array',
    ];

    protected $appends = [
        'is_published',
    ];

    /**
     * Get the type of the page.
     *
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(PagesType::class);
    }

    /**
     * Get the user that owns the page.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the blocks for the page.
     */
    public function blocks(): HasMany
    {
        return $this->hasMany(Block::class);
    }

    /**
     * Get the theme for the page.
     */
    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class);
    }

    /**
     * Get the blocks in menu format.
     * @return Collection
     */
    public function blocksInMenuFormat(): Collection
    {
        $blocks = $this->blocks->sortBy('order');

        return $blocks->map(function ($block) {
            return [
                'id' => $block->id,
                'name' => $block->type->name,
                'url' => route('pages.blocks.edit', [$this, $block]),
                'order' => $block->order,
            ];
        });
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Get the effective style values for the page.
     *
     * @return array
     */
    public function getEffectiveStyles(): array
    {
        $themeStyles = $this->theme->only([
            'home_h_text_color', 'home_p_text_color', 'home_h_font_family', 'home_p_font_family',
            'home_h1_font_size', 'home_h2_font_size', 'home_h3_font_size', 'home_p_font_size',
            'body_h_text_color', 'body_p_text_color', 'body_h_font_family', 'body_p_font_family',
            'body_h1_font_size', 'body_h2_font_size', 'body_h3_font_size', 'body_p_font_size',
        ]);

        $pageStyles = $this->only([
            'home_h_text_color', 'home_p_text_color', 'home_h_font_family', 'home_p_font_family',
            'home_h1_font_size', 'home_h2_font_size', 'home_h3_font_size', 'home_p_font_size',
            'body_h_text_color', 'body_p_text_color', 'body_h_font_family', 'body_p_font_family',
            'body_h1_font_size', 'body_h2_font_size', 'body_h3_font_size', 'body_p_font_size',
        ]);

        return array_merge(
            $themeStyles,
            array_filter($pageStyles, fn($value) => $value !== null)
        );
    }

    public function isPublished(): bool
    {
        return $this->published_at !== null;
    }

    public function getIsPublishedAttribute(): bool
    {
        return $this->isPublished();
    }
}