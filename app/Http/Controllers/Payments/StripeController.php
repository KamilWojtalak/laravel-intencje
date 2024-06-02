<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Services\Payments\StripeService;
use Illuminate\Http\Request;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use \Illuminate\Contracts\View\Factory as ViewFactory;
use \Illuminate\Contracts\View\View;

class StripeController extends Controller
{
    // TODO do wyrzucenia
    public function index(): View|ViewFactory
    {
        return view('public.payments.stripe.index');
    }

    // TODO do wyrzucenia
    public function store(): RedirectResponse
    {
        $redirectUrl = (new StripeService())
            ->handleStoreCheckout();

        return redirect()->away($redirectUrl);
    }

    public function status(Request $request): Response|ResponseFactory
    {
        $stripe = new StripeService();

        $response = $stripe->handleStatusLogic($request);

        return $response;
    }

    public function success()
    {
        return view('public.payments.stripe.success');
    }

    public function cancel()
    {
        return view('public.payments.stripe.cancel');
    }
}
