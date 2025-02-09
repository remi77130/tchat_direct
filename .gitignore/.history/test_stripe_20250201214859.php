<?php
require __DIR__ . '/vendor/autoload.php'; // Vérifiez le bon chemin ici !

\Stripe\Stripe::setApiKey('VOTRE_CLE_STRIPE');

try {
    $paymentIntent = \Stripe\PaymentIntent::create([
        'amount' => 100, // 1.00 USD
        'currency' => 'usd',
    ]);
    echo "Stripe fonctionne correctement 🎉";
} catch (Exception $e) {
    echo "Erreur Stripe : " . $e->getMessage();
}
?>
