<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Routing\Route;
use Illuminate\Support\Str;

trait GenerateUniqueSlugTrait
{
    public static function bootGenerateUniqueSlugTrait(): void
    {
        static::saving(function ($model) {
            $title = $model->title;
            $model->slug = $model->generateUniqueSlug($title);
        });
    }

    public function generateUniqueSlug(string $slug): string
    {
        $slug = Str::slug($slug);
        $existingSlugs = $this->getExistingSlugs($slug, $this->getTable());
        $existingRoutes = $this->checkExistingRoutes($slug);

        if (!in_array($slug, $existingSlugs)) {
            return $slug;
        }

        $i = 1;
        while (in_array($slug . '-' . $i, $existingSlugs)) {
            $i++;
        }

        return $slug . '-' . $i;
    }

    private function getExistingSlugs(string $slug, string $table): array
    {
        return $this->where('slug', 'LIKE', $slug . '%')
            ->where('id', '!=', $this->id ?? null) // Exclude the current model's ID
            ->pluck('slug')
            ->toArray();
    }

    private function checkExistingRoutes(string $slug): bool
    {
       // Check if there is an existing route with the same slug

        return false;
    }
}
