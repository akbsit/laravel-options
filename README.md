# laravel-options, [Packagist](https://packagist.org/packages/akbsit/laravel-options)

## Install

To install package, you need run command:

```bash
composer require akbsit/laravel-options
```

Next install migrations:

```bash
php artisan migrate
```

## Usage

Facade `Akbsit\Options\Facades\Option`:

* `Option::put(string $sOption, mixed $value, string $sGroup = OptionMain::DEFAULT_GROUP): OptionModel`;
* `Option::get(string $sOption, string $sGroup = OptionMain::DEFAULT_GROUP): OptionModel|null`;
* `Option::getByGroup(string $sGroup = OptionMain::DEFAULT_GROUP): Collection`;
* `Option::getByOption(string $sOption): Collection`.
