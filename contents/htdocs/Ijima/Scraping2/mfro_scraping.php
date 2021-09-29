<?php
require_once('scraping.php');

class MfroScraper extends Scraper
{
    public function __construct()
    {
        parent::__construct();
    }

    public function run()
    {
        // URLを設定
        $url = 'https://www.mfro.net/company/officer/';
        //取得とDOM構築
        $this->crawler = $this->client->request('GET', $url);
        // データ取得
        $json_data = $this->crawler->filter('.officer')->filter('.flex_wrap_between')->each(function($element) {
            return [
                // 肩書と名前
                'position_name' => $element->filter('h2')->text(),
                // 画像のURL
                'image_url' => $element->filter('img')->attr('src'),
                // 文章
                'text' => $element->filter('.text_service')->text(),
            ];
        });
        // jsonを出力
        var_dump(json_encode($json_data, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES));
    }
}
