<?php

class Order {
    private $orderId;
    private $items;

    public function __construct($orderId, $items) {
        $this->orderId = $orderId;
        $this->items = $items;     // Массив с элементами (цена, название товара, количество)
    }

    public function getOrderId() {
        return $this->orderId;
    }

    public function getItems() {
        return $this->items;
    }
}

class OrderCostCalculator {    // Для расчёта стоимости
    public function calculateTotal(Order $order) {
        $total = 0;
        foreach ($order->getItems() as $item) {
            $total += $item[1] * $item[2];    // Цена * Количество
        }
        return $total;
    }
}

class OrderRepository {    // Cохранениe заказа в базу данных*(Имитация)
    public function save(Order $order) {
        echo "Заказ № " . $order->getOrderId() . " сохраняется в базе данных вместе с товарами: "  . "\n";
    }
}

class NotificationService {    // Отправка уведомлений клиенту(Имитация)
    public function sendNotification(Order $order) {
        echo "Отправлено уведомление о заказе № " . $order->getOrderId() . "\n";
    }
}

class OrderProcessor {    // Обработка заказа для расчёта стоимости
    private $costCalculator;
    private $repository;
    private $notificationService;

    public function __construct(OrderCostCalculator $costCalculator, OrderRepository $repository, NotificationService $notificationService) {
        $this->costCalculator = $costCalculator;
        $this->repository = $repository;
        $this->notificationService = $notificationService;
    }

    public function process(Order $order) {    // Объеденяет все процессы
        $totalCost = $this->costCalculator->calculateTotal($order);
        echo "Общая стоимость заказа № " . $order->getOrderId() . ": " . $totalCost . "\n";

        $this->repository->save($order);
        $this->notificationService->sendNotification($order);
    }
}

$order = new Order(1, [["item1", 100.0, 3], ["item2", 50.0, 1]]);

$orderProcessor = new OrderProcessor(
    new OrderCostCalculator(),
    new OrderRepository(),
    new NotificationService()
);

$orderProcessor->process($order);