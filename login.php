<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Login</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body class="body-login">
    <!-- Formulário de Login com a classe 'login-form' -->
    <form action="validacaoLogin.php" method="POST" class="login-form">
        <h1>Login</h1>
        
        <label for="email">Email do Usuário:</label>
        <input name="email" type="text" placeholder="Insira seu email institucional" required>
        
        <label for="senha">Senha:</label>
        <input name="senha" type="password" placeholder="Insira sua senha" required>
        
        <input type="submit" name="botao" value="Entrar">
        
        <p>Não tem uma conta? <a href="formCriarUsuario.php">Criar Conta</a></p>
        <p><a href="index.php">Voltar</a></p>
    </form>

    <div id="error-popup" class="popup-overlay-2">
        <div class="popup-content-2">
            <h2>Erro</h2>
            <p id="error-message"></p>
            <button class="btn-close" onclick="fecharPopup()">Fechar</button>
        </div>
    </div>

    <?php
        session_start();
        if (isset($_SESSION['erro'])) {
            echo "<script>window.onload = function() { exibirPopupErro('" . $_SESSION['erro'] . "'); }</script>";
            unset($_SESSION['erro']); // Limpa a variável de sessão após exibir a mensagem
        }
    ?>

</body>
</html>