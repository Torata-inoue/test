<?php


interface RationalInterface
{
    public function display();

    public function number(int $round);

    public function add($fraction): RationalInterface;

    public function sub($fraction): RationalInterface;
}

class Rational implements RationalInterface
{
    public int $numerator;
    public int $denominator;

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
            return "-{$this->numerator}/{$this->denominator}<br>";
        }
        return "{$this->numerator}/{$this->denominator}<br>";
    }

    /**
     * インスタンスに設定された分子・分母を使って、float(またはint)で表す数値を出力する関数
     *
     * @access public
     * @param integer $round 小数点以下の桁数
     *
     */
    public function number(int $round = 2): float
    {
        $number = $this->numerator / $this->denominator;
        return round($number, $round);
    }

    /**
     * インスタンスに設定された分子・分母を使って、約分した数値を返す関数
     *
     * @param integer $numerator
     * @param integer $denominator
     * @return mixed
     *
     */
    private function reduction($numerator, $denominator)
    {
        if ($denominator == 0) {
            $this->numerator /= $numerator;
            $this->denominator /= $numerator;
        } else {
            return $this->reduction($denominator, $numerator % $denominator);
        }
    }

    /**
     * Rationalクラス同士やRationalクラスと数値を足し算する関数
     *
     * @param $fraction
     * @return object Rational
     * @throws Exception
     */
    public function add($fraction): Rational
    {
        $fraction = $this->object($fraction);
        $nume = $this->numerator * $fraction->denominator + $this->denominator * $fraction->numerator;
        $deno = $this->denominator * $fraction->denominator;
        return new self($nume, $deno);
    }

    /**
     * Rationalクラス同士やRationalクラスと数値を引き算する関数
     *
     * @param $fraction
     * @return object Rational
     * @throws Exception
     */
    public function sub($fraction): Rational
    {
        $fraction = $this->object($fraction);
        $nume = $this->numerator * $fraction->denominator - $this->denominator * $fraction->numerator;
        $deno = $this->denominator * $fraction->denominator;
        return new Rational($nume, $deno);
    }

    /**
     * 引数$fractionの値によって適切なRationクラスを返す関数
     *
     * @param $fraction
     * @return Rational
     * @throws Exception
     */
    private function object($fraction): Rational
    {
        if (is_object($fraction)) {
            return $fraction;
        } elseif (is_float($fraction)) {
            $pow = pow(10, (strlen(substr(strrchr($fraction, '.'), 1))));
            $int = $fraction * $pow;
            return new Rational((int)$int, $pow);
        } elseif (is_int($fraction)) {
            return new Rational($fraction, 1);
        } else {
            throw new Exception('クラス・数値以外は入力出来ません');
        }
    }
}


class MutableRational implements RationalInterface
{
    public int $numerator;
    public int $denominator;

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
        $str = '';
        if ($this->numerator < 0 || $this->denominator < 0) {
            $this->numerator = abs($this->numerator);
            $this->denominator = abs($this->denominator);
            $str .= '-';
        }
        return "{$str}{$this->numerator}/{$this->denominator}<br>";
    }

    /**
     * インスタンスに設定された分子・分母を使って、float(またはint)で表す数値を出力する関数
     *
     * @access public
     * @param integer $round 小数点以下の桁数
     *
     */
    public function number(int $round = 2): float
    {
        $number = $this->numerator / $this->denominator;
        return round($number, $round) . '<br>';
    }

    /**
     * インスタンスに設定された分子・分母を使って、約分した数値を返す関数
     *
     * @param integer $numerator
     * @param integer $denominator
     * @return mixed
     *
     */
    private function reduction($numerator, $denominator)
    {
        if ($denominator == 0) {
            $this->numerator /= $numerator;
            $this->denominator /= $numerator;
        } else {
            return $this->reduction($denominator, $numerator % $denominator);
        }
    }

    /**
     * Rationalクラス同士やRationalクラスと数値を足し算する関数
     *
     * @param $fraction
     * @return object Rational
     * @throws Exception
     */
    public function add($fraction): MutableRational
    {
        return $this->calculate($fraction);
    }

    /**
     * Rationalクラス同士やRationalクラスと数値を引き算する関数
     *
     * @param $fraction
     * @return object Rational
     * @throws Exception
     */
    public function sub($fraction): MutableRational
    {
        return $this->calculate($fraction, 0);
    }

    /**
     * @param $fraction
     * @param int $is_plus
     * @return $this
     * @throws Exception
     */
    private function calculate($fraction, $is_plus = 1)
    {
        $fraction = $this->object($fraction);
        $this->numerator = $is_plus
            ? $this->numerator * $fraction->denominator + $this->denominator * $fraction->numerator
            : $this->numerator * $fraction->denominator - $this->denominator * $fraction->numerator;
        $this->denominator = $this->denominator * $fraction->denominator;
        $this->reduction($this->numerator, $this->denominator);
        return $this;
    }

    /**
     * 引数$fractionの値によって適切なRationクラスを返す関数
     *
     * @param $fraction
     * @return Rational
     * @throws Exception
     */
    private function object($fraction): object
    {
        if (is_object($fraction)) {
            return $fraction;
        }
        if (is_float($fraction)) {
            $pow = pow(10, (strlen(substr(strrchr($fraction, '.'), 1))));
            $int = $fraction * $pow;
            return new MutableRational((int)$int, $pow);
        }
        if (is_int($fraction)) {
            return new MutableRational($fraction, 1);
        }
        throw new Exception('クラス・数値以外は入力出来ません');
    }
}

try {
    $half = new Rational(-1, 2);
    $mutableHalf = new MutableRational(1, 2);
    $quarter = new Rational(1, 4);
    $result1 = $half->add($quarter);
    $result2 = $mutableHalf->add($quarter);

    echo $half->display();        // 「1/2」が出力される
    echo $mutableHalf->display(); // 「3/4」が出力される
    echo $result1->display();     // 「3/4」が出力される
    echo $result2->display();     // 「3/4」が出力される
} catch (Exception $ex) {
    echo $ex->getMessage();
}
