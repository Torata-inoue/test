<?php
require_once('scraping.php');

class GamerchScraper extends Scraper
{
    public function __construct()
    {
        parent::__construct();
    }

    public function run()
    {
        $page = 1;
        $json_data = [];
        $header = [];
        do {
            // URLを設定
            $url = "https://gamerch.com/ranking/wiki?page={$page}";
            // 取得とDOM構築
            $this->crawler = $this->client->request('GET', $url);
            // データ取得
            $data = $this->crawler->filter('.w-ranking__body')->filter('li')->children('ul')->each(function ($element) {
                return [
                    // 順位
                    'rank' => $element->filter('span')->text(),
                    // wikiタイトル
                    'title' => $element->filter('.w-ranking__body--title')->filter('a')->text(),
                    // wikiのURL
                    'url' => $element->filter('a')->attr('href'),
                    // wikiの説明文
                    'description' => $element->filter('p')->text()
                ];
            });
            // $jsonDataに配列を結合
            $json_data = array_merge($json_data, $data);

            $page ++;
        } while ($this->crawler->filter('.pagination__next')->count() == 1);

//        // jsonを出力
//        $json_output = json_encode($json_data, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
//        file_put_contents("gamerch.json" , $json_output);
        $data = [];
        $data[] = array_keys($json_data[0]);
        $data = array_merge($data, array_slice($json_data, 0, 5));

        // csvファイルを開く
        $csv = fopen('gamerch.csv', 'w');

        foreach ($data as $item) {
            fputcsv($csv, $item);
        }

        // csvファイルを閉じる
        fclose($csv);
    }
}
