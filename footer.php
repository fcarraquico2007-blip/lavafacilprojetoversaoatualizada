<?php
/**
 * layoutfrancisco/footer.php
 * Rodapé reutilizável, incluído no fim de <main class="content"> ou antes de </body>.
 *
 * Como usar:
 *   <?php include __DIR__ . '/layoutfrancisco/footer.php'; ?>
 */
$anoAtual = date('Y');
?>
<footer class="app-footer">
    <span>&copy; <?= htmlspecialchars($anoAtual) ?> LavaFácil. Todos os direitos reservados.</span>
    <span class="app-footer-versao">v1.0</span>
</footer>

