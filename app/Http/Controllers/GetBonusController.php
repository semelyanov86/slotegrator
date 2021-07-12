<?php

declare(strict_types=1);


namespace App\Http\Controllers;

use App\Actions\GetBonusAction;
use App\Http\Requests\GetBonusRequest;
use App\Models\Transaction;
use \Illuminate\Routing\Redirector;
use \Illuminate\Contracts\Foundation\Application;
use \Illuminate\Http\RedirectResponse;

final class GetBonusController extends Controller
{
    public function __invoke(GetBonusRequest $request): Redirector|Application|RedirectResponse
    {
        try {
            /** @var Transaction $transaction */
            $transaction = GetBonusAction::run();
            return redirect(route('welcome'))->with('success', $transaction->description);
        } catch (\DomainException $e) {
            return redirect(route('welcome'))->with('error', $e->getMessage());
        }

    }
}
