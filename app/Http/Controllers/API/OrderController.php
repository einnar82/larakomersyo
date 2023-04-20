<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\OrderRequest;
use App\Http\Resources\API\OrderResource;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return OrderResource::collection(Order::query()->simplePaginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderRequest $request): OrderResource
    {
        /** @var Order $order */
        $order = Order::query()->create(array_merge($request->except('product_ids'), [
            'user_id' => \auth()->id()
        ]));


        $orderItems = [];
        foreach ($request->product_ids as $productId) {
            $orderItems[] = [
                'order_id' => $order->id,
                'product_id' => $productId
            ];
        }

        $order->order_items()->createMany($orderItems);
        return new OrderResource($order->load('order_items'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order): OrderResource
    {
        return new OrderResource($order);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrderRequest $request, Order $order): OrderResource
    {
        return new OrderResource(\tap($order)->update($request->except('product_ids')));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order): Response
    {
        $order->delete();

        return \response()->noContent();
    }
}
