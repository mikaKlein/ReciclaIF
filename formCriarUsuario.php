<?php
if (isset($_POST['botao'])) {
    require_once __DIR__ . "/vendor/autoload.php";

    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $senha = trim($_POST['senha']);

    if (!$email) {
        die("E-mail inválido! Tente novamente!");
    }

    if (!preg_match('/@aluno\.feliz\.ifrs\.edu\.br$/', $email)) {
        die("O e-mail deve ser institucional com o domínio @aluno.feliz.ifrs.edu.br");
    }

    $usuarioExistente = Usuario::findByEmail($email);
    if ($usuarioExistente) {
        die("Já existe uma conta cadastrada com esse e-mail. Tente usar outro.");
    }

    $password_hash = password_hash($senha, PASSWORD_DEFAULT);

    $usuario = new Usuario($email, $password_hash);

    $usuario->save();

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuario</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="formCriarUsuario.php" method="POST" >
        Email: <input name="email" type="email" placeholder="Insira seu email institucional" required>
        <br>
        Senha: <input name="senha" type="password" placeholder="Crie uma senha"  required >
        <br>
        <input type="submit" name="botao" value="Criar conta">
        <br>
        Já tem uma conta? <a href='login.php'>Fazer login</a>
        <a href="index.php">Entrar como visitante</a>
    </form>
</body>
</html>