<?php


class Quiz6
{
    /**
     * @param int $limit
     * @return int
     */
    public function exec(int $limit): int
    {
        $count = 0;
        for ($init_val = 2; $init_val <= $limit; $init_val += 2) {
            $num = $this->timesAndAdd($init_val);
            while ($num !== 1) {
                $num = $this->isEven($num) ? $this->divide($num) : $this->timesAndAdd($num);
                if ($num === $init_val) {
                    $count++;
                    break;
                }
            }
        }
        return $count;
    }

    /**
     * @param int $num
     * @return bool
     */
    private function isEven(int $num): bool
    {
        return $num % 2 === 0;
    }

    /**
     * @param int $num
     * @param int $divide
     * @return int
     */
    private function divide(int $num, int $divide = 2): int
    {
        return $num / $divide;
    }

    /**
     * @param int $num
     * @param int $times
     * @param int $add
     * @return int
     */
    private function timesAndAdd(int $num, int $times = 3, $add = 1): int
    {
        return $num * $times + $add;
    }
}

$q = new Quiz6();
echo $q->exec(10000);
