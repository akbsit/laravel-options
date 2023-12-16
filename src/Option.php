<?php

declare(strict_types=1);

namespace Akbsit\Options;

use Akbsit\Options\Models\Option as OptionModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

final class Option
{
    public const DEFAULT_GROUP = 'default';

    public function get(string $sOption, string $sGroup = self::DEFAULT_GROUP): OptionModel|null
    {
        /* @var Builder|OptionModel $oOption */
        $oOption = OptionModel::query();

        return $oOption->getByGroup($sGroup)->getByOption($sOption)->first();
    }

    public function getByGroup(string $sGroup = self::DEFAULT_GROUP): Collection
    {
        /* @var Builder|OptionModel $oOption */
        $oOption = OptionModel::query();

        return $oOption->getByGroup($sGroup)->get();
    }

    public function getByOption(string $sOption): Collection
    {
        /* @var Builder|OptionModel $oOption */
        $oOption = OptionModel::query();

        return $oOption->getByOption($sOption)->get();
    }

    public function put(string $sOption, mixed $value, string $sGroup = self::DEFAULT_GROUP): OptionModel
    {
        $arAttributes = [
            'group'  => $sGroup,
            'option' => $sOption,
        ];

        $arValues = [
            'value' => $value,
            'type'  => gettype($value),
        ];

        return (new OptionModel)->updateOrCreate($arAttributes, $arValues);
    }
}
