<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\CartResource;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use Stripe\Exception\ApiErrorException;

class StripeController extends Controller
{

    /**
     * @throws ApiErrorException
     */
    public function checkout(Request $request): string
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        $cartItems = CartResource::collection($user->cart_items)->toArray($request);

        $orderItems = [];
        $lineItems = [];
        $totalPrice = 0;
        foreach ($cartItems as $cartItem) {
            $quantity = $cartItem['quantity'];
            $totalPrice += $cartItem['product']['price'] * $quantity;
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $cartItem['product']['name']
                    ],
                    'unit_amount' => $cartItem['product']['price'] * 100,
                ],
                'quantity' => $quantity,
            ];

            $orderItems[] = [
                'product_id' => $cartItem['product']['id'],
                'quantity' => $quantity,
                'unit_price' => $cartItem['product']['price']
            ];

        }

        $session = Cashier::stripe()->checkout->sessions->create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => config('app.frontend_url') . '/payment/success/?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => config('app.frontend_url') . '/payment/failed',
        ]);

        // Create Order
        $orderData = [
            'total_price' => $totalPrice,
            'status' => 'unpaid',
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ];
        /** @var Order $order */
        $order = Order::query()->create($orderData);
        $order->order_items()->createMany($orderItems);

        Payment::query()->create([
            'order_id' => $order->id,
            'amount' => $totalPrice,
            'status' => 'pending',
            'type' => 'cc',
            'created_by' => $user->id,
            'updated_by' => $user->id,
            'stripe_session_id' => $session->id
        ]);

        Cart::query()->where(['user_id' => $user->id])->delete();

        return $session->url;
    }
}
