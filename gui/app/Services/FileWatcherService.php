<?php

namespace App\Services;

use Illuminate\Console\OutputStyle;
use Spatie\Watcher\Watch;
use App\Events\FileCreatedEvent;
use App\Events\FileUpdatedEvent;
use App\Events\FileDeletedEvent;

class FileWatcherService
{
    public function __construct(
        protected Watch $watcher
    ) {}

    /**
     * Start watching a directory for file changes.
     *
     * @param string $directory
     * @return void
     */
    public function startWatching($directory, OutputStyle $output)
    {
        $this->watcher::path($directory)
            ->onFileCreated($this->onFileCreation($output))
            ->onFileUpdated($this->onFileUpdate($output))
            ->onFileDeleted($this->onFileDelete($output))
            ->start();
    }

    protected function onFileCreation(OutputStyle $output)
    {
        return function ($path) use ($output) {
            $output->writeln("File created: $path");
            FileCreatedEvent::dispatch($path);
        };
    }

    protected function onFileUpdate(OutputStyle $output)
    {
        return function ($path) use ($output) {
            $output->writeln("File updated: $path");
            FileUpdatedEvent::dispatch($path);
        };
    }

    protected function onFileDelete(OutputStyle $output)
    {
        return function ($path) use ($output) {
            $output->writeln("File deleted: $path");
            FileDeletedEvent::dispatch($path);
        };
    }
}
