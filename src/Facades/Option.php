<?php

declare(strict_types=1);

namespace Akbsit\Options\Facades;

use Illuminate\Support\Facades\Facade;
use Illuminate\Database\Eloquent\Collection;
use Akbsit\Options\Models\Option as OptionModel;
use Akbsit\Options\Option as OptionMain;

/**
 * @method static OptionModel put(string $sOption, mixed $value, string $sGroup = OptionMain::DEFAULT_GROUP)
 * @method static OptionModel|null get(string $sOption, string $sGroup = OptionMain::DEFAULT_GROUP)
 * @method static Collection getByGroup(string $sGroup = OptionMain::DEFAULT_GROUP)
 * @method static Collection getByOption(string $sOption)
 *
 * @see OptionMain
 */
final class Option extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'option';
    }
}
