<?php
// packs.php
// Mostra só os planos mensais (Pequeno/Médio/Grande), a que o card
// "Packs" da homepage aponta — os outros serviços já vão direto para
// agendar.php?id=X e não passam por aqui.
require_once 'conexao.php';
$config = require 'config_servicos.php';

$ids_mensais = [8, 9, 10];

try {
    $placeholders = implode(',', array_fill(0, count($ids_mensais), '?'));
    $stmt = $pdo->prepare("SELECT cod_tiposervico, descricao FROM tipos_servicos WHERE cod_tiposervico IN ($placeholders) ORDER BY cod_tiposervico");
    $stmt->execute($ids_mensais);
    $packs = $stmt->fetchAll();
} catch (\PDOException $e) {
    die("Erro ao carregar os packs: " . htmlspecialchars($e->getMessage()));
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Packs Mensais - LavaFácil</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/servicos.css">
</head>
<body>

<header class="hero">
    <div class="hero-conteudo">
        <p class="hero-marca">LavaFácil</p>
        <h1>Planos mensais para nunca mais pensares na roupa.</h1>
        <p class="hero-subtitulo">Escolhe o plano que se ajusta ao teu volume de roupa por mês.</p>
    </div>
    <div class="hero-estendal" aria-hidden="true">
        <div class="estendal-linha"></div>
        <div class="peca peca-1"></div>
        <div class="peca peca-2"></div>
        <div class="peca peca-3"></div>
    </div>
</header>

<main class="wrapper">
    <section class="secao-categoria">
        <span class="etiqueta-categoria">Planos mensais</span>
        <div class="grelha-servicos">
            <?php foreach ($packs as $pack):
                $id = $pack['cod_tiposervico'];
                $cfg = $config[$id] ?? null;
                $preco = $cfg ? number_format($cfg['preco_fixo'], 2, ',', '.') . ' € / mês' : '';
            ?>
                <a class="tag-servico" href="agendar.php?id=<?php echo (int) $id; ?>">
                    <span class="furo-tag"></span>
                    <span class="vigia-servico">📅</span>
                    <span class="nome-servico"><?php echo htmlspecialchars($pack['descricao']); ?></span>
                    <?php if ($cfg): ?>
                        <span class="preco-servico"><?php echo $preco; ?></span>
                    <?php endif; ?>
                    <span class="acao-servico">Agendar &rarr;</span>
                </a>
            <?php endforeach; ?>
        </div>
    </section>

    <p style="text-align:center; margin-top:12px;">
        <a href="index.php#servicos" style="color:#1C7C8C; font-weight:600; text-decoration:none;">&larr; Voltar aos serviços</a>
    </p>
</main>

</body>
</html>
