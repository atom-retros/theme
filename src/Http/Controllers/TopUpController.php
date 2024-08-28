<?php

namespace Atom\Theme\Http\Controllers;

use Illuminate\Routing\Controller;
use Atom\Core\Models\WebsiteSetting;
use Srmklive\PayPal\Services\PayPal;
use Illuminate\Http\RedirectResponse;
use Atom\Theme\Http\Requests\TopUpRequest;

class TopUpController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function __invoke(PayPal $paypal, TopUpRequest $request): RedirectResponse
    {
        $settings = WebsiteSetting::whereIn('key', ['hotel_name'])
            ->pluck('value', 'key');

        $response = $paypal->createOrder([
            'intent' => 'CAPTURE',
            'application_context' => [
                'return_url' => route('shop.successful-transaction'),
                'cancel_url' => route('shop.cancelled-transaction'),
                'brand_name' => $settings->get('hotel_name'),
                'landing_page' => 'BILLING',
                'shipping_preference' => 'NO_SHIPPING',
                'user_action' => 'CONTINUE'
            ],
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => config('paypal.currency'),
                        'value' => (string) $request->get('amount'),
                    ],
                ],
            ],
        ]);

        if (isset($response['error'])) {
            return redirect()
                ->route('shop.index')
                ->withErrors(['amount' => __('Something went wrong')]);
        }

        foreach ($response['links'] as $links) {
            if ($links['rel'] === 'approve') {
                $request->user()->transactions()->create([
                    'transaction_id' => $response['id'],
                    'amount' => 0,
                ]);

                return redirect()->away($links['href']);
            }
        }

        return redirect()
            ->route('shop.index')
            ->withErrors(['amount' => __('Something went wrong')]);
    }
}
