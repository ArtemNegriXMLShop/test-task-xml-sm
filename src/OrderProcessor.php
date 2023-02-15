<?php

namespace Orders;

class OrderProcessor
{
    private const ITEMS_DELIVERY = [3231, 9823];

    private OrderValidator $validator;
    private OrderPrint $orderPrint;

    public function __construct(private OrderDeliveryDetails $orderDeliveryDetails)
    {
        $this->validator = OrderValidator::create();
        $this->orderPrint = new OrderPrint();
    }

    public function process(Order $order): void
    {
        $this->validator->validate($order);

        if ($order->is_valid) {
            $this->addDeliveryCostLargeItem($order);
            $deliveryDetails = $this->orderDeliveryDetails->getDeliveryDetails($order->getCountItems());
            $order->setDeliveryDetails($deliveryDetails);
        }

        $this->orderPrint->setOrder($order);
        $this->orderPrint->writeToFiles();
    }

    private function addDeliveryCostLargeItem(Order $order): void
    {
        foreach ($order->items as $item) {
            if (in_array($item, self::ITEMS_DELIVERY, true)) {
                $order->totalAmount += 100;
            }
        }
    }

}