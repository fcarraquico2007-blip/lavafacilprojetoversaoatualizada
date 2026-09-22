<?php

include_once "../model/modelCriar.php";

$criar = new Criar();

if ($_POST['op'] == 1) {

    $resp = $criar->criarConta(
        $_POST['nome'],
        $_POST['email'],
        $_POST['pass'],
        $_POST['cpass']
    );

    echo $resp;

}

?>