<?php

namespace App\Services;

use Illuminate\Console\OutputStyle;
use Spatie\Watcher\Watch;
use Illuminate\Support\Facades\Cache;
use App\Events\FileCreatedEvent;
use App\Events\FileUpdatedEvent;
use App\Events\FileDeletedEvent;
use App\Support\Cache\CacheKeys;

class FileWatcherService
{
    public function __construct() {}

    /**
     * Start watching a directory for file changes.
     *
     * @param string $directory
     * @return void
     */
    public function startWatching($directory, OutputStyle $output)
    {
        Cache::forever(CacheKeys::FILE_SOURCE_DIRECTORY, $directory);

        Watch::path($directory)
            ->onFileCreated($this->onFileCreation($output))
            ->onFileUpdated($this->onFileUpdate($output))
            ->onFileDeleted($this->onFileDelete($output))
            ->start();
    }

    protected function onFileCreation(OutputStyle $output)
    {
        return function ($path) use ($output) {
            FileCreatedEvent::dispatch($path);
        };
    }

    protected function onFileUpdate(OutputStyle $output)
    {
        return function ($path) use ($output) {
            FileUpdatedEvent::dispatch($path);
        };
    }

    protected function onFileDelete(OutputStyle $output)
    {
        return function ($path) use ($output) {
            FileDeletedEvent::dispatch($path);
        };
    }
}
