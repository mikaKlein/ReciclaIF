<?php
if (isset($_POST['botao'])) {
    require_once __DIR__ . "/vendor/autoload.php";

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $usuario = Usuario::findByEmail($email);

    if (!$usuario) {
        echo "Usuário não encontrado!";
        exit;
    }

    if (password_verify($senha, $usuario->getSenha())) {
        session_start();
        $_SESSION['id'] = $usuario->getIdUser();
        header("Location: index.php");
        exit;
    } else {
        echo "Senha ou email incorretos!";
        exit;
    }
}
?>