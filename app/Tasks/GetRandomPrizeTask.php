<?php

declare(strict_types=1);

namespace App\Tasks;

use App\Models\Prize;

final class GetRandomPrizeTask
{
    public function __invoke(): Prize
    {
        $prizes = Prize::all();
        throw_if(!$prizes, new \DomainException('No prizes in DB!'));
        $prize = $prizes->filter(function(Prize $prize) {
            return $prize->isActive();
        })->random();
        throw_if(!$prize, new \DomainException('No active prizes!'));
        return $prize;
    }
}
