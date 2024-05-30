<?php

namespace App\Services\Payments;

use App\Models\Event;
use App\Models\User;
use \Devpark\Transfers24\Requests\Transfers24;

class MakePaymentStrategy
{
    // public function handleEvent(string $strategy, Event $event, User $user)
    public function handleEvent()
    {
        $registrationRequest = app()->make(Transfers24::class);

        $registerPayment = $registrationRequest
            ->setEmail('kamilwojtalak99@gmail.com')
            ->setAmount(10000)
            ->init();

        // TODO
        // Create payment
        // A najlepiej to tutaj ten pivot przesyłać, make payment powinno być jeszcze w controllerze
        // Dobra ale to zaraz zrobisz, najpierw zrób pozytywny redirect na p24

        if ($registerPayment->isSuccess()) {
            // Mark pivot
            // Shopper::orderMadeActions($registerPayment->getSessionId());

            return $registrationRequest->execute($registerPayment->getToken(), true);
        }
        else {
            dd($registerPayment->getErrorDescription(), 'coś poszło nie tak adfsdsfaafsddsfafads');
        }
    }

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
