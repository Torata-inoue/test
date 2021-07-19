<?php

namespace Quiz\Q03;

require_once ('AnswerInterface.php');

use Quiz\Q03\AnswerInterface;

class Quiz3 implements AnswerInterface
{
    const NUM_OF_CARD = 100;
    const FIRST_STEP = 2;
    const LAST_STEP = 100;

    /**
     * @return array
     */
    public function exec(): array
    {
        $cards = array_fill(1, self::NUM_OF_CARD, false);
        foreach (range(self::FIRST_STEP, self::LAST_STEP) as $step) {
            foreach ($cards as $key => $value) {
                if ($key % $step !== 0) {
                    continue;
                }
                $cards[$key] = !$value;
            }
        }

        return array_filter($cards, fn($val) => $val);
    }
}

$q = new Quiz3();
print_r($q->exec());
