<?php

namespace App\Liquid;

use Liquid\Template;

class CustomTemplate extends Template
{
    public function getRegisteredTags(): array
    {
        $getter = function () { return self::$tags; };
        return \Closure::bind($getter, $this, Template::class)();
    }

    public static function getRegisteredFilters(): array
    {
        return self::$filters;
    }

    public static function unregisterTags(array $tags)
    {
        foreach ($tags as $tag) {
            unset(self::$tags[$tag]);
        }
    }

    public static function unregisterFilter(string $filter)
    {
        self::$filters = array_filter(
            self::$filters,
            fn ($filter) => $filter !== $filterClass
        );
    }
}
