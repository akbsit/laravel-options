<?php

declare(strict_types=1);

namespace Akbsit\Options\Observers;

use Akbsit\Options\Models\Option as OptionModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

final class OptionObserver
{
    private const RULES = [
        'value'       => 'nullable', // string - multiple type
        'description' => 'nullable|string',
        'type'        => 'required|string|max:10',
    ];

    /* @throws ValidationException */
    public function creating(OptionModel $oOption): void
    {
        $arRules = self::RULES;
        $arRules['group'] = $this->getGroupRule($oOption);
        $arRules['option'] = $this->getOptionRule($oOption);

        Validator::make($oOption->toArray(), $arRules)->validate();
    }

    /* @throws ValidationException */
    public function updating(OptionModel $oOption): void
    {
        $arRules = self::RULES;
        $arRules['group'] = $this->getGroupRule($oOption);
        $arRules['option'] = $this->getOptionRule($oOption);

        Validator::make($oOption->toArray(), $arRules)->validate();
    }

    private function getGroupRule(OptionModel $oOption): array
    {
        return [
            'required',
            'string',
            'max:100',
            Rule::unique('options', 'group')
                ->where('option', $oOption->option)
                ->ignore($oOption->id),
        ];
    }

    private function getOptionRule(OptionModel $oOption): array
    {
        return [
            'required',
            'string',
            'max:100',
            Rule::unique('options', 'option')
                ->where('group', $oOption->group)
                ->ignore($oOption->id),
        ];
    }
}
