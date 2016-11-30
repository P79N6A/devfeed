<?php

namespace Fedn\Console\Commands;

use Illuminate\Console\Command;

class UpdateApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '自动拉取最新代码，并执行 migration.';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        //$this->callSilent('down');
        try {
            //$result[] = shell_exec('whoami');
            $result[] = shell_exec('git pull');
            $cmd = 'composer install --prefer-dist';
            if(app()->environment(['staging', 'production'])) {
                $cmd .= ' --no-dev';
            }
            $result[] = shell_exec($cmd);
            $this->call('migrate', ['--force' => true]);
            \Log::info(join("  ", $result));
        } catch (\Exception $e) {
            \Log::error($e->getMessage(), ['inner' => $e]);
        }
        //$this->callSilent('up');
    }
}
