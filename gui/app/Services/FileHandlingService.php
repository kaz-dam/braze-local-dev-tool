<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;
use Liquid\Template;
use App\Support\Cache\CacheKeys;
use App\DTOs\DevFileData;

class FileHandlingService
{
    private string $devFileListDirectory = '.dev';

    public function __construct() {}

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

        $template->parse($rawFileContent);
        return $template->render();
    }

    public function getDevFileList(): Collection
    {
        $devFileListPath = Cache::get(CacheKeys::FILE_SOURCE_DIRECTORY) . '/' . $this->devFileListDirectory;

        if (Cache::has(CacheKeys::DEV_FILE_LIST)) {
            return Cache::get(CacheKeys::DEV_FILE_LIST);
        }

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($devFileListPath, \FilesystemIterator::SKIP_DOTS)
        );

        $devFileCollection = collect();

        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $fileName = explode('.', $file->getFileName())[0];

                $devFileCollection->push(new DevFileData([
                    'name' => $fileName,
                    'path' => $file->getPathname()
                ]));
            }
        }

        Cache::put(CacheKeys::DEV_FILE_LIST, $devFileCollection, 60 * 60 * 24);

        return $devFileCollection;
    }

    public function getFilePath(Collection $fileList, string $fileName): string
    {
        $file = $fileList->whereStrict('name', $fileName);

        return $file->isNotEmpty() ? $file->first()->path : '';
    }
}
