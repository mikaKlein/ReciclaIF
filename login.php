<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="validacaoLogin.php" method="POST">
        Email do Usuário: <input name="email" type="text" placeholder="Insira seu email institucional" required>
        <br>
        Senha: <input name="senha" type="password" placeholder="Insira sua senha" required>
        <br>
        <input type="submit" name="botao" value="Entrar">
        <br>
        Não tem uma conta? <a href="formCriarUsuario.php">Criar Conta</a>
        <a href="index.php">Entrar como visitante</a>
    </form>
</body>
</html>