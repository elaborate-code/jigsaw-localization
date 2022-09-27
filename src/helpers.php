<?php

function __($page, string $text, string|null $current_lang = null): string
{
    $current_lang ??= $page->current_path_lang();

    return $page->localization[$current_lang][$text] ?? $text;
}

/**
 * ! This helper relies on the language prefix folder structure
 * TODO: replace 'lang' with 'locale'
 *
 * @see https://www.w3.org/International/articles/language-tags/
 * @see https://www.iana.org/assignments/language-subtag-registry/language-subtag-registry
 */
function current_path_lang($page): string
{
    $path = trim($page->getPath(), '/');

    $default_lang = $page->default_lang ?? 'en';

    /**
     * [a-z]{2,3} language code
     * [A-Z]{2} country code
     */
    $locale_regex = '/^(?<locale>(?:[a-z]{2,3}-[A-Z]{2})|(?:[a-z]{2,3}))(?:[^a-zA-Z]|$)/';

    preg_match($locale_regex, $path, $matches);

    return $matches['locale'] ?? $default_lang;
}

/**
 * ! This helper relies on the language prefix folder structure
 */
function translated_url($page, string $trans_lang, string|null $current_lang = null): string
{
    $current_lang ??= $page->current_path_lang();

    $partial_path =
        $current_lang === $page->default_lang ?
        $page->getPath() :
        substr($page->getPath(), 3);

    $path = "/$trans_lang".$partial_path;

    if (str_starts_with($path, '/'.$page->default_lang)) {
        $path = substr($path, 3);
    }

    return empty($path) ? url('/') : url($path);
}

/**
 * ! This helper relies on the language prefix folder structure
 */
function lang_url($page, string $partial_path, string|null $current_lang = null): string
{
    $current_lang ??= $page->current_path_lang();

    if (! str_starts_with($partial_path, '/')) {
        $partial_path = "/$partial_path";
    }

    if ($current_lang === $page->default_lang) {
        return $page->url($partial_path);
    } else {
        return $page->url("/$current_lang".$partial_path);
    }
}

/**
 * ! Jigsaw ships with the same helper
 * Generates a fully qualified URL to the given path.
 */
// function url($page, string $path): string
// {
//     $baseUrl = $page->baseUrl ?? '';

//     if (! str_ends_with($baseUrl, '/')) {
//         $baseUrl .= '/';
//     }

//     if (str_starts_with($path, '/')) {
//         $path = substr($path, 1);
//     }

//     return $baseUrl.$path;
// }
