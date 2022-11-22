<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;
use App\Models\User;
use App\Models\Calculation\Calculation;


class WebhookController extends CashierController
{
    /**
     * Handle customer subscription created.
     *
     * @param  array $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function handleCustomerSubscriptionCreated(array $payload)
    {
        $this->setStripeCustomerId($payload);

        return parent::handleCustomerSubscriptionCreated($payload);
    }

    /**
     * Handle customer subscription updated.
     *
     * @param  array  $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function handleCustomerSubscriptionUpdated(array $payload)
    {
        $this->handleCustomerSubscriptionCreatedWithoutResponse($payload);

        return parent::handleCustomerSubscriptionUpdated($payload);
    }

    /**
     * Handle customer subscription created.
     *
     * @param  array $payload
     * @return void
     */
    protected function handleCustomerSubscriptionCreatedWithoutResponse(array $payload)
    {
       echo "i am hear";
       die;
        $this->setStripeCustomerId($payload);

        $user = $this->getUserByStripeId($payload['data']['object']['customer']);
       
        if ($user) {
            $data = $payload['data']['object'];
           
            if (! $user->subscriptions->contains('stripe_id', $data['id'])) {
                if (isset($data['trial_end'])) {
                    $trialEndsAt = Carbon::createFromTimestamp($data['trial_end']);
                } else {
                    $trialEndsAt = null;
                }

                $firstItem = $data['items']['data'][0];
                $isSinglePlan = count($data['items']['data']) === 1;

                $subscription = $user->subscriptions()->create([
                    'name' => $data['metadata']['name'] ?? $this->newSubscriptionName($payload),
                    'stripe_id' => $data['id'],
                    'stripe_status' => $data['status'],
                    'stripe_plan' => $isSinglePlan ? $firstItem['plan']['id'] : null,
                    'quantity' => $isSinglePlan && isset($firstItem['quantity']) ? $firstItem['quantity'] : null,
                    'trial_ends_at' => $trialEndsAt,
                    'ends_at' => null,
                ]);

                foreach ($data['items']['data'] as $item) {
                    $subscription->items()->create([
                        'stripe_id' => $item['id'],
                        'stripe_plan' => $item['plan']['id'],
                        'quantity' => $item['quantity'] ?? null,
                    ]);
                }
            }
        }
       
    }

    /**
     * Handle paymnent intent succeeded.
     *
     * @param  array $payload
     * @return void
     */
    protected function handlePaymentIntentSucceeded(array $payload)
    {
        $this->setStripeCustomerId($payload);

        $calculationId = (int) $payload['data']['object']['metadata']['calculation_id'];

        $calculation = Calculation::find($calculationId);

        if (!$calculation) {
            return;
        }

        $calculation->accessable = true;

        $calculation->save();
    }

    /**
     * Set stripe customer id to a user.
     *
     * @param  array $payload
     * @return void
     */
    protected function setStripeCustomerId(array $payload)
    {
        if (isset(
            $payload['data']['object']['metadata']['user_id']
        )) {
            $userId = (int) $payload['data']['object']['metadata']['user_id'];

            $user = User::find($userId);

            if ($user) {
                $user->stripe_id = $payload['data']['object']['customer'];

                $user->save();
            }
        }
    }
}
