<?php

namespace App\Services\Models;

use App\Models\Payment;

class PaymentService
{
    public function __construct(protected ?Payment $payment)
    {
        if ($this->thereIsNoPayment())
        {
            $this->makeEmptyPayment();
        }
    }

    public function setPaymentStatus(string $paymentStatus): self
    {
        $this->payment->status = $paymentStatus;

        return $this;
    }

    public function verify(): self
    {
        $this->setPaymentStatus(Payment::STATUS_VERIFIED);

        return $this;
    }

    public function save(): self
    {
        $this->payment->save();

        return $this;
    }

    private function thereIsNoPayment(): bool
    {
        return is_null($this->payment);
    }

    private function makeEmptyPayment(): void
    {
        $this->payment = Payment::make();
    }
}
