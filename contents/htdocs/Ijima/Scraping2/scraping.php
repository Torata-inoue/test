<?php
//ライブラリロード
require_once ('vendor/autoload.php');
use Goutte\Client;

class Scraper
{
    public function __construct()
    {
        //インスタンス生成
        $this->client = new Client();

        // var_dump()を省略させずにすべてを出力させる
        ini_set('xdebug.var_display_max_children', -1);
        ini_set('xdebug.var_display_max_data', -1);
        ini_set('xdebug.var_display_max_depth', -1);
    }
}
