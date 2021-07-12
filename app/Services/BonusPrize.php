<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Prize;
use App\Models\Transaction;

final class BonusPrize extends PrizeAbstract implements PrizeInterface
{

    public function createTransaction(Prize $prize): Transaction
    {
        if (!$this->isBalanceEnough()) {
            throw new \DomainException('Balance not enough');
        }

        $value = $this->getRandomValue();

        $transaction = Transaction::create([
            'value' => $value,
            'prize_id' => $prize->id,
            'user_id' => \Auth::id(),
            'product_id' => null,
            'done_at' => null,
            'description' => 'You got a super bonus - ' . $value . ' !'
        ]);
        return $transaction;
    }

    public function isBalanceEnough(): bool
    {
        return true;
    }

    protected function getRandomValue(): int
    {
        /** @var int $min */
        $min = config('services.prize.bonus.min');
        /** @var int $max */
        $max = config('services.prize.bonus.max');

        return random_int($min, $max);
    }

    public function acceptTransaction(Transaction $transaction): bool
    {
        return true;
    }
}
