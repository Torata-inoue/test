<?php


class Vending
{
    private array $coin_types = [];
    private int $deposit = 0;

    /**
     * @param array $coins
     */
    public function setCoinTypes(array $coins): void
    {
        rsort($coins, SORT_NUMERIC);
        $this->coin_types = $coins;
    }

    /**
     * @param int $amount
     */
    public function depositMoney(int $amount): void
    {
        $this->deposit += $amount;
    }

    /**
     * @return array
     */
    public function changeMoney(): array
    {
        $result = [];
        foreach ($this->coin_types as $coin) {
            while ($this->deposit >= $coin) {
                $result[] = $coin;
                $this->deposit -= $coin;
            }
        }

        return $result;
    }
}
