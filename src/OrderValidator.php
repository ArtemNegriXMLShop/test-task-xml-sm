<?php

namespace Orders;

class OrderValidator
{
    public int $minimumAmount;

    public static function create(): OrderValidator
    {
        $validator = new self();
        $minimumAmountData = $validator->getMinimumAmountData('input/minimumAmount');
        $validator->setMinimumAmount($minimumAmountData);
        return $validator;
    }

    private function getMinimumAmountData(string $path): string
    {
        $minimumAmountData = file_get_contents($path);
        if ($minimumAmountData === false) {
            throw new \RuntimeException('Error in create OrderValidator');
        }

        return $minimumAmountData;
    }

    public function setMinimumAmount(int $amount): void
    {
        $this->minimumAmount = $amount;
    }

    public function validate(Order $order): void
    {
        $is_valid = true;

        if (!is_string($order->name) || !(strlen($order->name) > 2)) {
            $is_valid = false;
        }

        if (!($order->totalAmount > 0) || $order->totalAmount < $this->minimumAmount) {
            $is_valid = false;
        }

        foreach ($order->items as $item_id) {
            if (!is_int($item_id)) {
                $is_valid = false;
            }
        }

        $order->is_valid = $is_valid;
    }
}