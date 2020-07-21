<?php

function iwindy_path($path = null)
{
    $path = trim($path, '/');
    return __DIR__ . ($path ? "/$path" : '');
}

function iwindy($key = null, $default = null)
{
    return iconfig('windy'.($key ? ".$key" : ''), $default);
}
