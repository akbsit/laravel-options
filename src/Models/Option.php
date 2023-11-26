<?php

declare(strict_types=1);

namespace Akbsit\Options\Models;

use Akbsit\HelperJson\JsonHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Model
 * @mixin Builder
 *
 * @property int    $id
 * @property string $group
 * @property string $option
 * @property string $value
 * @property string $description
 * @property string $type
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method $this getByGroup(string $sGroup)
 * @method $this getByOption(string $sOption)
 */
final class Option extends Model
{
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $fillable = [
        'group',
        'option',
        'value',
        'description',
        'type',
    ];

    protected $table = 'options';

    public function scopeGetByGroup(Builder $oQuery, string $sGroup): void
    {
        $oQuery->where('group', $sGroup);
    }

    public function scopeGetByOption(Builder $oQuery, string $sOption): void
    {
        $oQuery->where('option', $sOption);
    }

    protected function value(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value) {
                return match ($this->type) {
                    'array' => JsonHelper::make()->data($value)->decode(),
                    'integer' => (int)$value,
                    'double' => (float)$value,
                    default => (string)$value
                };
            },
            set: function (mixed $value) {
                if (is_array($value)) {
                    $value = JsonHelper::make()->data($value)->encode();
                }

                return (string)$value;
            },
        );
    }
}
