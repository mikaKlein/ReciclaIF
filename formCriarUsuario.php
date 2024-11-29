<?php

session_start();

if (isset($_POST['botao'])) {
    require_once __DIR__ . "/vendor/autoload.php";

    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $senha = trim($_POST['senha']);

    if (!$email) {
        $_SESSION['erro'] = "E-mail inválido! Tente novamente!";
        header("Location: formCriarUsuario.php");
        exit;
    }

    if (!preg_match('/@aluno\.feliz\.ifrs\.edu\.br$/', $email)) {
        $_SESSION['erro'] = "O e-mail deve ser institucional com o domínio @aluno.feliz.ifrs.edu.br";
        header("Location: formCriarUsuario.php");
        exit;
    }

    $usuarioExistente = Usuario::findByEmail($email);
    if ($usuarioExistente) {
        $_SESSION['erro'] = "Já existe uma conta cadastrada com esse e-mail. Tente usar outro.";
        header("Location: formCriarUsuario.php");
        exit;
    }

    $password_hash = password_hash($senha, PASSWORD_DEFAULT);

    $usuario = new Usuario($email, $password_hash);

    $usuario->save();

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuário</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body class="body-login">
    <!-- Formulário de Cadastro com a classe 'create-account-form' -->
    <form action="formCriarUsuario.php" method="POST" class="create-account-form">
        <h1>Criar Conta</h1>
        
        <label for="email">Email:</label>
        <input name="email" type="email" placeholder="Insira seu email institucional" required>
        
        <label for="senha">Senha:</label>
        <input name="senha" type="password" placeholder="Crie uma senha" required>
        
        <input type="submit" name="botao" value="Criar conta">
        
        <p>Já tem uma conta? <a href="login.php">Fazer login</a></p>
        <p><a href="index.php">Voltar</a></p>
    </form>

    <?php
        // Verifica se existe uma mensagem de erro na sessão
        if (isset($_SESSION['erro'])) {
            echo "<script>window.onload = function() { exibirPopupErro('" . $_SESSION['erro'] . "'); }</script>";
            unset($_SESSION['erro']); // Limpa a variável de sessão após exibir a mensagem
        }
    ?>

    <div id="error-popup" class="popup-overlay-2">
        <div class="popup-content-2">
            <h2>Erro</h2>
            <p id="error-message"></p>
            <button class="btn-close" onclick="fecharPopup()">Fechar</button>
        </div>
    </div>

</body>
</html>
