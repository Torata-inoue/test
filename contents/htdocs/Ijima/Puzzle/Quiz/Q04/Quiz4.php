<?php

namespace Quiz\Q04;

require_once ('AnswerInterface.php');

use Quiz\Q04\AnswerInterface;

class Quiz4 implements AnswerInterface
{
    /**
     * @param int $stickSize
     * @param int $people
     * @return int
     */
    public function exec($stickSize, $people): int
    {
        $times = 0;
        $stick_count = 1;
        while ($stick_count < $stickSize) {
            $times++;
            $stick_count += min($times, $people);
        }
        return $times;
    }
}

$q = new Quiz4();
echo $q->exec(20, 3);
echo $q->exec(100, 5);
