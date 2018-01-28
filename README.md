Luosimao
=========

A Luosimao Validator for Laravel 5.

## Installation

Add the following line to the `require` section of `composer.json`:

```json
"require": {
  "pokeguys/laravel-luosimao-captcha": "dev-master"
}
```

## Setup

1. In `/config/app.php`, add the following to `providers`:
```php
'providers' => [
    // Other Service Providers

    Pokeguys\Luosimao\LuosimaoServiceProvider::class,
],
```
and the following to `aliases`:
```php
'aliases' => [
  // Other Aliases

  'Luosimao' => Pokeguys\Luosimao\Facades\Luosimao::class,
],
```
2. Run `php artisan vendor:publish --provider="Pokeguys\Luosimao\LuosimaoServiceProvider"`.
3. In `/config/luosimao.php`, enter your Luosimao public and private keys.
4. The package ships with a default validation message, but if you want to customize it, add the following line into `resources/lang/[lang]/validation.php`:
```php
[
  // Other validation message

  'luosimao' => 'The :attribute field is not correct.',
]
```

## Usage
In your validation rules, add the following:

```php
$rules = [
    // ...
    'luosimao' => 'required|luosimao',
];
```

```php
        $this->validate($request,[
            'luotest_response' => 'required|luosimao',
        ],[
            'luotest_response.required'  => '请点按验证码！',
            'luotest_response.luosimao'  => '验证码错误，请重试。',
        ]);

```

It's also recommended to add `required` when validating.
