<?php
/**
 * layoutfrancisco/navbar.php
 * Barra superior (topbar) reutilizável.
 *
 * Como usar: define as variáveis ANTES do include (todas opcionais)
 * e depois inclui o ficheiro:
 *
 *   <?php
 *     $tituloPagina    = 'Bem-vindo, administrador! 👋';
 *     $subtituloPagina = 'Aqui está o resumo geral do desempenho da LavaFácil.';
 *     include __DIR__ . '/layoutfrancisco/navbar.php';
 *   ?>
 *
 * Se não definires nada, aparecem valores genéricos por omissão.
 */

$tituloPagina    = $tituloPagina    ?? 'Bem-vindo, administrador! 👋';
$subtituloPagina = $subtituloPagina ?? '';
$mostrarData     = $mostrarData     ?? true;

// Formata a data em português (ex.: "16 de setembro de 2026")
$mesesPt = [
    1 => 'janeiro', 2 => 'fevereiro', 3 => 'março', 4 => 'abril',
    5 => 'maio', 6 => 'junho', 7 => 'julho', 8 => 'agosto',
    9 => 'setembro', 10 => 'outubro', 11 => 'novembro', 12 => 'dezembro'
];
$hoje = new DateTime();
$dataFormatada = $hoje->format('j') . ' de ' . $mesesPt[(int) $hoje->format('n')] . ' de ' . $hoje->format('Y');
?>
<header class="topbar">
    <div>
        <h2><?= htmlspecialchars($tituloPagina) ?></h2>
        <?php if ($subtituloPagina): ?>
            <p><?= htmlspecialchars($subtituloPagina) ?></p>
        <?php endif; ?>
        <?php if ($mostrarData): ?>
            <small class="text-muted"><?= htmlspecialchars($dataFormatada) ?></small>
        <?php endif; ?>
    </div>
    <button class="btn btn-light" type="button" id="btnNotificacoes">
        <i class="fa fa-bell"></i>
    </button>
</header>
