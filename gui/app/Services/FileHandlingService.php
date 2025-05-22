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
    /**
     * The directory where the dev files should be stored.
     *
     * @var string
     */
    private string $devFileListDirectory;

    public function __construct(protected LiquidService $liquidService) {
        $this->devFileListDirectory = config('liquid.paths.dev_directory');
    }

    /**
     * Get the compiled file content.
     *
     * @param string $fileName
     * @return string
     */
    public function getCompiledFileContent(string $fileName)
    {
        $fileList = $this->getDevFileList();
        $filePath = $this->getFilePath($fileList, $fileName);
        $cacheKey = CacheKeys::compiledFile($filePath);

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $rawFileContent = file_get_contents($filePath);

        return $this->liquidService->renderTemplate($rawFileContent);
    }

    /**
     * Get the list of dev files.
     *
     * @return Collection
     */
    public function getDevFileList(): Collection
    {
        $devFileListPath = Cache::get(CacheKeys::FILE_SOURCE_DIRECTORY) . '/' . $this->devFileListDirectory;

        if (Cache::has(CacheKeys::DEV_FILE_LIST)) {
            return Cache::get(CacheKeys::DEV_FILE_LIST);
        }

        $devFileCollection = $this->parseDirectory($devFileListPath);

        Cache::put(CacheKeys::DEV_FILE_LIST, $devFileCollection, 60 * 60 * 24);

        return $devFileCollection;
    }

    /**
     * Get the file path from the file list.
     *
     * @param Collection $fileList
     * @param string $fileName
     * @return string
     */
    public function getFilePath(Collection $fileList, string $fileName): string
    {
        $file = $fileList->whereStrict('name', $fileName);

        return $file->isNotEmpty() ? $file->first()->path : '';
    }

    /**
     * Parse the directory and return a collection of DevFileData.
     *
     * @param string $directory
     * @return Collection
     */
    public function parseDirectory(string $directory): Collection
    {
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

        return $devFileCollection;
    }
}
