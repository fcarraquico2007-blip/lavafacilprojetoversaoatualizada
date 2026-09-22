<?php
/**
 * gerar_hash.php
 * Ferramenta só para gerares o hash da password do admin uma vez.
 * Usa: localhost/.../gerar_hash.php?pass=AtuaPasswordAqui
 * Depois copia o hash gerado para o INSERT do schema_utilizadores.sql.
 * APAGA ESTE FICHEIRO depois de usares — não deve ficar no servidor em produção.
 */

$pass = $_GET['pass'] ?? '';

if ($pass === '') {
    echo 'Usa: gerar_hash.php?pass=AtuaPasswordAqui';
    exit;
}

echo password_hash($pass, PASSWORD_DEFAULT);
