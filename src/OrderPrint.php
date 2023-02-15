<?php

namespace Orders;

class OrderPrint
{
    public Order $order;

    public function setOrder(Order $order): void
    {
        $this->order = $order;
    }

    public function writeToFiles(): void
    {
        $this->writeToOrderProcessLog();

        if ($this->order->is_valid) {
            $this->writeToResult();
        }
    }

    private function writeToOrderProcessLog(): void
    {
        $printArray['header'] = "Processing started, OrderId: {$this->order->order_id}\n";
        $printArray['orderValidStatus'] = "Order is invalid\n";

        if ($this->order->is_valid) {
            $printArray['orderValidStatus'] = "Order is valid\n";
            $printArray['$infoOrderManual'] = $this->getInfoOrderManual();
        }

        file_put_contents(
            'orderProcessLog',
            @file_get_contents('orderProcessLog').implode("", $printArray)
        );
    }

    private function getInfoOrderManual(): string
    {
        if ($this->order->is_manual) {
            return "Order \"".$this->order->order_id."\" NEEDS MANUAL PROCESSING\n";
        }
        return "Order \"".$this->order->order_id."\" WILL BE PROCESSED AUTOMATICALLY\n";
    }

    private function writeToResult(): void
    {
        file_put_contents(
            'result',
            @file_get_contents('result').$this->getOrderInfo()."\n"
        );
    }

    private function getOrderInfo(): string
    {
        return sprintf(
            '%d-%s-%s-%d-%01.1f-%s',
            $this->order->order_id,
            implode(',', $this->order->items),
            $this->order->deliveryDetails,
            $this->order->is_manual,
            $this->order->totalAmount,
            $this->order->name
        );
    }
}