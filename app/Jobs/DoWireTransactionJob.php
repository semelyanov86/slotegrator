<?php

declare(strict_types=1);


namespace App\Jobs;

use App\Models\Transaction;
use App\Services\PrizeInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

final class DoWireTransactionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private Transaction $transaction
    )
    {
    }

    public function handle(): void
    {
        $prizeModel = $this->transaction->prize;
        /** @var PrizeInterface $serviceModel */
        $serviceModel = app($prizeModel->class);
        $serviceModel->acceptTransaction($this->transaction);
    }
}
