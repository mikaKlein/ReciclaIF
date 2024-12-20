<?php
if(isset($_GET['idResiduo'])){
    require_once __DIR__."/vendor/autoload.php";
    $residuo = Residuo::find($_GET['idResiduo']);
    $nome = $residuo->getNome();
    $descricao = $residuo->getDescricao();
    $imagem = $residuo->getCaminhoImagem();
    $coletorId = $residuo->getIdColetor();

    $coletores = Coletor::findall();

} else {
    $nome = '';
    $descricao = '';
    $imagem = '';
    $coletorId = '';
}

if(isset($_POST['botao'])){

    require_once __DIR__."/vendor/autoload.php";
    $residuo = Residuo::find($_GET['idResiduo']);

    if (!empty($_FILES['imagem']['name']) && $residuo->getCaminhoImagem() && file_exists($residuo->getCaminhoImagem())) {
        unlink($residuo->getCaminhoImagem());

        $imagem = $_FILES['imagem'];
        $pasta_imagens = "imagensResiduos";

        $tipos_permitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $tipo_arquivo = mime_content_type($imagem['tmp_name']);
    
        if (!in_array($tipo_arquivo, $tipos_permitidos)) {
            echo "<script>
                    alert('Formato de imagem inválido!');
                    window.location.href = 'index.php';
                </script>";
            exit;
        }

        if (!is_dir($pasta_imagens)) {
            mkdir($pasta_imagens, 0777, true);
        }

        $nome_imagem = $imagem['name'];

        $nome_unico_imagem = uniqid() . "_" . basename($nome_imagem);
        $caminho_imagem = $pasta_imagens . "/" . $nome_unico_imagem;

        if (move_uploaded_file($imagem['tmp_name'], $caminho_imagem)) {
            echo "Imagem salva com sucesso!";
        } else {
            echo "Erro ao salvar a imagem.";
        }
        
    } else {
        $caminho_imagem = $residuo->getCaminhoImagem();
    }

    $residuo = new Residuo($_POST['nome'], $_POST['descricao'], $caminho_imagem, $_POST['coletor']);
    $residuo->setIdResiduo($_GET['idResiduo']); 
    $residuo->save();
    header("location: index.php");
}

session_start();
if(isset($_SESSION['id'])){
    $usuario_id = $_SESSION['id'];
    $usuario = Usuario::find($usuario_id);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Residuo</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="logo">Recicla IF</div>
        <div class="usuario">
            <span>
                <?php 
                    if(isset($usuario_id)){
                        $name = explode("@",$usuario->getEmailInstitucional())[0];
                        echo "Olá, " . htmlspecialchars($name);
                        echo '<a href="logout.php">Sair</a>';
                    } else {
                        echo '<a class="btn-entrar" href="login.php">Entrar</a>';
                    } 
                ?>
            </span>
            
        </div>
    </header>
    <main>
        <h2>Editar Residuo</h2>
        <form action="editarResiduo.php?idResiduo=<?php echo $_GET['idResiduo']; ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="imagem">Adicionar Imagem</label>
                <input type="file" id="imagem" name="imagem" accept="image/*">
                <?php if ($imagem): ?>
                    <div class="imagem-container">
                        <p>Imagem atual:</p>
                        <img src="<?php echo $imagem; ?>" alt="Imagem do resíduo" width="100">
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" maxlength="30" id="nome" name="nome" value="<?php echo htmlspecialchars($nome); ?>" required>
            </div>

            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" required><?php echo htmlspecialchars($descricao); ?></textarea>
            </div>

            <div class="form-group">
                <label for="coletor">Tipo de coletor:</label>
                <select id="coletor" name="coletor" required>
                    <option value="">Selecionar tipo de coletor</option>
                    <?php foreach ($coletores as $coletor): ?>
                        <option value="<?php echo $coletor->getIdColetor(); ?>" <?php echo ($coletor->getIdColetor() == $coletorId) ? 'selected' : ''; ?>>
                            <?php echo $coletor->getNome(); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button name="botao" type="submit" class="submit-btn">Editar</button>
        </form>
        <br>
        <a href="index.php" class="btn-voltar">Voltar à Listagem</a>
    </main>
</body>
</html>