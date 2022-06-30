# elaborate-code/jigsaw-localization

Brings localization feature to "tightenco/jigsaw" using JSON files

## Get started

### Setup

Bring `elaborate-code/jigsaw-localization` to your `Jigsaw` project.

```text
composer require elaborate-code/jigsaw-localization
```

Register `LoadLocalization` in `bootstrap.php` to run before build.

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

File structure expamle:

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

The outputed files:

```html
<!-- build_.*\index.html -->

<h2> Good morning </h2>
```

```html
<!-- build_.*\fr\index.html -->

<h2> Bonjour </h2>
```

### Using folder structure for lang prefix

This section explains how to dump the `__` helper second argument for a more intuitive approache.

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

#### The folder structure

Pages that reside in the root folder `source` are assumed to be redered using the `default_lang`. Other pages that reside in **subfolders named after a locale code** have their language set to the **subfolder name**

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

(doc soon)

## The included page trick

(doc soon)

## Live test

Wanna see a project that is up and running with this library? checkout [my website](https://elaboratecode.com)  and its [repo](https://github.com/elaborate-code/elaborate-code.github.io)

## TODO

- A helper that gives a route to an equivelent translated page (done, I will integrate it soon).
- Add testing.
- Check the minimum required PHP version.
- Automated github actions for testing.
- Check behavior with non A-Z languages.

## Contributing

I welcome any help, feel free to fork and PR, I'll about a contributing guideline later :)
