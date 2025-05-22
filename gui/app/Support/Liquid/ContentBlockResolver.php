<?php

namespace App\Support\Liquid;

use App\Support\Cache\CacheKeys;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ContentBlockResolver
{
    public static function apply(string $content): string
    {
        return preg_replace_callback(
            '/{{\s*content_blocks\.\$\{([a-zA-Z0-9_]+)\}\s*}}/',
            function ($matches) {
                $filePath = self::findContentBlockFile($matches[1]);

                return file_get_contents($filePath);
            },
            $content
        );
    }

    public static function findContentBlockFile(string $fileName): string
    {
        $contentBlockDirName = config('liquid.paths.content_block_directory');

        $workingRootDirectory = Cache::get(CacheKeys::FILE_SOURCE_DIRECTORY);
        $contentBlockDirFullPath = "{$workingRootDirectory}/{$contentBlockDirName}";

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($contentBlockDirFullPath, \FilesystemIterator::SKIP_DOTS)
        );

        foreach ($iterator as $file) {
            $withoutExtension = pathinfo($file->getFileName(), PATHINFO_FILENAME);

            if ($file->isFile() && $withoutExtension === $fileName) {
                return $file->getPathname();
            }
        }

        return '';
    }
}
