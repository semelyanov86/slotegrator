<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Prize;

abstract class PrizeAbstract
{
    protected function substractFromInventory(string $key, int $value): void
    {
        $prizeModel = $this->getPrizeFromKey($key);
        if (!$prizeModel) {
            throw new \DomainException('No prizes');
        }
        $prizeModel->inventory -= $value;
        $prizeModel->save();
    }

    protected function getPrizeFromKey(string $key): ?Prize
    {
        return Prize::where('key', '=', $key)->first();
    }
}
