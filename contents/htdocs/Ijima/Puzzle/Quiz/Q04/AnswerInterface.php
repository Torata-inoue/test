<?php

namespace Quiz\Q04;

/**
 * Q04 棒の切り分け
 * Interface AnswerInterface
 */
interface AnswerInterface
{
    /**
     * @param   int $stickSize  棒の長さ(cm)
     * @param   int $people       人数
     * @return  int 最短で切り分けられる回数
     */
    public function exec($stickSize, $people): int;
}
