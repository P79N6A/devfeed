<?php

namespace Tests\Unit;

use Faker\Factory;
use Fedn\Models\RemoteFile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use phpQuery;
use Fedn\Utils\ImageUtil;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ImageFetchTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testReturnCorrectRemoteUrls()
    {
        $testHtml = <<<'EOF'
<div>
    <img src="https://file.ofcdn.com/attachments/8638990568.png">
    <img src="http://file.ofcdn.com/upfiles/ds1.png?_v=20324234">
    <img src="http://file.ofcdn.com/uploads/201801/no_exist.png?_v=20324234">
    <img src="//file.ofcdn.com/promo/cdn.jpg" width="336" height="280" style="display:inline;magin:0;height:auto">
    <img src="/attachments/2011/03/QQ.png">
    <img src="attachments/5.png">
</div>
EOF;
        $baseUrl = 'https://ofcss.com/2018/01/02/hello.html';
        $html = phpQuery::newDocumentHTML($testHtml);
        $images = collect([]);
        $html->find('img')->map(function($pqo) use (&$images){
            $url = $pqo->getAttribute('src');
            if(empty($url) === false) {
                $images->push($url);
            }
        });

        $result = ImageUtil::fetchImages($images, $baseUrl, true);
        $this->assertCount(4, $result);
        $this->assertInstanceOf(RemoteFile::class, $result->first());
    }


    /** @test * */
    public function imageUtil_can_fetch_remote_image_to_local()
    {
        Storage::fake('public');
        $url = Factory::create()->imageUrl(64, 64, 'people');
        $fileModel = ImageUtil::downloadFile($url, $url, false);

        $this->assertInstanceOf(RemoteFile::class, $fileModel);
        $this->assertEquals($url, $fileModel->remote);
        $this->assertNull($fileModel->id);

    }
}
