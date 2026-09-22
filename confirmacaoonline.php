<?php

require_once 'conexao.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare(
    "SELECT s.data_hora_prevista, s.valor_servico, s.local, ts.descricao AS servico
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
<title>Pagamento - LavaFácil</title>
<link rel="stylesheet" href="public/assets/css/confirmacao.css">
</head>
<body>

<div class="container">
    <section class="card">

        <h1>Pagamento Online</h1>
        <p class="msg">Confirme os dados antes de prosseguir com o pagamento.</p>

        <div class="info">
            <p><strong>Serviço:</strong> <?php echo htmlspecialchars($pedido['servico']); ?></p>
            <p><strong>Data:</strong> <?php echo $dataHora->format('d/m/Y'); ?></p>
            <p><strong>Hora:</strong> <?php echo $dataHora->format('H:i'); ?></p>
            <p><strong>Localidade:</strong> <?php echo htmlspecialchars($pedido['local']); ?></p>
            <p><strong>Preço estimado:</strong> <?php echo number_format($pedido['valor_servico'], 2, ',', '.'); ?>€</p>
        </div>

        <button class="btn voltar" onclick="window.location.href='metodosdepagamento.php?id=<?php echo $id; ?>'">Pagar agora</button>
<br>
        <button class="btn voltar" onclick="window.location.href='index.php'">Voltar</button>

    </section>
</div>

</body>
</html>
