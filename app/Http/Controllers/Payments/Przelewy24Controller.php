<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Przelewy24Controller extends Controller
{
    /**
     * @var Request $request
     * <code>
     * {
     *     "merchantId": 0,
     *     "posId": 0,
     *     "sessionId": "string",
     *     "amount": 0,
     *     "originAmount": 0,
     *     "currency": "PLN",
     *     "orderId": 0,
     *     "methodId": 0,
     *     "statement": "string",
     *     "sign": "string"
     * }
     * </code>
     */
    public function status(Request $request): void
    {
        try {
            $this->handleStatus($request);
        } catch (\Throwable $th) {
            Log::channel('payments')->info("NOTYFIKACJA P24 | NIE PRZESZLO");
            Log::channel('payments')->error($th->getMessage());
        }
    }

    public function callback()
    {
        return view('public.payments.przelewy24.callback');
    }

    // TODO clean code
    private function handleStatus(Request $request): void
    {
        Log::channel('payments')->info("NOTYFIKACJA P24");
        Log::channel('payments')->info(json_encode($request->all()));

        $paymentVerify = app()->make(\Devpark\Transfers24\Requests\Transfers24::class);
        $paymentResponse = $paymentVerify->receive($request);

        if ($paymentResponse->isSuccess()) {
            $order = Payment::where('session_id', $paymentResponse->getSessionId())->firstOrFail();

            $order->provider_order_id = $request->get('orderId');
            $order->status = Payment::STATUS_VERIFIED;

            $order->save();

            Log::channel('payments')->info("SPRAWDZAM VERIFY Przeszło całe");
        }

        echo "OK";
    }
}
