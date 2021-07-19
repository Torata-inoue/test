<?php

namespace Quiz\Q03;

/**
 * Q03 カードを裏返せ
 * Interface AnswerInterface
 */
interface AnswerInterface
{
    /**
     * @return array|int[] 裏向きになっているカードの配列
     * 例) 1と5が裏向きになっている場合･･･ `return [1, 5];`
     */
    public function exec(): array;
}
