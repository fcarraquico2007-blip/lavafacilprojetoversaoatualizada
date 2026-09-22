<?php
// Página atual (ex.: "calendario.php"), usada para marcar o link ativo
$paginaAtual = basename($_SERVER['PHP_SELF']);

function linkAtivo(string $pagina, string $paginaAtual): string
{
    return $pagina === $paginaAtual ? 'active' : '';
}

// Nome e email vêm da sessão criada no login.php
$nomeUtilizador  = $_SESSION['nome']  ?? '';
$emailUtilizador = $_SESSION['email'] ?? '';
?>

<!doctype html>
<html lang="pt-PT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Simulador de IRC</title>
  
    <link rel="stylesheet" href="public/assets/css/dashboard.css">
     

   
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
      
</head>
<aside class="sidebar">
    <a class="navbar-brand fw-bold fs-3" href="dashboard.php">
        <img src="img/logo.png" style="height: 120px; width: auto;" alt="LavaFácil">
    </a>

    <div class="user-menu">
        <div class="user-box" id="userToggle">
            <div class="user-avatar">
                <i class="fa-solid fa-user"></i>
            </div>
            <div>
                <strong><?= htmlspecialchars($nomeUtilizador) ?></strong><br>
                <small><?= htmlspecialchars($emailUtilizador) ?></small>
            </div>
        </div>

        <div class="user-dropdown" id="userDropdown">
            <a href="#"><i class="fa-solid fa-gear"></i> Definições</a>
            <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Sair</a>
        </div>
    </div>

    <nav>
        <a href="dashboard.php" class="<?= linkAtivo('dashboard.php', $paginaAtual) ?>">
            <i class="fa fa-gauge"></i> Dashboard
        </a>
        <a href="calendario.php" class="<?= linkAtivo('calendario.php', $paginaAtual) ?>">
            <i class="fa fa-calendar"></i> Agendamentos
        </a>
        <a href="servicos.php" class="<?= linkAtivo('servicos.php', $paginaAtual) ?>">
            <i class="fa fa-soap"></i> Serviços
        </a>
        <a href="gastos_rendimentos.php" class="<?= linkAtivo('gastos_rendimentos.php', $paginaAtual) ?>">
            <i class="fa fa-euro-sign"></i> Gastos e Rendimentos
        </a>
        <a href="projecoes.php" class="<?= linkAtivo('projecoes.php', $paginaAtual) ?>">
            <i class="fa fa-chart-line"></i> Projeções
        </a>
        <a href="irc.php" class="<?= linkAtivo('irc.php', $paginaAtual) ?>">
            <i class="fa fa-scale-balanced"></i> Simulador IRC
        </a>
        <a href="entidades.php" class="<?= linkAtivo('entidades.php', $paginaAtual) ?>">
            <i class="fa fa-building"></i> Entidades
        </a>
        <a href="recursos_humanos.php" class="<?= linkAtivo('recursos_humanos.php', $paginaAtual) ?>">
            <i class="fa fa-people-group"></i> Recursos Humanos
        </a>
    </nav>
</aside>