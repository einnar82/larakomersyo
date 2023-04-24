<?php

namespace App\Listeners;

use App\Models\Payment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Laravel\Cashier\Events\WebhookReceived;

class StripeEventListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(WebhookReceived $event): void
    {
        if ($event->payload['type'] === 'checkout.session.completed') {
            $paymentIntent = $event->payload['data']['object'];
            $sessionId = $paymentIntent['id'];
            /** @var Payment $payment */
            $payment = Payment::query()
                ->where(['stripe_session_id' => $sessionId, 'status' => 'pending'])
                ->firstOrFail();
            $this->updateOrderAndSession($payment);
        }
    }

    private function updateOrderAndSession(Payment $payment): void
    {
        $payment->update([
            'status' => 'paid'
        ]);

        $payment->order()->update([
            'status' => 'paid'
        ]);
    }
}
