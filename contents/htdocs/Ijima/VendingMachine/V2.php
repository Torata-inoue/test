<?php


class V2
{
    private array $coin_types = [];
    private array $deposit = [];
    private array $coins = [];

    /**
     * @param array $coins
     */
    public function setCoinTypes(array $coins): void
    {
        // coin_typeセット
        $this->coin_types = array_merge($this->coin_types, $coins);
        rsort($this->coin_types, SORT_NUMERIC);
    }

    /**
     * 差分がある状態でchangeMoneyをしたときの挙動は?
     *
     * @param array $coins
     * @return array
     */
    public function depositMoney(array $coins): array
    {
        // 対応してないcoin_type見る
        $diff = $this->validCoins($coins);

        // $coinsから対応していないcoinを消去
        $coins = array_filter($coins, fn ($coin) => in_array($coin, $this->coin_types));

        // デポジット追加
        $this->deposit = array_merge($this->deposit, $coins);

        // 自販機ないにコイン追加
        $this->putMoney($coins);

        return $diff;
    }

    /**
     * @param array $coins
     */
    public function putMoney(array $coins): void
    {
        if ($diff = $this->validCoins($coins)) {
            throw new \InvalidArgumentException(implode('、', $diff) . 'は入金することができません');
        }

        foreach ($coins as $coin) {
            $this->coins[$coin] = isset($this->coins[$coin]) ? $this->coins[$coin] + 1 : 1;
        }
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
     * @return array
     * @throws Exception
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
            throw new \Exception('釣り銭が不足しています');
        }

        $this->deposit = [];

        return $result;
    }
}