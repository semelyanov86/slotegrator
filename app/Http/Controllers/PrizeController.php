<?php

namespace App\Http\Controllers;

use App\Models\Prize;
use App\Models\Product;
use Illuminate\Http\Request;
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
            ->paginate(5);

        return view('app.prizes.index', compact('prizes', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Prize::class);

        $products = Product::pluck('name', 'id');

        return view('app.prizes.create', compact('products'));
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

        return redirect()
            ->route('prizes.edit', $prize)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Prize $prize
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Prize $prize)
    {
        $this->authorize('view', $prize);

        return view('app.prizes.show', compact('prize'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Prize $prize
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Prize $prize)
    {
        $this->authorize('update', $prize);

        $products = Product::pluck('name', 'id');

        return view('app.prizes.edit', compact('prize', 'products'));
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

        return redirect()
            ->route('prizes.edit', $prize)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('prizes.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
