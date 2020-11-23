<?php
session_start();

require 'stripe/init.php';
\Stripe\Stripe::setApiKey('sk_test_51HpXn4JBN8VtgqpQaY5hScHtja7TvXUkFQ49VuzIL0cB3VklDmHsjauiJV3OjdR520WQgVOc1RZeQfYz7L2SpLae001IjnCYD8');
header('Content-Type: application/json');
$YOUR_DOMAIN = 'http://dawjavi.insjoaquimmir.cat';
$checkout_session = \Stripe\Checkout\Session::create([
  'payment_method_types' => ['card'],
  'line_items' => [[
    'price_data' => [
      'currency' => 'eur',
      'unit_amount' => $_SESSION["precio_total"] * 100,
      'product_data' => [
        'name' => 'Pedido',
        'images' => ["https://i.imgur.com/EHyR2nP.png"],
      ],
    ],
    'quantity' => 1,
  ]],
  'mode' => 'payment',
  'success_url' => $YOUR_DOMAIN . '/dhernandez/UF1/Ejercicio7/ok.php',
  'cancel_url' => $YOUR_DOMAIN . '/dhernandez/UF1/Ejercicio7/ko.php',
]);
echo json_encode(['id' => $checkout_session->id]);

https://youtu.be/xucf6Pa5004?t=1191