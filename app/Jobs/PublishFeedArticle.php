<?php

namespace Fedn\Jobs;

use Fedn\Models\User;
use Fedn\Utils\ImageUtil;
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

            $images = collect([]);
            $doc->find('img')->map(function ($pqo) use (&$images) {
                $url = $pqo->getAttribute('src');
                if (empty($url) === false) {
                    $images->push($url);
                }
            });
            $imageFiles = ImageUtil::fetchImages($images, $this->quota->url);

            $content = $this->quota->content;

            foreach($imageFiles as $imgFile) {
                $content = str_replace($imgFile->origin, $imgFile->local, $content);
            }

            $figure = $imageFiles->count() ? $imageFiles->first()->local : '';

            $article = Article::create([
                'user_id'    => $inputer,
                'title'      => trim($this->quota->title),
                'source_url' => $this->quota->url,
                'summary'    => $summary,
                'figure'     => $figure,
                'content'    => $content,
                'author'     => trim($this->quota->author_name),
                'author_url' => $this->quota->author_url,
                'team_id'    => $this->quota->team_id,
                'status'     => 'publish'
            ]);

            $article->remoteFiles()->sync($imageFiles->pluck('id')->all());

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
