<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Prize;
use App\Models\Transaction;

interface PrizeInterface
{
    public function createTransaction(Prize $prize): Transaction;

    public function isBalanceEnough(): bool;

    public function acceptTransaction(Transaction $transaction): bool;
}
