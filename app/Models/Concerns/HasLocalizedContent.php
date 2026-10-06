<?php

namespace App\Models\Concerns;

trait HasLocalizedContent
{
    public function localized(string $attribute, mixed $default = null): mixed
    {
        if (app()->isLocale('ar')) {
            $translated = data_get($this->translations ?? [], 'ar.'.$attribute);

            if ($translated !== null && $translated !== '') {
                if (is_array($translated) && is_array($fallback = $this->getAttribute($attribute))) {
                    return array_replace_recursive($fallback, $translated);
                }

                return $translated;
            }
        }

        return $this->getAttribute($attribute) ?? $default;
    }
}
