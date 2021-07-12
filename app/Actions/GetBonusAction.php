<?php

declare(strict_types=1);

namespace App\Actions;

use App\Jobs\DoWireTransactionJob;
use App\Models\Transaction;
use App\Services\PrizeInterface;
use App\Tasks\GetRandomPrizeTask;
use Lorisleiva\Actions\Concerns\AsAction;

final class GetBonusAction
{
    use AsAction;

    public function __construct(
        private GetRandomPrizeTask $randomPrizeTask
    )
    {
    }

    public function handle(): Transaction
    {
        $prizeModel = ($this->randomPrizeTask)();
        /** @var PrizeInterface $serviceModel */
        $serviceModel = app($prizeModel->class);
        $transaction = $serviceModel->createTransaction($prizeModel);
        DoWireTransactionJob::dispatch($transaction);
        return $transaction;
    }
}
