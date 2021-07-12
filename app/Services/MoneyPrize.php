<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Prize;
use App\Models\Transaction;
use Illuminate\Support\Facades\Http;

final class MoneyPrize extends PrizeAbstract implements PrizeInterface
{
    public bool $doAccept = false;

    public function createTransaction(Prize $prize): Transaction
    {
        if (!$this->isBalanceEnough()) {
            throw new \DomainException('Balance not enough');
        }

        $value = $this->getRandomValue($prize);

        $transaction = Transaction::create([
            'value' => $value,
            'prize_id' => $prize->id,
            'user_id' => \Auth::id(),
            'product_id' => null,
            'done_at' => null,
            'description' => 'You got a real money - ' . $value . ' Cents!'
        ]);

        $this->substractFromInventory('MONEY', $value);

        return $transaction;
    }


    public function isBalanceEnough(): bool
    {
        /** @var Prize $prizeModel */
        $prizeModel = $this->getPrizeFromKey('MONEY');
        if (!$prizeModel) {
            return false;
        }
        if ($prizeModel->inventory > 0) {
            return true;
        }
        return false;
    }

    protected function getRandomValue(Prize $prize): int
    {
        $prize->refresh();
        /** @var int $min */
        $min = config('services.prize.money.min');
        /** @var int $max */
        $max = config('services.prize.money.max');
        if ($max > $prize->inventory) {
            $max = $prize->inventory;
        }
        return random_int($min, $max);
    }

    public function acceptTransaction(Transaction $transaction): bool
    {
        if (!config('services.prize.money.auto_acceptance')) {
            if (!$this->doAccept) {
                return false;
            }
        }
        $transaction->done_at = now();
        $response = Http::get(config('services.prize.money.accept_url'));
        $transaction->save();
        return $response->ok();
    }
}
