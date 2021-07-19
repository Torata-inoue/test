<?php

require_once('Rationaler.php');

class MutableRational implements Rationaler
{
    private int $numerator;
    private int $denominator;

    /**
     * MutableRational constructor.
     * @param $numerator
     * @param $denominator
     * @throws Exception
     */
    public function __construct($numerator, $denominator)
    {
        if (!is_int($numerator) || !is_int($denominator) || $denominator === 0) {
            throw new Exception('小数値は入力出来ません');
        }
        $this->numerator = $numerator;
        $this->denominator = $denominator;
//        $this->reduction($numerator, $denominator);
    }

    /**
     * @param int $numerator
     * @param int $denominator
     * @return MutableRational
     */
    private function reduction(int $numerator, int $denominator): MutableRational
    {
        if ($denominator === 0) {
            $this->numerator /= $numerator;
            $this->denominator /= $numerator;
            return $this;
        }

        return $this->reduction($denominator, $numerator % $denominator);
    }

    private function gcd(int $a, int $b)
    {

    }

    /**
     * @return string
     */
    public function display(): string
    {
        if ($this->numerator < 0 || $this->denominator < 0) {
            $this->numerator = abs($this->numerator);
            $this->denominator = abs($this->denominator);
            echo '-';
        }
        return "{$this->numerator}/{$this->denominator}\n";
    }

    /**
     * @param int $round
     * @return float
     */
    public function number(int $round = 2): float
    {
        $number = $this->numerator / $this->denominator;
        return round($number, $round);
    }

    /**
     * @param $attr
     * @return MutableRational
     * @throws Exception
     */
    public function add($attr): MutableRational
    {
        $rational = $this->createObject($attr);
        $numerator = $this->numerator * $rational->denominator + $rational->numerator * $this->denominator;
        $denominator = $this->denominator * $rational->denominator;
//        var_dump($this->reduction($numerator, $denominator));
//        exit();

        return $this->reduction($numerator, $denominator);
    }

    /**
     * @param $attr
     * @return MutableRational
     * @throws Exception
     */
    public function sub($attr): MutableRational
    {
        $rational = $this->createObject($attr);
        $numerator = $this->numerator * $rational->denominator - $rational->numerator * $this->denominator;
        $denominator = $this->denominator * $rational->denominator;

        return $this->reduction($numerator, $denominator);
    }

    /**
     * @param $attr
     * @return MutableRational
     * @throws Exception
     */
    private function createObject($attr): MutableRational
    {
        if (is_object($attr)) {
            return $attr;
        }
        if (is_int($attr)) {
            return new self($attr, 1);
        }
        if (is_float($attr)) {
            $num = 10 ** (strlen(substr(strrchr($attr, '.'), 1)));
            $numerator = $attr * $num;
            return new self((int) $numerator, $num);
        }
        throw new Exception('クラス・数値以外は入力出来ません');
    }
}

try {
    $half = new MutableRational(1, 2);
    $quarter = new MutableRational(1, 4);
    $result = $half->add($quarter);

    echo $half->display();    // 「1/2」が出力される
    echo $quarter->display(); // 「1/4」が出力される
    echo $result->display();  // 「3/4」が出力される
} catch (Exception $ex) {
    echo $ex->getMessage();
}
