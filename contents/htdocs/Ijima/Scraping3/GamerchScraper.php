<?php
class GamerchScraper
{
    public function run()
    {
        $page = 1;
        $json_data = [];
        $pattern_data = "/<span class=\"rank\d*\">(\d+).*?<li class=\"w-ranking__body--title\">\s*<a href=\"(.+?)\">(.+?)<\/a>\s*<p>(.+?)<\/p>/";
        $pattern_next = "/<span class=\"next-text\">/";

        do {
            $data = [];
            $html = file_get_contents("https://gamerch.com/ranking/wiki?page={$page}");
            preg_match_all($pattern_data, $html, $matches_data, PREG_SET_ORDER);
            preg_match($pattern_next, $html, $match_next);

            foreach ($matches_data as $item) {
                $data[] = [
                    "rank" => $item[1],
                    "title" => $item[2],
                    "url" => $item[3],
                    "descripiton" => $item[4]
                ];
            }
            $json_data = array_merge($json_data, $data);
        } while (!empty($match_next));

        $json_output = json_encode($json_data, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
        file_put_contents("gamerch_regex.json" , $json_output);
    }
}

