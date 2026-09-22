<?php
/**
 * contactos.php
 * Recebe os dados do formulário de contactos via POST (fetch/AJAX)
 * e envia um email para a LavaFácil. Devolve sempre JSON.
 */

header('Content-Type: application/json; charset=utf-8');

// Só aceita pedidos POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Método não permitido.'
    ]);
    exit;
}

// --- Recolher e limpar os dados ---
$nome      = trim($_POST['nome'] ?? '');
$email     = trim($_POST['email'] ?? '');
$mensagem  = trim($_POST['mensagem'] ?? '');

// --- Validação no servidor (nunca confiar só no JS) ---
$erros = [];

if ($nome === '') {
    $erros[] = 'O nome é obrigatório.';
}

if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erros[] = 'Indica um email válido.';
}

if ($mensagem === '') {
    $erros[] = 'A mensagem não pode estar vazia.';
}

if (!empty($erros)) {
    echo json_encode([
        'success' => false,
        'message' => implode(' ', $erros)
    ]);
    exit;
}

// --- Preparar o email ---
$destinatario = 'LavaFacil.pt@gmail.com'; // email da empresa
$assunto      = 'Nova mensagem de contacto - Site LavaFácil';

$corpo  = "Recebeste uma nova mensagem através do formulário de contactos do site:\n\n";
$corpo .= "Nome: {$nome}\n";
$corpo .= "Email: {$email}\n";
$corpo .= "Mensagem:\n{$mensagem}\n";

// Cabeçalhos do email
$headers   = [];
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-Type: text/plain; charset=UTF-8';
$headers[] = 'From: LavaFácil <no-reply@lavafacil.pt>'; // idealmente um domínio teu
$headers[] = 'Reply-To: ' . $nome . ' <' . $email . '>';

$headersString = implode("\r\n", $headers);

// --- Enviar o email ---
$enviado = @mail($destinatario, $assunto, $corpo, $headersString);

if ($enviado) {
    echo json_encode([
        'success' => true,
        'message' => 'Mensagem enviada com sucesso! Entraremos em contacto brevemente.'
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Não foi possível enviar a mensagem neste momento. Tenta novamente mais tarde.'
    ]);
}