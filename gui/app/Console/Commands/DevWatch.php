<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DevWatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev:watch';

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
        $fileWatcherService->startWatching($directory, $this->output);
    }
}
