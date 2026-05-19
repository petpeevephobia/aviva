<?php

// Set your secret key: remember to change this to your live secret key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys
\Stripe\Stripe::setApiKey("sk_test_eUL0p5DnSpGfO5X2p8wZb9sw");

// Token is created using Checkout or Elements!
// Get the payment token ID submitted by the form:
$token = $_POST['stripeToken'];

$charge = \Stripe\Charge::create([
    'amount' => 0.01,
    'currency' => 'usd',
    'description' => 'Example charge',
    'source' => $token,
]);

 ?>