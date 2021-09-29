<?php
require_once('mfro_scraping.php');
require_once('gamerch_scraping.php');
require_once('File.php');

//$mfroScraper = new MfroScraper();
//$mfroScraper->run();

$gamerchScraper = new GamerchScraper();
$gamerchScraper->run();

$file = new File('gamerch.csv');
//$file->add('ウイイレ', 'https://ooo', 'ウイイレの攻略wikiです');
//// 最後の行の順位+1位のデータが追加される。（最後の行が100位なら追加されるデータは101位）
//
//$file->delete(2);
//// 30位のデータが削除される
//
$file->update(1, 'スマブラ', 'https//ooo', 'スマブラの攻略Wikiです');
//// 第一引数の順位のデータが更新される
