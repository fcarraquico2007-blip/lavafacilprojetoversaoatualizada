<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lavafacil";

try {

    $conn = new PDO(
        "mysql:host=$servername;dbname=$dbname;charset=utf8",
        $username,
        $password
    );

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {

    die("Erro na ligação: " . $e->getMessage());

}

function wFicheiroError($texto){

    $file = __DIR__ . "/../error.txt";

    $linha = date("Y-m-d H:i:s") . " - " . $texto . PHP_EOL;

    file_put_contents($file, $linha, FILE_APPEND);

}

?>