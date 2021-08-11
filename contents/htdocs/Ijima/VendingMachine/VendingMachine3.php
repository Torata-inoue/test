<?php


class VendingMachine3
{
    private array $coin_types = [];  // コインタイプ
    private array $deposit = [];     //　投入した金額
    private array $coins = [];       // 自販機内部にあるコイン
    private array $change = [];

    /**
     * @param array $deposit 購入するときに入れたコイン
     * @param int $amount 購入する商品の金額
     * @return string お釣り
     */
    public function useVendingMachine(array $deposit, int $amount): string
    {
        $this->change = array_merge($this->change, $this->depositMoney($deposit));

        if ($this->buy($amount)) {
            return '購入できました。お釣りは' . implode(',', $this->change) . 'です';
        }

        return '購入できませんでした。' . implode(',', $this->depositMoney($deposit)) . 'を返金します';
    }

    /**
     * @param array $coins
     * @return array
     */
    public function depositMoney(array $coins): array
    {
        $diff = $this->validCoins($coins);

        $coins = array_filter($coins, fn ($coin) => in_array($coin, $this->coin_types));

        $this->deposit = array_merge($this->deposit, $coins);

        $this->countUpCoins($coins);

        return $diff;
    }

    /**
     * coin_typesに対応していないcoinを返す
     * @param array $coins
     * @return array
     */
    private function validCoins(array $coins): array
    {
        return array_diff(array_unique($coins), $this->coin_types);
    }

    /**
     * @param array $coins
     */
    private function countUpCoins(array $coins): void
    {
        foreach ($coins as $coin) {
            $this->coins[$coin] = isset($this->coins[$coin]) ? $this->coins[$coin] + 1 : 1;
        }
    }

    /**
     * @param int $amount
     * @return bool
     */
    public function buy(int $amount): bool
    {
        $deposit = array_sum($this->deposit);
        if ($amount > $deposit) {
            return false;
        }

        $this->subtraction($amount);
        try {
            $this->change = $this->changeMoney();
        } catch (\InvalidArgumentException $e) {
            return false;
        }

        return true;
    }

    /**
     * @param int $amount
     */
    private function subtraction(int $amount)
    {
        rsort($this->deposit);
        foreach ($this->deposit as $key => $deposit) {
            if ($amount === 0) {
                break;
            }
            if ($amount < $deposit) {
                continue;
            }
            $amount -= $deposit;
            unset($this->deposit[$key]);
        }
    }

    /**
     * @return array
     */
    public function changeMoney(): array
    {
        $result = [];
        $deposit = array_sum($this->deposit);
        foreach ($this->coin_types as $coin) {
            while ($deposit >= $coin && $this->coins[$coin]) {
                $this->coins[$coin]--;
                $result[] = $coin;
                $deposit -= $coin;
            }
        }

        if ($deposit) {
            throw new \InvalidArgumentException('釣り銭が不足しています');
        }

        $this->deposit = [];

        return $result;
    }

    /**
     * @param array $coins
     */
    public function setCoinTypes(array $coins): void
    {
        $this->coin_types = array_unique(array_merge($this->coin_types, $coins));
        rsort($this->coin_types, SORT_NUMERIC);
    }


    /**
     * @param array $coins
     */
    public function putMoney(array $coins): void
    {
        if ($diff = $this->validCoins($coins)) {
            throw new \InvalidArgumentException(implode('、', $diff) . 'は入金することができません');
        }

        $this->countUpCoins($coins);
    }
}
