<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use phpQuery;
use Fedn\Utils\ImageUtil;

class ImageFetchTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testReturnCorrectRemoteUrls()
    {
        $testHtml = <<<'EOF'
<div>
    <img src="https://file.ofcdn.com/attachment/1.png">
    <img src="http://file.ofcdn.com/uploads/201801/2.png?_v=20324234">
    <img src="//file.ofcdn.com/uploads/3.png">
    <img src="/images/4.png">
    <img src="attachments/5.png">
</div>
EOF;
        $baseUrl = 'https://ofcss.com/2018/01/02/hello.html';
        $html = phpQuery::newDocumentHTML($testHtml);
        $images = $html->find('img');

        $result = ImageUtil::fetchImages($images, $baseUrl);

        $this->assertArrayHasKey('https://file.ofcdn.com/attachment/1.png', $result);
        $this->assertArrayHasKey('http://file.ofcdn.com/uploads/201801/2.png?_v=20324234', $result);
        $this->assertArrayHasKey('//file.ofcdn.com/uploads/3.png', $result);
        $this->assertArrayHasKey('/images/4.png', $result);
        $this->assertArrayHasKey('attachments/5.png', $result);

        $this->assertEquals('https://file.ofcdn.com/attachment/1.png', $result['https://file.ofcdn.com/attachment/1.png']['remote']);
        $this->assertEquals('https://ofcss.com/2018/01/02/attachments/5.png', $result['attachments/5.png']['remote']);
        $this->assertEquals('https://ofcss.com/images/4.png', $result['/images/4.png']['remote']);
    }
}
