<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\CartRequest;
use App\Http\Resources\API\CartResource;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return CartResource::collection($this->user()->cart_items);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CartRequest $request): AnonymousResourceCollection
    {
        return $this->buildCartItems($request);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CartRequest $request): AnonymousResourceCollection
    {
        $this->deleteUserCart();
        return $this->buildCartItems($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(): Response
    {
        $this->deleteUserCart();

        return \response()->noContent();
    }

    private function buildCartItems(CartRequest $request): AnonymousResourceCollection
    {
        $data = [];
        foreach ($request->product_ids as $productId) {
            $data[] = [
                'product_id' => $productId,
                'user_id' => \auth()->id()
            ];
        }
        $user = $this->user()->cart_items()->createMany($data);

        return CartResource::collection($user->load('cart_items'));
    }

    private function user(): User
    {
        /** @var User $user */
        $user = \request()->user();
        return $user;
    }

    /**
     * @return void
     */
    private function deleteUserCart(): void
    {
        $this->user()->cart_items()->delete();
    }
}
