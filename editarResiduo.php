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
            <span>Conteudista</span>
        </div>
    </header>
    <main>
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
    </main>
</body>
</html>