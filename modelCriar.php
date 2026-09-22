<?php

require_once "connection.php";

class Criar
{

    public function criarConta($nome, $email, $pass, $cpass)
    {

        global $conn;

        $flag = false;
        $msg = "";

        // Verificar se as passwords coincidem
        if ($pass != $cpass) {

            return json_encode(array(
                "flag" => false,
                "msg" => "As palavras-passe não coincidem."
            ));

        }

        try {

            // Verificar se o email já existe
            $sql = "SELECT id FROM criar WHERE email = ?";

            $stmt = $conn->prepare($sql);
            $stmt->execute([$email]);

            if ($stmt->rowCount() > 0) {

                return json_encode(array(
                    "flag" => false,
                    "msg" => "Este email já se encontra registado."
                ));

            }

            // Encriptar password
            $pw = md5($pass);

            // Inserir utilizador
            $sql = "INSERT INTO criar (nome,email,pass) VALUES (?,?,?)";

            $stmt = $conn->prepare($sql);

            if ($stmt->execute([$nome,$email,$pw])) {

                $flag = true;
                $msg = "Conta criada com sucesso!";

            } else {

                $msg = "Não foi possível criar a conta.";

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

}

?>