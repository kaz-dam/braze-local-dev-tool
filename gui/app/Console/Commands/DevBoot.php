<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use App\Services\FileWatcherService;

class DevBoot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev:boot {directory}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start Braze dev environment';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $directory = $this->argument('directory');

        $watchProcess = new Process(['php', 'artisan', 'dev:watch', $directory], base_path());
        $watchProcess->start();
        $this->info('File watcher process started...');

        $serveProcess = new Process(['php', 'artisan', 'serve'], base_path());
        $serveProcess->start();
        $this->info('GUI process started...');

        $reverbProcess = new Process(['php', 'artisan', 'reverb:start'], base_path());
        $reverbProcess->start();
        $this->info('Laravel Reverb process started...');

        while ($watchProcess->isRunning() || $serveProcess->isRunning() || $reverbProcess->isRunning()) {
            usleep(500000);
        }
    }
}
