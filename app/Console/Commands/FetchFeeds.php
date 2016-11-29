<?php

namespace Fedn\Console\Commands;

use Fedn\Jobs\PublishFeedArticle;
use Illuminate\Console\Command;
use Fedn\Utils\QuotaUtils;
use Fedn\Models\Quota;
use Cache;
use Fedn\Models\Site;

class FetchFeeds extends Command
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fedn:fetch {site=0}';

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
     */
    public function handle()
    {
        $site_id = (int)$this->argument('site');
        if($site_id === 0) {
            $sites = Cache::remember('all_sites', 1440, function(){
                return Site::orderBy('published', 'desc')->get();
            });
            $sites->each(function($site){
                $data = QuotaUtils::fetch($site, true);
                static::processSite($data, $site->published);
            });
        } else {
            $site = Cache::remember('site_'.$site_id, 10080, function() use ($site_id){
                return Site::find($site_id);
            });
            $data = QuotaUtils::fetch($site, true);
            static::processSite($data, $site->published);
        }
    }

    protected static function processSite($data, $published = false) {
        $items = $data['items'];

        foreach($items as $data) {
            $quota = Quota::create($data);
            if ($published) {
                dispatch(new PublishFeedArticle($quota));
            }
        }
    }
}
