<?php

declare(strict_types=1);

namespace Akbsit\Options\Models;

use Akbsit\HelperJson\JsonHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use TypeError;

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
    private const TYPE_ARRAY = 'array';
    private const TYPE_DOUBLE = 'double';
    private const TYPE_INTEGER = 'integer';
    private const TYPE_STRING = 'string';

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
                    self::TYPE_ARRAY => JsonHelper::make()->data($value)->decode(),
                    self::TYPE_INTEGER => (int)$value,
                    self::TYPE_DOUBLE => (float)$value,
                    self::TYPE_STRING => (string)$value,
                    default => throw new TypeError("The type '$this->type' is not supported.")
                };
            },
            set: function (mixed $value) {
                $sType = gettype($value);
                if (!in_array($sType, $this->getAvailableTypeList())) {
                    throw new TypeError("The type '$sType' is not supported.");
                }

                if ($sType === self::TYPE_ARRAY) {
                    $value = JsonHelper::make()->data($value)->encode();
                }

                return (string)$value;
            },
        );
    }

    private function getAvailableTypeList(): array
    {
        return [
            self::TYPE_ARRAY,
            self::TYPE_INTEGER,
            self::TYPE_DOUBLE,
            self::TYPE_STRING,
        ];
    }
}
