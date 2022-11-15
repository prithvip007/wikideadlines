<?php

namespace Laravel\Cashier\Exceptions;

use Laravel\Cashier\Payment;

class PaymentActionRequired extends IncompletePayment
{
    /**
     * Create a new PaymentActionRequired instance.
     *
     * @param  \Laravel\Cashier\Payment  $payment
     * @return static
     */
    public static function incomplete(Payment $payment)
    {
        echo "<pre>";
        echo "in payment action page 0";
        print_r($payment);
        die;
        return new static(
            $payment,
            'The payment attempt failed because additional action is required before it can be completed.'
        );
    }
}
