<?php require 'vendor/autoload.php'; // Stripe SDK

\Stripe\Stripe::setApiKey('VOTRE_CLE_STRIPE');

header('Content-Type: application/json');

$input = file_get_contents("php://input");
$request = json_decode($input, true);

$user_id = $_SESSION['user_id'];
$icon_id = $request['icon_id'];

$icon_query = $conn->prepare("SELECT price, file_path FROM icons WHERE id = ?");
$icon_query->bind_param("i", $icon_id);
$icon_query->execute();
$icon_result = $icon_query->get_result()->fetch_assoc();
$price = $icon_result['price'];

$payment_intent = \Stripe\PaymentIntent::create([
    'amount' => $price * 100, // Convertir en centimes
    'currency' => 'usd',
    'metadata' => ['user_id' => $user_id, 'icon_id' => $icon_id]
]);

echo json_encode(['clientSecret' => $payment_intent->client_secret]);
?>