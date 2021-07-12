<?php

namespace App\Http\Controllers\Api;

use App\Models\Prize;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PrizeResource;
use App\Http\Resources\PrizeCollection;
use App\Http\Requests\PrizeStoreRequest;
use App\Http\Requests\PrizeUpdateRequest;

class PrizeController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Prize::class);

        $search = $request->get('search', '');

        $prizes = Prize::search($search)
            ->latest()
            ->paginate();

        return new PrizeCollection($prizes);
    }

    /**
     * @param \App\Http\Requests\PrizeStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PrizeStoreRequest $request)
    {
        $this->authorize('create', Prize::class);

        $validated = $request->validated();

        $prize = Prize::create($validated);

        return new PrizeResource($prize);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Prize $prize
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Prize $prize)
    {
        $this->authorize('view', $prize);

        return new PrizeResource($prize);
    }

    /**
     * @param \App\Http\Requests\PrizeUpdateRequest $request
     * @param \App\Models\Prize $prize
     * @return \Illuminate\Http\Response
     */
    public function update(PrizeUpdateRequest $request, Prize $prize)
    {
        $this->authorize('update', $prize);

        $validated = $request->validated();

        $prize->update($validated);

        return new PrizeResource($prize);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Prize $prize
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Prize $prize)
    {
        $this->authorize('delete', $prize);

        $prize->delete();

        return response()->noContent();
    }
}
