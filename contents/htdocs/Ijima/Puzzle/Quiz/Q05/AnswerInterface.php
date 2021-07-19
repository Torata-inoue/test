<?php

namespace Quiz\Q05;

/**
 * Q05 いまだに現金払い?
 * Interface AnswerInterface
 */
interface AnswerInterface
{

    /**
     * @param array|int[] $coins 両替するコインの種類
     * この問題であれば、`$coins = [10, 50, 100, 500];` になる
     */
    public function setCoinTypes(array $coins);

    /**
     * @param   int $bill 両替するお札の金額
     * @return  int 両替可能な組み合わせの通り数
     */
    public function exec(int $bill): int;
}
