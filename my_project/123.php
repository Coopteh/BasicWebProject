<?php

class Product {
    public $name;
    public $price;

    public function __construct(string $name, float $price) {
        $this->name = $name;
        $this->price = $price;
    }
}

class OrderItem {
    public $product;
    public $quantity;

    public function __construct(Product $product, int $quantity) {
        $this->product = $product;
        $this->quantity = $quantity;
    }
}

class Order {
    public $orderId;
    public $items;

    public function __construct(int $orderId, array $items) {
        $this->orderId = $orderId;
        $this->items = $items;
    }
}

class PricingService {
    public function calculateTotalPrice(Order $order): float {
        $total = 0.0;
        foreach ($order->items as $item) {
            $total += $item->product->price * $item->quantity;
        }
        return $total;
    }
}

class DatabaseService {
    public function saveOrderToDatabase(Order $order) {
        echo "Сохраняем заказ {$order->orderId} в базу данных <br>";
    }
}

class NotificationService {
    public function sendNotification(Order $order) {
        echo "Отправляем уведомление о заказе {$order->orderId} <br>";
    }
}

class OrderProcessor {
    public function __construct(
        private PricingService $pricingService,
        private DatabaseService $databaseService,
        private NotificationService $notificationService
    ) {}

    public function process(Order $order) {
        $totalPrice = $this->pricingService->calculateTotalPrice($order);
        echo "Общая стоимость заказа: $totalPrice <br>";

        $this->databaseService->saveOrderToDatabase($order);
        $this->notificationService->sendNotification($order);
    }
}


$productA = new Product('Товар A', 100.0);
$productB = new Product('Товар B', 200.0);

$item1 = new OrderItem($productA, 2);
$item2 = new OrderItem($productB, 1);

$order = new Order(1, [$item1, $item2]);

$pricingService = new PricingService();
$databaseService = new DatabaseService();
$notificationService = new NotificationService();

$processor = new OrderProcessor($pricingService, $databaseService, $notificationService);

$processor->process($order);
?>