<?php

namespace App\Support\Cache;

use Illuminate\Support\Facades\Cache;

class CacheKeys
{
    public const FILE_SOURCE_DIRECTORY = 'file-source-directory';

    public const DEV_FILE_LIST = 'dev-file-list';

    public static function compiledFile($filePath)
    {
        return "template:{$filePath}:compiled";
    }
}
