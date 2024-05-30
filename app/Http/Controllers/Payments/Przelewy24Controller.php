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
            Log::info("NOTYFIKACJA P24 | NIE PRZESZLO");
            Log::error($th->getMessage());
        }
    }

    public function callback()
    {
        return view('przelewy24.callback');
    }

    private function handleStatus(Request $request): void
    {
        Log::info("NOTYFIKACJA P24");
        Log::info(json_encode($request->all()));

        $payment_verify = app()->make(\Devpark\Transfers24\Requests\Transfers24::class);
        $payment_response = $payment_verify->receive($request);

        if ($payment_response->isSuccess()) {
            // TODO Add payment
            $order = Payment::where('payment_session_id', $payment_response->getSessionId())->firstOrFail();

            $order->status = Payment::STATUS_PAYMENT_NOTIFICATION;
            $order->payment_order_id = $request->get('orderId');
            $order->status = Payment::STATUS_PAYMENT_VERIFIED;

            $order->save();

            Log::info("SPRAWDZAM VERIFY Przeszło całe");
        }
        echo "OK";
    }
}
