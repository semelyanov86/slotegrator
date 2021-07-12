<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Transaction;
use App\Services\MoneyPrize;
use App\Services\PrizeInterface;
use Illuminate\Console\Command;

final class RunMoneyTransferCommand extends Command
{
    protected $signature = 'money:transfer';

    protected $description = 'Run money transferring procedure';

    public function handle()
    {
        $transactions = Transaction::whereNull('done_at')->get()->filter(function(Transaction $transaction) {
            return $transaction->prize->key === 'MONEY';
        });
        foreach ($transactions as $transaction) {
            $prizeModel = $transaction->prize;
            /** @var MoneyPrize $serviceModel */
            $serviceModel = app($prizeModel->class);
            $serviceModel->doAccept = true;
            $serviceModel->acceptTransaction($transaction);
        }

    }
}
