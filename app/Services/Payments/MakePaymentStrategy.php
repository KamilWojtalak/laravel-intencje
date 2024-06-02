<?php

namespace App\Services\Payments;

use App\Models\Payment;
use Illuminate\Http\RedirectResponse;

class MakePaymentStrategy
{
    public function handle(string $strategy, Payment $payment)
    {
        switch ($strategy) {
            case 'stripe':
                return $this->stripe($payment);
                break;

            default:

                dd("coś poszło nie tak podczas ustawiania płatności");
                break;
        }
    }

    public function stripe(Payment $payment): RedirectResponse
    {
        $redirectUrl = (new StripeService())
            ->handleStoreCheckout($payment);

        return redirect()->away($redirectUrl);
    }
}
