# Jigsaw localization

![Packagist Version](https://img.shields.io/packagist/v/elaborate-code/jigsaw-localization?label=Version&style=plastic)
![Packagist Downloads](https://img.shields.io/packagist/dt/elaborate-code/jigsaw-localization?label=Downloads&style=plastic)
![GitHub Workflow Status](https://img.shields.io/github/workflow/status/elaborate-code/jigsaw-localization/run-tests?label=Tests)
![GitHub Workflow Status](https://img.shields.io/github/workflow/status/elaborate-code/jigsaw-localization/Fix%20PHP%20code%20style%20issues?label=Code%20Style)

![banner](https://banners.beyondco.de/Jigsaw%20Localization.png?theme=dark&packageManager=composer+require&packageName=elaborate-code%2Fjigsaw-localization&pattern=jigsaw&style=style_1&description=Brings+localization+feature+to+%22tightenco%2Fjigsaw%22+using+JSON+files&md=1&showWatermark=0&fontSize=100px&images=globe)

Brings localization feature to [tightenco/jigsaw](https://jigsaw.tighten.com/) using JSON files.

## Get started

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

```text
/lang
    /en
        homepage.json
        aboutpage.json
        ...
    /fr
        homepage.json
        aboutpage.json
        ...
    ...
```

`lang\en\homepage.json` example:

```json
{
    "Good morning": "Good morning",
    "view": "view",
    "fast": "fast",
}
```

`lang\fr\homepage.json` example:

```json
{
    "Good morning": "bonjour",
    "view": "vue",
    "fast": "vite",
}
```

#### Retrieving Translation Strings

Source files example:

```php
// source\index.blade.php

<h2> {{ $page->__("Good morning", 'en') }} </h2>
```

```php
// source\fr\index.blade.php

<h2> {{ $page->__("Good morning", 'fr') }} </h2>
```

The outputted files:

```html
<!-- build_.*\index.html -->

<h2> Good morning </h2>
```

```html
<!-- build_.*\fr\index.html -->

<h2> Bonjour </h2>
```

## The special multi folder

For the organizational purpose you can group internationalized translations in one JSON using many `lang` keys.

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
    "en":{
        "Hello": "Hello",
        "Goodbye": "Goodbye"
    },
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

## Using folder structure for lang prefix

This section explains how to dump the `__` helper `current_lang` second argument for a more intuitive approach.

```php
echo $page->__($text);
```

### The default lang

First you should know that this package takes in consideration a parameter named `default_lang`. It set it to `en` by default but you can change it to any other value using `default_lang` key in `config.php`

```php
<?php

// config.php

return [
    // ...
    'default_lang' => 'es',
    // ...
];
```

> Note that the explicit `$lang` argument has higher precedence than the `lang` deduced from the folder structure!

### The folder structure

> example.com/{lang}

Pages that reside in the web root folder `source` are assumed to be rendered using the `default_lang`. Other pages that reside in **subfolders named after a locale code** have their **language** set to the **subfolder name**

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
2. A master page will look like any other ordinary page, *it will have the HTML structure and calls to `__` but no hardcoded `$current_lang` value* .For example You may directly copy the content of `source/index.blade.php` to `source/_pages/index.blade.php`.
3. **Include** the master page into other pages that are language aware.
4. The included content will be able to know which **language** to apply on the translation helper `__` calls as a `$current_lang`.

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

> IMPORTANT: The following helpers require that you respect the lang prefix folder structure!
>
> Setting `baseUrl` in **config** is essential if your site root URL isn't 'example.com/index.html'

### current_path_lang

Returns the `current_lang` string *deduced from the lang prefix folder structure*.

```php
$page->current_path_lang()
```

Usage example

```php
<!DOCTYPE html>
<html lang="{{ $page->current_path_lang() }}">
    <head>
    <!-- ... -->
```

### url

```php
$page->url($path)
```

```php
// baseUrl = 'example.com/e-commerce-project'
$page->url('/'); // example.com/e-commerce-project
$page->url('/fr/contact'); // example.com/e-commerce-project/fr/contact
$page->url('es/about'); // example.com/e-commerce-project/es/about
```

### translated_url

When you have a page that is available in many languages. `translated_url` helps you get the equivalent translated route `href`.

```php
$page->translated_url($translation_lang)
```

input/output examples:

| current path  | translated path | current_lang to translation_lang |
| ------------- | --------------- | -------------------------------- |
| ""            | "/fr"           | default -> fr                    |
| "/contact"    | "/fr/contact"   | default -> fr                    |
| "/fr"         | "/"             | fr -> default                    |
| "/fr/contact" | "/contact"      | fr -> default                    |
| "/es/contact" | "/fr/contact"   | es -> fr                         |
| "/es"         | "/fr"           | es -> fr                         |

Usage example:

```php
<nav>
    @foreach(['en', 'es', 'fr'] as $translation_lang)
        <a href="{{ $page->translated_url($translation_lang) }}"> {{ $translation_lang }} </a>
    @endforeach
</nav>
```

### lang_url

To avoid hard coding the `current_lang` into `URLs`, input only the partial path that comes after the lang part into this helper and it will handle the rest for you.  

```php
$href = lang_url($url)
```

| $url       | current_lang | href          |
| ---------- | ------------ | ------------- |
| "" or "/"  | DEFAULT      | "/"           |
| "" or "/"  | "fr"         | "/fr"         |
| "/contact" | DEFAULT      | "/contact"    |
| "/contact" | "fr"         | "/fr/contact" |

## Live test

Wanna see a project that is up and running with this library? checkout this [repo](https://github.com/elaborate-code/it-company-website)

## TODO

- Add testing.
- Check the minimum required PHP version.
- Automated github actions for testing.
- Check behavior with non A-Z languages.
- Support 5 characters language codes `xx_YY`.
- Add possibility to customize path structure to deduce current lang (for example set /blog/{lang}/... as a possible pattern).

## Contributing

Any help is very welcomed, feel free to fork and PR :)
