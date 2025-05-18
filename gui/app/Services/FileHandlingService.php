<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use App\Support\Cache\CacheKeys;
use Liquid\Template;

class FileHandlingService
{
    private string $devFileListDirectory = '.dev';

    public function __construct() {}

    // get file content
    public function getCompiledFileContent(string $fileName)
    {
        $fileList = $this->getDevFileList();
        $filePath = $this->getFilePath($fileList, $fileName);
        $cacheKey = CacheKeys::compiledFile($filePath);

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $rawFileContent = file_get_contents($filePath);

        $template = new Template();

        // Compile file content
        $template->parse($rawFileContent);
        return $template->render();
    }

    public function getDevFileList(): array
    {
        $devFileListPath = Cache::get(CacheKeys::FILE_SOURCE_DIRECTORY) . '/' . $this->devFileListDirectory;

        if (Cache::has(CacheKeys::DEV_FILE_LIST)) {
            return Cache::get(CacheKeys::DEV_FILE_LIST);
        }

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($devFileListPath, \FilesystemIterator::SKIP_DOTS)
        );

        $fileList = [];

        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $fileName = explode('.', $file->getFileName())[0];

                $fileList[] = [
                    'name' => $fileName,
                    'path' => $file->getPathname()
                ];
            }
        }

        Cache::put(CacheKeys::DEV_FILE_LIST, $fileList, 60 * 60 * 24);

        return $fileList;
    }

    public function getFilePath(array $fileList, string $fileName): string
    {
        foreach ($fileList as $file) {
            if ($file['name'] === $fileName) {
                return $file['path'];
            }
        }

        return '';
    }
}
