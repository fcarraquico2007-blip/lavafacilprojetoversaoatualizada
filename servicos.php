<?php
// servicos.php
require_once 'conexao.php';
$config = require 'config_servicos.php';

try {
    $stmt = $pdo->query("SELECT cod_tiposervico, descricao FROM tipos_servicos ORDER BY cod_tiposervico");
    $tipos = $stmt->fetchAll();
} catch (\PDOException $e) {
    die("Erro ao carregar os serviços: " . htmlspecialchars($e->getMessage()));
}

// Ícone e categoria para cada serviço. Ajusta os emojis à vontade,
// ou troca por <img>/SVG se preferires ícones próprios.
$meta = [
    1  => ['icone' => '🧺', 'categoria' => 'servicos'],
    2  => ['icone' => '🌬️', 'categoria' => 'servicos'],
    3  => ['icone' => '👔', 'categoria' => 'servicos'],
    4  => ['icone' => '🚚', 'categoria' => 'domicilio'],
    5  => ['icone' => '📦', 'categoria' => 'domicilio'],
    6  => ['icone' => '🔄', 'categoria' => 'packs'],
    7  => ['icone' => '⭐', 'categoria' => 'packs'],
    8  => ['icone' => '📅', 'categoria' => 'mensal'],
    9  => ['icone' => '📅', 'categoria' => 'mensal'],
    10 => ['icone' => '📅', 'categoria' => 'mensal'],
];

$categorias = [
    'servicos'  => 'Serviços',
    'domicilio' => 'Recolha & Entrega',
    'packs'     => 'Packs',
    'mensal'    => 'Planos mensais',
];

// Agrupar os serviços por categoria, na ordem definida acima.
$grupos = array_fill_keys(array_keys($categorias), []);
foreach ($tipos as $tipo) {
    $id = $tipo['cod_tiposervico'];
    $cat = $meta[$id]['categoria'] ?? 'servicos';
    $grupos[$cat][] = $tipo;
}

function preco_teaser(array $cfg): string {
    if ($cfg['mostrar_kg']) {
        return number_format($cfg['preco_kg'], 2, ',', '.') . ' € /Kg';
    }
    return number_format($cfg['preco_fixo'], 2, ',', '.') . ' €';
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serviços - LavaFácil</title>
    <link rel="stylesheet" href="css/servicos.css">
</head>
<body>

<header class="hero">
    <p class="hero-marca">LavaFácil</p>
    <h1>Os nossos Serviços</h1>
    <p class="hero-subtitulo">Escolhe o serviço que queres agendar — a preços claros, sem surpresas.</p>
</header>

<main class="wrapper">
    <?php foreach ($categorias as $chave => $titulo): ?>
        <?php if (empty($grupos[$chave])) continue; ?>
        <section class="secao-categoria">
            <h2><?php echo htmlspecialchars($titulo); ?></h2>
            <div class="grelha-servicos">
                <?php foreach ($grupos[$chave] as $tipo):
                    $id = $tipo['cod_tiposervico'];
                    $cfg = $config[$id] ?? null;
                    $icone = $meta[$id]['icone'] ?? '🧺';
                ?>
                    <a class="cartao-servico" href="agendar.php?id=<?php echo (int) $id; ?>">
                        <span class="icone-servico"><?php echo $icone; ?></span>
                        <span class="nome-servico"><?php echo htmlspecialchars($tipo['descricao']); ?></span>
                        <?php if ($cfg): ?>
                            <span class="preco-servico">desde <?php echo preco_teaser($cfg); ?></span>
                        <?php endif; ?>
                        <span class="seta-servico">Agendar &rarr;</span>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endforeach; ?>
</main>

</body>
</html>