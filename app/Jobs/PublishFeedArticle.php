<?php

namespace Fedn\Jobs;

use Fedn\Models\User;
use GuzzleHttp\Psr7\UriResolver;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use GuzzleHttp\Psr7\Uri;
use Cache;
use phpQuery;

use Fedn\Models\Article;
use Fedn\Models\quota;
use Fedn\Models\Tag;

class PublishFeedArticle implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    private $quota;
    private $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Quota $quota, User $user = null)
    {

        $this->quota = $quota;
        if ($user === null) {
            $this->user = User::where('email', '=', 'kairee@qq.com')->first();
        } else {
            $this->user = $user;
        }

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if($this->user) {
            $inputer = $this->user->id;
        } else {
            $inputer = 0;
        }

        $summary = trim(strip_tags($this->quota->content), "　 \t\n\r\v");
        $summary = str_replace("\n", "", $summary);
        $summary = mb_substr($summary, 0, 250, 'utf8')."...";

        $article = Article::where('title', '=', $this->quota->title)
                            ->orWhere('source_url', $this->quota->url)
                            ->first();

        if(!$article) {
            $doc = phpQuery::newDocument($this->quota->content);
            $img = $doc->find('img:first');
            $figure = null;
            if (count($img)) {
                $figure = $img->eq(0)->attr('src');
            }
            $doc = null;

            $schema = substr($figure, 0, 5);
            if($schema === 'data:') {
                $figure = null;
            } else if($schema !== 'http:' && $schema !== 'https' && substr($schema, 0, 2) !== '//') {
                $base = new Uri($this->quota->url);
                $rel = new Uri($figure);
                $figure = (string)UriResolver::resolve($base, $rel);
            }

            $article = Article::create([
                'user_id'    => $inputer,
                'title'      => $this->quota->title,
                'source_url' => $this->quota->url,
                'summary'    => $summary,
                'figure'     => $figure,
                'content'    => $this->quota->content,
                'author'     => $this->quota->author_name,
                'author_url' => $this->quota->author_url,
                'team_id'    => $this->quota->team_id,
                'status'     => 'publish'
            ]);

            $tags = explode(',', $this->quota->tags);
            $ids = [];
            foreach ($tags as $tag) {
                if (empty(trim($tag, "　 \t\n\r\v"))) {
                    continue;
                }
                $_tag = Tag::firstOrNew([
                    'title' => $tag
                ]);
                if ( ! $_tag->exists) {
                    $_tag->slug = urlencode($tag);
                    $_tag->save();
                }
                $ids[] = $_tag->id;
            }

            $article->tags()->sync($ids);

            $this->quota->delete(); // 文章已发布，从待选列表里删除
            // 清理缓存
            Cache::tags(['articles', 'tags'])->flush();
        } else {
            $this->quota->delete(); // 文章已发布，从待选列表里删除
        }

    }
}
