<?php


namespace Quiz\Q05;

require_once ('AnswerInterface.php');

use Quiz\Q05\AnswerInterface;

class Quiz5 implements AnswerInterface
{
    private array $coins;
    private int $count = 0;
    const LIMIT = 15;

    /**
     * @param array $coins
     */
    public function setCoinTypes(array $coins)
    {
        rsort($coins);
        $this->coins = $coins;
    }

    /**
     * @param int $bill
     * @return int
     */
    public function exec(int $bill): int
    {
        return $this->count;
    }

    /**
     * ゴリ押し、拡張性なし
     *
     * @param int $bill
     * @return int
     */
    public function exec2(int $bill): int
    {
        for ($coin500 = 0; $coin500 <= 2; $coin500++) {
            for ($coin100 = 0; $coin100 <= 10; $coin100++) {
                for ($coin50 = 0; $coin50 <= 15; $coin50++) {
                    for ($coin10 = 0; $coin10 <= 15; $coin10++) {
                        if ($coin500 + $coin100 + $coin50 + $coin10 <= 15
                            && $coin500 * 500 + $coin100 * 100 + $coin50 * 50 + $coin10 * 10 === $bill
                        ) {
                            $this->count++;
                        }
                    }
                }
            }
        }

        return $this->count;
    }

    /**
     * 再起処理、interfaceの実装通りにできてない。
     *
     * @param $bill
     * @param $coins
     * @param int $limit
     * @return int
     */
    public function exec3($bill, $coins, int $limit = self::LIMIT): int
    {
        $coin = array_shift($coins);
        if (!$coins) {
            if ($bill / $coin <= $limit) {
                $this->count++;
            }
        } else {
            for ($i = 0; $i <= $bill / $coin; $i++) {
                $this->exec3($bill - $coin * $i, $coins, $limit - $i);
            }
        }
        return $this->count;
    }
}

$q = new Quiz5();
$q->setCoinTypes([500, 100, 50, 10]);
echo $q->exec(1000);
echo $q->exec2(1000);
echo $q->exec3(1000, [500, 100, 50, 10]);
