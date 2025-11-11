<?php

namespace App\Services;

class PaymentService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function charge($amount)
    {
        return "Change {$amount}";
    }

    public function count($num)
    {
        return "{$num}";
    }
}
