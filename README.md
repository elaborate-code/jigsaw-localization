# Jigsaw localization

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

### Using folder structure for lang prefix

This section explains how to dump the `__` helper second argument for a more intuitive approach.

```php
echo $page->__($text);
```

#### The default lang

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

> Note that the explicit `$lang` argument has higher precedence than the `lang` deduced from the folder structer!

#### The folder structure

> example.com/{lang}

Pages that reside in the web root folder `source` are assumed to be rendered using the `default_lang`. Other pages that reside in **subfolders named after a locale code** have their language set to the **subfolder name**

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

## The included page trick

One of the tricks to not repeat your self by creating the same page many times. You can create a `source/_pages` folder which will contain the master pages where you write the HTML code and call the `__` helper then **include** that page in the other empty files that only respects the languages folder structure or define a `$lang` variable.

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

## Live test

Wanna see a project that is up and running with this library? checkout [my website](https://elaboratecode.com)  and its [repo](https://github.com/elaborate-code/elaborate-code.github.io)

## TODO

- ~~A helper that gives a route to an equivalent translated page (done, I will integrate it soon)~~.
- Add `get_current_lang` helper.
- Add testing.
- Check the minimum required PHP version.
- Automated github actions for testing.
- Check behavior with non A-Z languages.
- Support 5 caracters language codes `xx_YY`.

## Contributing

Any help is very welcomed, feel free to fork and PR :)
