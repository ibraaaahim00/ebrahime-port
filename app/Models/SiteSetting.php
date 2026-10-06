<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedContent;
use Database\Factories\SiteSettingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    /** @use HasFactory<SiteSettingFactory> */
    use HasFactory;

    use HasLocalizedContent;

    protected $fillable = ['key', 'value', 'type', 'group', 'translations'];

    protected function casts(): array
    {
        return ['translations' => 'array'];
    }

    public function typedValue(): mixed
    {
        return match ($this->type) {
            'boolean' => filter_var($this->value, FILTER_VALIDATE_BOOLEAN),
            'integer' => (int) $this->value,
            'json' => json_decode($this->value ?: 'null', true),
            default => $this->value,
        };
    }

    public function localizedTypedValue(): mixed
    {
        $value = $this->localized('value', $this->value);

        return match ($this->type) {
            'boolean' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            'integer' => (int) $value,
            'json' => json_decode((string) $value ?: 'null', true),
            default => $value,
        };
    }
}
