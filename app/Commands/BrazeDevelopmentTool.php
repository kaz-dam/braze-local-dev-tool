<?php

namespace App\Commands;

use Symfony\Component\Process\Process;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class BrazeDevelopmentTool extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:braze-development-tool {directory?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start the Braze Development Tool and open it in the browser';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $directory = $this->argument('directory') ?? getcwd();

        $this->info("Starting Braze Development Tool in: $directory");

        $process = new Process(['php', 'artisan', 'dev:boot', $directory], base_path('gui'));
        $process->start(function ($type, $buffer) {
            echo $buffer;
        });

        sleep(3);

        if (PHP_OS_FAMILY === 'Darwin') {
            exec('open http://localhost:8000');
        } elseif (PHP_OS_FAMILY === 'Windows') {
            exec('start http://localhost:8000');
        } else {
            exec('xdg-open http://localhost:8000');
        }

        while ($process->isRunning()) {
            usleep(500000);
        }

        $this->info('Braze Development Tool has stopped.');
    }

    /**
     * Define the command's schedule.
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
