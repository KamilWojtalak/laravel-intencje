<?php

namespace App\Services\Payments;

use \Devpark\Transfers24\Requests\Transfers24;

class MakePaymentStrategy
{
    public function handle(string $strategy)
    {
        switch ($strategy) {
            case 'przelewy24':
                return $this->przelewy24();
                break;

            default:

                dd("coś poszło nie tak podczas ustawiania płatności");
                break;
        }
    }

    private function przelewy24()
    {
        $registrationRequest = app()->make(Transfers24::class);

        // TODO zmienić hard coded values
        $registerPayment = $registrationRequest->setEmail('kamilwojtalak99@gmail.com')->setAmount(10000)->init();

        if ($registerPayment->isSuccess()) {
            // Shopper::orderMadeActions($registerPayment->getSessionId());

            return $registrationRequest->execute($registerPayment->getToken(), true);
        }
    }

    private function test()
    {

    }
}
