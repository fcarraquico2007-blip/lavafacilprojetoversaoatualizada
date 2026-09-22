<?php
header('Content-Type: application/json');
require_once 'vendor/autoload.php';
require_once 'conexao.php';

// Chave Secreta da Stripe (sk_test_...)
\Stripe\Stripe::setApiKey('sk_test_51UBAyaL3XJ7ajDGDfik7m2Ahwi3aO85OB6Od9k7hdyeMNO85X7FfmD3Ocn7Ij0cFyvYKOgZyc5OS2fM1OTGNUqlQ00sLwv7MXs');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare("SELECT valor_servico FROM servicos WHERE id_servico = ?");
$stmt->execute([$id]);
$valor = $stmt->fetchColumn();

if ($valor === false) {
    echo json_with_error("Pedido não encontrado no banco de dados.");
    exit;
}

$valorEmCentimos = (int)($valor * 100);

try {
    // Cria uma intenção de pagamento no servidor da Stripe
    $paymentIntent = \Stripe\PaymentIntent::create([
        'amount' => $valorEmCentimos,
        'currency' => 'eur',
        'metadata' => ['id_servico' => $id]
    ]);

    // Devolve o Client Secret essencial que o JavaScript precisa para fechar a transação
    echo json_encode(['client_secret' => $paymentIntent->client_secret]);

} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}

function json_with_error($msg) {
    return json_encode(['error' => $msg]);
}
