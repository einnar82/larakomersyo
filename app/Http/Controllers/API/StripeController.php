<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use Stripe\Exception\ApiErrorException;

class StripeController extends Controller
{

    /**
     * @throws ApiErrorException
     */
    public function checkout(Request $request): Redirector|Application|RedirectResponse
    {
//        /** @var \App\Models\User $user */
//        $user = $request->user();
//
//        [$products, $cartItems] = Cart::getProductsAndCartItems();
//
//        $orderItems = [];
//        $lineItems = [];
//        $totalPrice = 0;
//        foreach ($products as $product) {
//            $quantity = $cartItems[$product->id]['quantity'];
//            $totalPrice += $product->price * $quantity;
//            $lineItems[] = [
//                'price_data' => [
//                    'currency' => 'usd',
//                    'product_data' => [
//                        'name' => $product->title,
//                    ],
//                    'unit_amount' => $product->price * 100,
//                ],
//                'quantity' => $quantity,
//            ];
//            $orderItems[] = [
//                'product_id' => $product->id,
//                'quantity' => $quantity,
//                'unit_price' => $product->price
//            ];
//        }
//
//        $session = Cashier::stripe()->checkout->sessions->create([
//            'line_items' => $lineItems,
//            'mode' => 'payment',
//            'success_url' => route('checkout.success', [], true) . '?session_id={CHECKOUT_SESSION_ID}',
//            'cancel_url' => route('checkout.failure', [], true),
//        ]);
//
//        // Create Order
//        $orderData = [
//            'total_price' => $totalPrice,
//            'status' => OrderStatus::Unpaid,
//            'created_by' => $user->id,
//            'updated_by' => $user->id,
//        ];
//        $order = Order::create($orderData);
//
//        // Create Order Items
//        foreach ($orderItems as $orderItem) {
//            $orderItem['order_id'] = $order->id;
//            OrderItem::create($orderItem);
//        }
//
//        // Create Payment
//        $paymentData = [
//            'order_id' => $order->id,
//            'amount' => $totalPrice,
//            'status' => PaymentStatus::Pending,
//            'type' => 'cc',
//            'created_by' => $user->id,
//            'updated_by' => $user->id,
//            'session_id' => $session->id
//        ];
//        Payment::create($paymentData);
//
//        CartItem::where(['user_id' => $user->id])->delete();
//
//        return redirect($session->url);
    }
}
