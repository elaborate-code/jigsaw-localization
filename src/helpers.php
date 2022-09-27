<?php

function __($page, string $text, string|null $current_lang = null): string
{
    $current_lang ??= $page->current_path_lang();

    return $page->localization[$current_lang][$text] ?? $text;
}

// ! The following helpers relies on the language prefix folder structure

/**
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

function translated_url($page, string|null $trans_lang = null): string
{
    $trans_lang ??= 'en';

    $current_lang = current_path_lang($page);

    $partial_path = match (true) {
        $current_lang === $page->default_lang => $page->getPath(),
        default => substr($page->getPath(), strlen($current_lang) + 1),
    };

    return match (true) {
        $trans_lang === $page->default_lang => "{$partial_path}",
        default => "/{$trans_lang}{$partial_path}",
    };
}

function lang_url($page, string $partial_path, string|null $target_lang = null): string
{
    $target_lang ??= current_path_lang($page);

    $partial_path = '/'.trim($partial_path, '/');

    return match (true) {
        $target_lang === $page->default_lang => url($partial_path),
        default => url("/{$target_lang}{$partial_path}")
    };
}
