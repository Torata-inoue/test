<?php

class VendingMachine

{
    private array $coinTypes = [];
    private int $depositMoney = 0;

    /**
     * 自動販売機で取り扱い可能な紙幣、硬貨の種類をセットする関数
     *
     * @param array $coinTypes
     */
    public function setCoinTypes(array $coinTypes): void
    {
        foreach ($coinTypes as $value) {
            $this->coinTypes[] = $value;
        }
        rsort($this->coinTypes, SORT_NUMERIC);
    }

    /**
     *自動販売機にお金を入金する関数
     *
     * @param int $amount
     */
    public function depositMoney(int $amount): void
    {
        $this->depositMoney += $amount;
    }

    /**
     *入金された金額のお釣りを最小の紙幣、硬貨の枚数で返す関数
     *
     * @return array
     */
    public function changeMoney(): array
    {
        $result = [];
        $money = 0;

        for ($i = 0; $i < count($this->coinTypes); $i++) {
            while ($this->depositMoney - $money >= $this->coinTypes[$i]) {
                $money += $this->coinTypes[$i];
                $result[] = $this->coinTypes[$i];
            }
        }
        //var_dump($result);
        $this->depositMoney = 0;
        return $result;
    }
}
