<?php

/**
 * @see https://www.w3.org/International/articles/language-tags/
 * @see https://www.iana.org/assignments/language-subtag-registry/language-subtag-registry
 *
 * @note a path always starts with '/' and doesn't end with it
 */

/**
 * @param  mixed  $page
 * @param  string  $text
 * @param  ?string  $current_locale
 * @return string The translated text if found, else returns the same given $text
 */
function __($page, string $text, ?string $current_locale = null): string
{
    $current_locale ??= $page->current_path_locale();

    return $page->localization[$current_locale][$text] ?? $text;
}

// ! The following helpers relies on the locale folder structure

/**
 * @param  mixed  $page
 */
function current_path_locale($page): string
{
    $path = trim($page->getPath(), '/');

    $default_locale = $page->default_locale ?? packageDefaultLocale();

    /**
     * - [a-z]{2,3} language code
     * - [A-Z]{2} region code
     *
     * @var string $locale_regex
     */
    $locale_regex = '/^(?<locale>(?:[a-z]{2,3}-[A-Z]{2})|(?:[a-z]{2,3}))(?:[^a-zA-Z]|$)/';

    preg_match($locale_regex, $path, $matches);

    return $matches['locale'] ?? $default_locale;
}

/**
 * @param  mixed  $page
 * @param  ?string  $target_locale set to the default locale if null
 * @return string Places $target_locale code in the current path
 */
function translate_path($page, ?string $target_locale = null): string
{
    $target_locale ??= packageDefaultLocale();

    $current_locale = current_path_locale($page);

    $partial_path = match (true) {
        $current_locale === $page->default_locale => $page->getPath(),
        default => substr($page->getPath(), strlen($current_locale) + 1),
    };

    return match (true) {
        $target_locale === $page->default_locale => "{$partial_path}",
        default => "/{$target_locale}{$partial_path}",
    };
}

// TODO: add translate_url helper

/**
 * @param  mixed  $page
 * @param  string  $partial_path A path without the language prefix
 * @param  ?string  $target_locale uses the default locale if null
 * @return string A URL on the target locale
 */
function locale_url($page, string $partial_path, ?string $target_locale = null): string
{
    $target_locale ??= current_path_locale($page);

    $partial_path = '/'.trim($partial_path, '/');

    return match (true) {
        $target_locale === $page->default_locale => url($partial_path),
        default => url("/{$target_locale}{$partial_path}")
    };
}

// ===========================================
function packageDefaultLocale($page = null): string
{
    return $page->default_locale ?? 'en';
}
