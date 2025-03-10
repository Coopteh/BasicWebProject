<?php
$pizza = 3;
$price = 550;
$discount_rate = 20;
$initial_cost = $pizza * $price;
$discount=0;


if ($pizza >=3){
    $discount = ($initial_cost * $discount_rate)/100;


}

$final_cost=$initial_cost - $discount;

echo $final_cost;