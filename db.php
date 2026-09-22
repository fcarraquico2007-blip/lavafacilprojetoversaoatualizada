<?php
/**
 * db.php
 * Ligação à base de dados via PDO. Ajusta as credenciais conforme o teu Laragon/MySQL.
 */

$host   = 'localhost';
$dbname = 'lavafacil';   // ajusta ao nome real da tua base de dados
$user   = 'root';
$pass   = 'KiKo_2007..';

try {
    $pdo = new PDO(
        "mysql:host={$host};dbname={$dbname};charset=utf8mb4",
        $user,
        $pass
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'success' => false,
        'message' => 'Erro de ligação à base de dados.'
    ]);
    exit;
}
