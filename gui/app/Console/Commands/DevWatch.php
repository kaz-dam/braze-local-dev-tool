<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\FileWatcherService;

class DevWatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev:watch {directory}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Watch the Braze dev environment for file changes';

    /**
     * Execute the console command.
     */
    public function handle(FileWatcherService $fileWatcherService)
    {
        $directory = $this->argument('directory');

        $fileWatcherService->startWatching($directory, $this->output);
    }
}
