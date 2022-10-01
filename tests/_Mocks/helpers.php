<?php

/**
 * ! does not take in count the base url
 */
function url(string $path): string
{
    return '/'.trim($path, '/');
}
