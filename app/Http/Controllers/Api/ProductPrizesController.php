<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PrizeResource;
use App\Http\Resources\PrizeCollection;

class ProductPrizesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Product $product)
    {
        $this->authorize('view', $product);

        $search = $request->get('search', '');

        $prizes = $product
            ->prizes()
            ->search($search)
            ->latest()
            ->paginate();

        return new PrizeCollection($prizes);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {
        $this->authorize('create', Prize::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'class' => ['required', 'max:255', 'string'],
            'inventory' => ['nullable', 'numeric'],
            'key' => ['required', 'max:255', 'string'],
            'description' => ['required', 'max:255', 'string'],
        ]);

        $prize = $product->prizes()->create($validated);

        return new PrizeResource($prize);
    }
}
