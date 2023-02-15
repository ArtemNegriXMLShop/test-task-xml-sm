<?php

namespace Orders;

class OrderDeliveryDetails
{
    public function getDeliveryDetails($productsCount): string
    {
        return match ($productsCount) {
            1 => 'Order delivery time: 1 day',
            default => 'Order delivery time: 2 days',
        };
    }
}