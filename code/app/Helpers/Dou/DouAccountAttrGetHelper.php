<?php


namespace App\Helpers\Dou;


use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\DomCrawler\Crawler;

class DouAccountAttrGetHelper
{
    public $url;

    protected $content = '';

    protected $crawler;

    protected $attribute = [];

    protected $fontArr = [
        '' => 0,//94846a8403ec996825f2bb04a8707d3d
        '' => 0,//56926c97178b2a3e94b26aa4d33bce70
        '' => 0,//1916a8f9ceccc6a73db686408ba8320a
        '' => 1,//34d160a4bd89f9e0cdf9bbccd462bbce
        '' => 1,//d2cc9d73da86a7dc199032416cb7432e
        '' => 1,//b9dbcc7a24f0e9007d05ebe032d77f91
        '' => 2,//147546232a60bacc6bbb21677447f7ac
        '' => 2,//f2143a434963b3f19390b0a41dbda0a3
        '' => 2,//199244612671d00a02be0c5c7f834c13
        '' => 3,//c269979340b9239701b8b1faa7753542
        '' => 3,//f4d732e1cfc18542615096ed89e3ed2b
        '' => 3,//44df5410548602d78671a54d6a5ccdf2
        '' => 4,//42e90cddc716517a5e3810d33eb7290b
        '' => 4,//f845deb34a5774946ff40faf8a6bdbd1
        '' => 4,//65a343c6b7e48f08fffd885901056ed1
        '' => 5,//368c2927861bddab0ec8ff8b0ac035c4
        '' => 5,//59c75333134f288710744d28e4dfc281
        '' => 5,//ceb9b3acbe449249517431dfc022c9b6
        '' => 6,//3c24ea46b73f87b8cd2daacb356f0004
        '' => 6,//7ade5c8151fa02649ff51aaa9867fb81
        '' => 6,//8171d2c9b36bec58ec00c6b3d3c759c1
        '' => 7,//c9141a6e35178296ce25c4d381374174
        '' => 7,//4823aa1871ed5d00483bc13cd0f8ce58
        '' => 7,//f3138db279e572ff01cce3c6137aadcf
        '' => 8,//77be8e8a827216e7d337e340782b0651
        '' => 8,//6b8c08d6f0a24014963bb5504c568764
        '' => 8,//b643e9a6fb286cc6013bd002c532c0a8
        '' => 9,//edfc0b596ef7d47e77512202ac587b0f
        '' => 9,//210e709da4cb9a0fc984204883048be8
        '' => 9,//8ce7455e59a3e3a94fe6fea72e127b76
    ];

    /**
     * CreateAccountByUrl constructor.
     * @param $url
     * @throws ValidationException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function __construct($url)
    {
        $this->url = 'https://' . str_replace(['http://', 'https://'], '', $url);
        try{
            $this->initContent();
        }catch (\GuzzleHttp\Exception\GuzzleException $exception){
            throw ValidationException::withMessages(['url' => ['无效的url']]);
        }
        $this->crawler = new Crawler($this->content);
        $this->attribute['share_url'] = $this->url;
        try {
            $this->userId();
            $this->avatarUrl();
            $this->nick();
            $this->username();
           /* $this->followerCount();
            $this->totalFavorited();
            $this->awemeCount();*/
        } catch (\InvalidArgumentException $exception) {
            Log::warning(get_class($this), compact($exception));
            throw ValidationException::withMessages(['url' => ['无效的url']]);
        }
    }

    /**
     * @throws ValidationException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function initContent()
    {

        $client = new Client();

        $content = $client->request('GET', $this->url, [
            'verify' => false,
            'timeout' => 8,
            'headers' => [
                'Referer' => $this->url,
                'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36',
                'accept' => 'ext/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3',
                'accept-language' => 'zh,zh-TW;q=0.9,en-US;q=0.8,en;q=0.7,zh-CN;q=0.6'
            ]
        ])->getBody()->getContents();

        if (!$content) {
            throw ValidationException::withMessages(['url' => ['无效的url']]);
        }

        $this->content = $content;
    }

    protected function userId()
    {
        $this->attribute['user_id'] = $this->crawler->filter('span.focus-btn.go-author')->attr('data-id');
    }

    protected function avatarUrl()
    {
        $this->attribute['avatar_url'] = $this->crawler->filter('span.author img.avatar')->attr('src');
    }

    protected function nick()
    {
        $this->attribute['nick'] = $this->crawler->filter('p.nickname')->text();
    }

    protected function username()
    {
        $username = str_replace([' ', '抖音ID：'], '', $this->crawler->filter('p.shortid')->text());

        $this->attribute['username'] = str_replace(array_keys($this->fontArr), array_values($this->fontArr), $username);
    }

    protected function followerCount()
    {
        $this->attribute['follower_count'] = $this->num('span.follower span.num');
    }

    protected function totalFavorited()
    {
        $this->attribute['total_favorited'] = $this->num('span.liked-num span.num');
    }

    protected function awemeCount()
    {
        $this->attribute['aweme_count'] = $this->num('div.user-tab span.num');
    }


    protected function num($class)
    {
        $strCount = $this->crawler->filter($class)->text();
        $strCount = str_replace(' ', '', $strCount);
        $this->crawler->filter($class . ' i')->each(function ($dom) use (&$strCount) {
            $domText = trim($dom->text());
            $strCount = str_replace($domText, Arr::get($this->fontArr, $domText), $strCount);
        });
        if (strpos($strCount, 'w') !== false) {
            $strCount = str_replace('w', '', $strCount) * 10000;
        }
        return $strCount;
    }

    public function getAttribute()
    {
        return $this->attribute;
    }
}
