<?php

namespace Quiz\Q03;

require_once ('AnswerInterface.php');

use Quiz\Q03\AnswerInterface;

class Quiz3 implements AnswerInterface
{
    /**
     * @return array
     */
    public function exec(): array
    {
        $cards = array_fill(1, 100, false);

        for ($i = 2; $i <= 100; $i++) {
            for ($j = $i; $j <= 100; $j += $i) {
                $cards[$j] = !$cards[$j];
            }
        }

        return array_keys(array_filter($cards, fn($val) => !$val));
    }
}

$q = new Quiz3();
print_r($q->exec());
