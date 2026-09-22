<?php
/**
 * logout.php
 * Termina a sessão do utilizador (cliente ou admin) e volta para a home.
 */

session_start();
$_SESSION = [];
session_destroy();

header('Location: index.php');
exit;
