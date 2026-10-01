<?php

namespace App\Models\Concerns;

trait Translatable
{
    /**
     * Get a field in the current locale, falling back to English.
     * Usage: $project->tr('title')  (reads title_km or title_en)
     */
    public function tr(string $field): ?string
    {
        if (app()->getLocale() === 'km') {
            $value = $this->{$field . '_km'};
            if (filled($value)) {
                return $value;
            }
        }

        return $this->{$field . '_en'};
    }
}
