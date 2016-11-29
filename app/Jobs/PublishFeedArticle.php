<?php

namespace Fedn\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Cache;

use Fedn\Models\Article;
use Fedn\Models\quota;
use Fedn\Models\Tag;

class PublishFeedArticle implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    private $quota;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Quota $quota)
    {
        $this->quota = $quota;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $inputer = \Fedn\Models\User::where('email','kairee@qq.com')->first();
        if($inputer) {
            $inputer = $inputer->id;
        } else {
            $inputer = 0;
        }

        $summary = trim(strip_tags($this->quota->content), "　 \t\n\r\v");
        $summary = str_replace("\n", "", $summary);
        $summary = mb_substr($summary, 0, 250, 'utf8')."...";

        $article = Article::create([
            'user_id' => $inputer,
            'title' => $this->quota->title,
            'source_url' => $this->quota->url,
            'summary' => $summary,
            'content' => $this->quota->content,
            'author' => $this->quota->author_name,
            'author_url' => $this->quota->author_url,
            'status' => 'publish'
        ]);

        $tags = explode(',', $this->quota->tags);
        $ids = [];
        foreach($tags as $tag) {
            $_tag = Tag::firstOrNew([
                'title' => $tag
            ]);
            if(!$_tag->exists) {
                $_tag->slug = urlencode($tag);
                $_tag->save();
            }
            $ids[] = $_tag->id;
        }

        $article->tags()->sync($ids);

        $this->quota->delete(); // 文章已发布，从待选列表里删除
        // 清理缓存
        Cache::tags(['articles','tags'])->flush();
    }
}
