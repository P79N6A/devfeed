<?php

namespace Fedn\Console\Commands;

use Illuminate\Console\Command;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

use Fedn\Models\Site;
use Fedn\Models\Quota;
use Fedn\Models\Tag;

class FetchFeeds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fedn:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch articles from feed sites';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
    }
}
