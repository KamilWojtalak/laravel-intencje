<?php

namespace App\Services\Payments;

use App\Models\Payment;
use App\Services\Models\PaymentService;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Stripe\Stripe;

class StripeService
{
    private $checkoutSession;

    public function setApiKey(): void
    {
        Stripe::setApiKey(config('payments.stripe.secret'));
    }

    public function handleStoreCheckout(Payment $payment): string
    {
        $this->createCheckoutSession($payment);

        $this->setSessionId($payment);

        $redirectUrl = $this->getRedirectUrl();

        return $redirectUrl;
    }

    public function createCheckoutSession(Payment $payment): void
    {
        $this->setApiKey();

        $body = $this->getBody($payment);

        $this->checkoutSession = \Stripe\Checkout\Session::create($body);
    }

    public function getRedirectUrl(): string
    {
        return $this->checkoutSession->url;
    }

    public function handleStatusLogic(Request $request): Response|ResponseFactory
    {
        $this->setApiKey();

        try {
            $event = $this->constructEvent($request);
        } catch (\UnexpectedValueException $e) {
            return $this->handleUnexpectedValueException($e);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return $this->handleSignatureVerificationException($e);
        }

        $this->handleCompletedEvent($event);

        return response('', 200);
    }

    private function setSessionId(Payment $payment): void
    {
        $sessionId = $this->checkoutSession->id;

        (new PaymentService($payment))
            ->setSessionId($sessionId)
            ->save();
    }

    private function handleCompletedEvent(\Stripe\Event $event): void
    {
        if ($this->isCheckoutSessionCompleted($event)) {
            $sessionId = $event->data->object->id;

            $payment = Payment::getBySessionId($sessionId);

            $paymentService = new PaymentService($payment);

            $paymentService
                ->verify()
                ->save();
        }
    }

    private function isCheckoutSessionCompleted(\Stripe\Event  $event): bool
    {
        return $event->type == 'checkout.session.completed';
    }

    private function constructEvent(Request $request): \Stripe\Event
    {
        $endpointSecret = $this->getWebhookSecret();

        $payload = $request->getContent();

        $sigHeader = $request->header('Stripe-Signature');

        $event = \Stripe\Webhook::constructEvent(
            $payload,
            $sigHeader,
            $endpointSecret
        );

        return $event;
    }

    private function getWebhookSecret(): string
    {
        $endpointSecret = config('payments.stripe.webhook_secret');

        return $endpointSecret;
    }


    private function handleUnexpectedValueException(\UnexpectedValueException $e): Response|ResponseFactory
    {
        \Log::info('STRIPE FALLBACK | UnexpectedValueException');
        \Log::info($e->getMessage());

        return response('Invalid payload', 400);
    }

    private function handleSignatureVerificationException(\Stripe\Exception\SignatureVerificationException $e): Response|ResponseFactory
    {
        \Log::info('STRIPE FALLBACK | SignatureVerificationException');
        \Log::info($e->getMessage());

        return response('Invalid signature', 400);
    }

    private function getBody(Payment $payment): array
    {
        $domain = config('app.url');

        return [
            'line_items' => [[
                'price_data' => [
                    'currency' => 'PLN',
                    // 'currency' => 'USD',
                    // Kasa, minimum 2zł
                    // TODO refactor
                    'unit_amount_decimal' => $payment->price * 100,
                    'product_data' => [
                        'name' => 'Nazwa wyświetlana produktu dla użytkownika',
                        'description' => 'Opis wyświetlany dla użytkownika',
                        'images' => [
                            'https://place-hold.it/100',
                            'https://place-hold.it/50',
                            'https://place-hold.it/100/50',
                        ],
                        'metadata' => [
                            'payment_id' => $payment->id,
                            'metadatakey2' => 'value2',
                            'metadatakey3' => 'value3',
                        ]
                    ],
                ],
                'quantity' => 1,
            ]],
            // NOTE może też być subscription
            'mode' => 'payment',
            // TODO do configu
            'success_url' => $domain . '/payments/stripe/success',
            'cancel_url' => $domain . '/payments/stripe/cancel',
        ];
    }
}
