<?php
class File
{
    /**
     * @var int
     */
    private int $data_count;

    /**
     * File constructor.
     *
     * @param string $file_name csvファイル名
     */
    public function __construct(string $file_name)
    {
        $this->file_name = $file_name;
        $this->data_count = count(file($file_name));
    }

    /**
     * 最後の行の順位+1位のデータを末尾に追加する関数
     *
     * @param string $title タイトル
     * @param string $url URL
     * @param string $description 説明
     */
    public function add(string $title, string $url, string $description)
    {
        $file = fopen($this->file_name, 'a+');

        $data = [$this->data_count, $title, $url, $description];

        fputcsv($file, $data);

        fclose($file);
    }
//
//    /**
//     * 引数の順位のデータを削除する関数
//     *
//     * @param int $rank
//     */
//    public function delete(int $rank)
//    {
//        $file = fopen($this->file_name, 'r+');
//
//        $new_data = [];
//
//        while ($data = fgetcsv($file)) {
//            $new_data[] = $data;
//        }
//
//        $data = array_merge([$this->data_count, $title, $url, $description])
//
//        ftruncate($file,0);
//        fseek($file,0);
//
//        foreach ($new_data as $data) {
//            fputcsv($file, $data);
//        }
//        fclose($file);
//    }

    /**
     * 第一引数の順位のデータを更新する関数
     *
     * @param int $rank 順位
     * @param string $title タイトル
     * @param string $url URL
     * @param string $description 説明
     */
    public function update(int $rank, string $title, string $url, string $description)
    {
        $file = fopen($this->file_name, 'w+');

        $new_data = [];
        $update_data = [$rank, $title, $url, $description];

        while ($data = fgetcsv($file)) {
            if ($data[0] == $rank) {
                $new_data[] = $update_data;
                continue;
            }
            $new_data[] = $data;
        }
        ftruncate($file,0);
        fseek($file,0);

        foreach($new_data as $data){
            fputcsv($file, $data);
        }
        fclose($file);
    }

    public function __destruct()
    {

    }
}
