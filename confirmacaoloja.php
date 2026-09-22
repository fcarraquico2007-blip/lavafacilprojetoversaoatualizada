<?php
// confirmacaoloja.php
// Substitui confirmacaoloja.html. Já não depende do sessionStorage —
// lê o pedido diretamente da base de dados pelo id que vem na URL.

require_once 'conexao.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare(
    "SELECT s.data_hora_prevista, ts.descricao AS servico
     FROM servicos s
     JOIN tipos_servicos ts ON s.tipo_servico = ts.cod_tiposervico
     WHERE s.id_servico = ?"
);
$stmt->execute([$id]);
$pedido = $stmt->fetch();

if (!$pedido) {
    die('Pedido não encontrado. <a href="servicos.php">Voltar aos serviços</a>');
}

$dataHora = new DateTime($pedido['data_hora_prevista']);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação - LavaFácil</title>
    <link rel="stylesheet" href="public/assets/css/confirmacao.css">
</head>
<body>

    <div class="container">
        <section class="card">

            <h1>Pedido Confirmado</h1>

            <p class="msg">
                O seu pedido foi registado com sucesso.<br>
                Por favor entregue a roupa na loja no horário escolhido.<br>
                O peso real será confirmado no momento da entrega.
            </p>

            <div class="info">
                <p><strong>Serviço:</strong> <span><?php echo htmlspecialchars($pedido['servico']); ?></span></p>
                <p><strong>Data:</strong> <span><?php echo $dataHora->format('d/m/Y'); ?></span></p>
                <p><strong>Hora:</strong> <span><?php echo $dataHora->format('H:i'); ?></span></p>
            </div>

            <button class="btn" onclick="window.location.href='index.php'">
                Voltar ao início
            </button>

        </section>
    </div>

</body>
</html>
