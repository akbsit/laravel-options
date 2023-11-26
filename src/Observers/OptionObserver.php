<?php

declare(strict_types=1);

namespace Akbsit\Options\Observers;

use Akbsit\Options\Models\Option as OptionModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

final class OptionObserver
{
    private const RULES = [
        'group'       => ['required', 'string', 'max:100'],
        'option'      => ['required', 'string', 'max:100'],
        'value'       => 'nullable|string',
        'description' => 'nullable|string',
        'type'        => 'required|string|max:10',
    ];


    public function creating(OptionModel $oOption): void
    {
        $arRules = self::RULES;
        $arRules['group'][] = $this->getGroupRule($oOption);
        $arRules['option'][] = $this->getOptionRule($oOption);

        Validator::make($oOption->toArray(), $arRules)
            ->validate();
    }

    public function updating(OptionModel $oOption): void
    {
        $arRules = self::RULES;
        $arRules['group'][] = $this->getGroupRule($oOption);
        $arRules['option'][] = $this->getOptionRule($oOption);

        Validator::make($oOption->toArray(), $arRules)
            ->validate();
    }

    private function getGroupRule(OptionModel $oOption): Unique
    {
        return Rule::unique('options', 'group')
            ->where('option', $oOption->option)
            ->ignore($oOption->id);
    }

    private function getOptionRule(OptionModel $oOption): Unique
    {
        return Rule::unique('options', 'option')
            ->where('group', $oOption->group)
            ->ignore($oOption->id);
    }
}
