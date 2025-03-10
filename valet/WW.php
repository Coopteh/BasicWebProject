<?php 
$quantity=3;
$price=550;
$discount_rate=20;
$initial_cost=$quantity*$price;
$discount=0;
if ($quantity >=3){
    $discount=($initial_cost*$discount_rate) / 100;
}
$final_cost = $initial_cost - $discount;
echo "Первоначальная стоимость:", $initial_cost. "\n";
echo "Итоговая стоимость: ", $final_cost;