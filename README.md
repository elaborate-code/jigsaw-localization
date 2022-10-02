# Jigsaw localization

![Packagist Version](https://img.shields.io/packagist/v/elaborate-code/jigsaw-localization?label=Version&style=plastic)
![Packagist Downloads](https://img.shields.io/packagist/dt/elaborate-code/jigsaw-localization?label=Downloads&style=plastic)
![GitHub Workflow Status](https://img.shields.io/github/workflow/status/elaborate-code/jigsaw-localization/run-tests?label=Tests)
![GitHub Workflow Status](https://img.shields.io/github/workflow/status/elaborate-code/jigsaw-localization/Fix%20PHP%20code%20style%20issues?label=Code%20Style)

![banner](https://banners.beyondco.de/Jigsaw%20Localization.png?theme=dark&packageManager=composer+require&packageName=elaborate-code%2Fjigsaw-localization&pattern=jigsaw&style=style_1&description=Brings+localization+feature+to+%22tightenco%2Fjigsaw%22+using+JSON+files&md=1&showWatermark=0&fontSize=100px&images=globe)

Brings localization feature to [tightenco/jigsaw](https://jigsaw.tighten.com/) using JSON files.

## Get started

### Requirements

- PHP 8.0 or higher.

### Setup

Bring [jigsaw-localization](https://packagist.org/packages/elaborate-code/jigsaw-localization) to your `Jigsaw` project.

```text
composer require elaborate-code/jigsaw-localization
```

Plug `LoadLocalization` to the builder by registering it in `bootstrap.php`.

```php
<?php

// bootstrap.php

use ElaborateCode\JigsawLocalization\LoadLocalization;

$events->beforeBuild([LoadLocalization::class]);
```

### Simple usage

#### Defining Translation Strings

1. Create a `lang` folder in the root of your project.
2. Create subfolders for each language supported by the application.
3. Populate the subfolders with JSON files that hold translations using translation strings as keys (as much as you want).

File structure example:

![example](https://raw.githubusercontent.com/elaborate-code/php-json-tongue/main/illustration.png)

#### Retrieving Translation Strings

Source example:

```php
<h2> {{ __($page, "Good morning", 'en') }} </h2>

<h2> {{ __($page, "programmer", 'es') }} </h2>

<h2> {{ __($page, "Good morning", 'fr') }} </h2>
```

The output:

```html
<h2> Good morning </h2>

<h2> programador </h2>

<h2> Bonjour </h2>
```

#### Locale code format

`two or three lowercase letters` for the language code + **optionally** `a dash (-) with two uppercase letters` for the region code. For example, all the following codes `ar`, `es`, `fr-CA`, `haw-US` are considered valid.

## The multi folder

For organizational purpose you can group internationalized translations in one JSON using many `locale` keys.

```text
/lang
    ...
    /multi
        salutations.json
        projects_short_descriptions.json
        ...
```

`salutations.json` example:

```json
{
    "fr":{
        "Hello": "Salut",
        "Goodbye": "Au revoir"
    },
    "es":{
        "Hello": "Hola",
        "Goodbye": "Adiós"
    }
}
```

> First level keys must be lang codes

## Using folder structure for locale code prefix

This section explains how to dump the `__` helper second argument `current_locale` for a more intuitive approach.

```php
echo __($page, $text);
```

### The default lang

First you need to define `defaultLocale` in `config.php`. If not set, the package with take `en` as a default.

```php
<?php

// config.php

return [
    // ...
    'defaultLocale' => 'es',
    // ...
];
```

> If you provide the `__` helper with the `locale` parameter it will proceed with it and ignore the folder structure.

### The folder structure

> example.com/{lang}

Pages that reside in the web root folder `source` are assumed to be rendered using the `defaultLocale`. Other pages that reside in **subfolders named after a locale code** have their **locale** set to the **subfolder name**

```text
/source
    /fr
        index.blade.php
        contact.blade.php
        about.blade.php
        ...
    /es
        index.blade.php
        contact.blade.php
        about.blade.php
        ...
    ...
    index.blade.php
    contact.blade.php
    about.blade.php
    ...
```

## The included page trick

You may find your self creating a fully coded `source/index.blade.php` and repeating the same code in `source/fr/index.blade.php` and for other languages. To avoid that we suggest the following approach:

1. Create a `source/_pages` directory which will contain the master pages.
2. A master page will look like any other ordinary page, *it will have the HTML structure and calls to `__` but no hardcoded `$current_locale` value* .For example You may directly copy the content of `source/index.blade.php` to `source/_pages/index.blade.php`.
3. **Include** the master page into other pages that are language aware.
4. The included content will be able to know which **language** to apply on the translation helper `__` calls as a `$current_locale`.

```text
/source
    /_pages
        index.blade.php
        contact.blade.php
        ...
    /fr
        index.blade.php
        contact.blade.php
        ...
    index.blade.php
    contact.blade.php
    ...
```

```php
// Both /source/index.blade.php and /source/fr/index.blade.php
@include('_pages.index')
```

## Helpers

> IMPORTANT: The following helpers require that you respect the locale prefix folder structure!

> Setting `baseUrl` in **config** is essential if your site root URL isn't 'example.com/index.html'

### current_path_locale

Returns the `current_locale` *deduced from the lang prefix folder structure*.

```php
current_path_locale() // ar | es | fr-CA | haw-US
```

Usage example:

```php
<!DOCTYPE html>
<html lang="{{ current_path_locale() }}">
    <head>
    <!-- ... -->
```

### translate_path

When you have a page that is available in many languages. `translate_path` helps you get the equivalent translated `path`.

```php
translate_path($target_locale)
```

input/output examples:

| current path  | translated path  | current_locale to target_locale |
| ------------- | ---------------- | ------------------------------- |
| ""            | "/fr"            | default -> fr                   |
| "/contact"    | "/fr/contact"    | default -> fr                   |
| "/fr"         | "/"              | fr -> default                   |
| "/fr/contact" | "/contact"       | fr -> default                   |
| "/es/contact" | "/fr-CA/contact" | es -> fr-CA                     |
| "/es"         | "/fr-CA"         | es -> fr-CA                     |

Usage example:

```php
<nav>
    @foreach(['en', 'es', 'fr'] as $locale)
        <a href="{{ translate_path($locale) }}"> {{ $locale }} </a>
    @endforeach
</nav>
```

### locale_path

To avoid hard coding the `current_locale` into `paths`, input only the partial path that comes after the `locale code` part into this helper and it will handle the rest for you.  

```php
$href = locale_path($partial_path)
```

| $partial_path | current_locale | href          |
| ------------- | -------------- | ------------- |
| "/"           | DEFAULT        | "/"           |
| "/"           | "fr"           | "/fr"         |
| "/contact"    | DEFAULT        | "/contact"    |
| "/contact"    | "fr"           | "/fr/contact" |

### locale_url

Just like the `locale_path` helper, but it prepends the `baseUrl` if set in the config.

```php
$href = locale_url($partial_path)
```

## Live test

Wanna see a project that is up and running with this library? checkout this [repo](https://github.com/elaborate-code/it-company-website)

## TODO

- Test behavior with non A-Z languages.
- Add a router with named routes
  - Allow custom route patterns (for example set /blog/{locale}/)

## Contributing

Any help is very welcomed, feel free to fork and PR :)
