<?php
require_once('Rationaler.php');

class Rational implements Rationaler
{
    private int $numerator;
    private int $denominator;

    /**
     * プロパティに値をセットする用のコンストラクタ
     *
     * バリデーションに反する場合は例外が発生し、その時点でプログラムが強制終了する。
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
        $this->reduction($numerator, $denominator);
    }

    /**
     * インスタンスに設定された分子・分母を使って、分数の文字列出力する関数
     *
     * @access public
     *
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
     * @param int $numerator
     * @param int $denominator
     * @return mixed
     */
    private function reduction(int $numerator, int $denominator)
    {
        if ($denominator == 0) {
            $this->numerator /= $numerator;
            $this->denominator /= $numerator;
        } else {
            return $this->reduction($denominator, $numerator % $denominator);
        }
    }

    /**
     * @param $attr
     * @return Rational
     * @throws Exception
     */
    public function add($attr): Rational
    {
        $rational = $this->createObject($attr);
        $numerator = $this->numerator * $rational->denominator + $rational->numerator * $this->denominator;
        $denominator = $this->denominator * $rational->denominator;

        return new Rational($numerator, $denominator);
    }

    /**
     * @param $attr
     * @return Rational
     * @throws Exception
     */
    public function sub($attr): Rational
    {
        $rational = $this->createObject($attr);
        $numerator = $this->numerator * $rational->denominator - $rational->numerator * $this->denominator;
        $denominator = $this->denominator * $rational->denominator;

        return new Rational($numerator, $denominator);
    }

    /**
     * @param $attr
     * @return Rational
     * @throws Exception
     */
    private function createObject($attr): Rational
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
    $half = new Rational(-1, 2);
    $quarter = new Rational(1, 4);
    $result = $half->add(1.3);

    echo $half->display();    // 「1/2」が出力される
    echo $quarter->display(); // 「1/4」が出力される
    echo $result->display();  // 「3/4」が出力される
} catch (Exception $ex) {
    echo $ex->getMessage();
}
