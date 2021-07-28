<?php
require_once('AnswerInterface.php');

use Quiz\Q05\AnswerInterFace as AnswerInterFace;

class Quiz05 implements AnswerInterFace
{
    private int $count = 0;
    private array $coins = [];

    const LIMIT = 15;

    public function setCoinTypes(array $coins)
    {
        $this->coins = $coins;
    }

    /**
     * 両替の組み合わせ数を返す関数
     *
     * @param int $bill 両替するお札の金額
     * @return int
     */
    public function exec(int $bill): int
    {
        $this->loop($bill);
        return $this->count;
    }

    /**
     * @param int $bill
     * @param array $total
     */
    private function loop(int $bill, array $total = [])
    {
        $coin = array_shift($this->coins);
        if (!$this->coins) {
            if ($bill === 0 && array_sum($total) <= self::LIMIT) {
                $this->count++;
            }
        } else {
            $limit = min($bill / $coin, self::LIMIT);
            for ($i = 0; $i <= $limit; $i++) {
                $total[$coin] = $i;
                var_dump($total);
                echo '<br>';
                $this->loop($bill - $coin * $i, $total);
            }
        }
    }
}

$q = new Quiz05();
$q->setCoinTypes([500, 100, 50, 10]);
echo $q->exec(1000);

