<?php

namespace Orders;

class Order
{
    public int $order_id;

    public bool $is_manual = false;

    public string $name;

    public array $items;

    public float $totalAmount;

    public string $deliveryDetails;

    public bool $is_valid;

    public function setName(string $name): Order
    {
        $this->name = $name;
        return $this;
    }

    public function setItems(array $items): Order
    {
        $this->items = $items;
        return $this;
    }

    public function setTotalAmount(float $totalAmount): Order
    {
        $this->totalAmount = $totalAmount;
        return $this;
    }

    public function setOrderId(int $order_id): Order
    {
        $this->order_id = $order_id;
        return $this;
    }

    public function setDeliveryDetails($deliveryDetails): Order
    {
        $this->deliveryDetails = $deliveryDetails;
        return $this;
    }

    public function getCountItems(): int
    {
        return count($this->items);
    }
}