<?php

include_once "../model/modelLogin.php";

$login = new Login();

if ($_POST['op'] == 1) {

    $resp = $login->login(
        $_POST['email'],
        $_POST['pass']
    );

    echo $resp;

} else if ($_POST['op'] == 2) {

    $resp = $login->logout();

    echo $resp;

}

?>