<?php

namespace App\Http\Controllers\Api;

use App\Models\Prize;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Http\Resources\TransactionCollection;

class PrizeTransactionsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Prize $prize
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Prize $prize)
    {
        $this->authorize('view', $prize);

        $search = $request->get('search', '');

        $transactions = $prize
            ->transactions()
            ->search($search)
            ->latest()
            ->paginate();

        return new TransactionCollection($transactions);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Prize $prize
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Prize $prize)
    {
        $this->authorize('create', Transaction::class);

        $validated = $request->validate([
            'value' => ['required', 'numeric'],
            'description' => ['nullable', 'max:255', 'string'],
            'user_id' => ['required', 'exists:users,id'],
            'done_at' => ['required', 'date'],
        ]);

        $transaction = $prize->transactions()->create($validated);

        return new TransactionResource($transaction);
    }
}
