<?php

function url(string $path): string
{
    return '/'.trim($path, '/');
}
