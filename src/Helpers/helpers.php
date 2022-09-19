<?php

/**
 * @param  string  $path relative/absolute file path, or file name
 * @return bool True if path ends with '.json'
 */
function is_json(string $path): bool
{
    // TODO: tell if $this is JSON when $path is_null
    return strcmp(strtolower(substr($path, -5)), '.json') === 0;
}
