<?php

declare(strict_types=1);

if (! function_exists('translate_key')) {
    /**
     * Extract the given key from the current file so it can be translated.
     */
    function translate_key(?string $key = null): ?string
    {
        return $key;
    }
}
