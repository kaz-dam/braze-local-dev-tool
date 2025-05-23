<?php

namespace App\Support\Liquid;

class CustomAttributeResolver
{
    public static function apply(string $content): string
    {
        return preg_replace_callback(
            '/\s*custom_attribute\.\$\{([a-zA-Z0-9_]+)\}\s*/',
            fn ($matches) => $matches[1],
            $content
        );
    }
}
