<?php

require_once "connection.php";

class Login
{

    function login($email, $pass)
    {

        global $conn;

        $flag = false;
        $msg = "";

        $pw = md5($pass);

        try {

            $sql = "SELECT * FROM criar WHERE email = ? AND pass = ?";

            $stmt = $conn->prepare($sql);
            $stmt->execute([$email, $pw]);

            if ($stmt->rowCount() == 1) {

                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                session_start();

                $_SESSION["id"] = $user["id"];
                $_SESSION["nome"] = $user["nome"];
                $_SESSION["email"] = $user["email"];

                $flag = true;
                $msg = "Login efetuado com sucesso.";

            } else {

                $msg = "Email ou palavra-passe incorretos.";

            }

        } catch (PDOException $e) {

            $msg = $e->getMessage();
            wFicheiroError($msg);

        }

        return json_encode(array(
            "flag" => $flag,
            "msg" => $msg
        ));
    }


    function logout()
    {

        session_start();

        session_destroy();

        return json_encode(array(
            "flag" => true,
            "msg" => "Sessão terminada."
        ));

    }

}

?>