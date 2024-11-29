<?php

session_start();

if (isset($_POST['botao'])) {
    require_once __DIR__ . "/vendor/autoload.php";

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    if (!$email) {
        $_SESSION['erro'] = "E-mail ou senha incorretos. Tente novamente!";
        header("Location: login.php"); // Redireciona para a página de login com erro
        exit;
    }

    if (!preg_match('/@aluno\.feliz\.ifrs\.edu\.br$/', $email)) {
        $_SESSION['erro'] = "E-mail ou senha incorretos. Tente novamente!";
        header("Location: login.php"); // Redireciona para a página de login com erro
        exit;
    }

    // Buscar o usuário no banco de dados
    $usuario = Usuario::findByEmail($email);
    if (!$usuario || !password_verify($senha, $usuario->getSenha())) {
        $_SESSION['erro'] = "E-mail ou senha incorretos. Tente novamente!";
        header("Location: login.php"); // Redireciona para a página de login com erro
        exit;
    }

    if (password_verify($senha, $usuario->getSenha())) {
        $_SESSION['id'] = $usuario->getIdUser();
        header("Location: index.php");
        exit;
    } else {
        echo "Senha ou email incorretos!";
        exit;
    }
}
?>