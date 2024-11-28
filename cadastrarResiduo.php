<?php

require_once __DIR__."/vendor/autoload.php";

if(isset($_POST['botao'])){

    $imagem = $_FILES['imagem'];
    $pasta_imagens = "imagensResiduos";

    $tipos_permitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $tipo_arquivo = mime_content_type($imagem['tmp_name']);

    if (!in_array($tipo_arquivo, $tipos_permitidos)) {
       exit('Tipo de arquivo não permitido');
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

    $residuo = new Residuo($_POST['nome'], $_POST['descricao'], $caminho_imagem, $_POST['coletor']);
    $residuo->save();
    header("location: index.php");
}

$coletores = Coletor::findall();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Residuo</title>
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
        <h2>Cadastrar Resíduo</h2>
        <form action="cadastrarResiduo.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="imagem">Adicionar Imagem</label>
                <input type="file" id="imagem" name="imagem" accept="image/*" required>
            </div>

            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" maxlength="25" required>
            </div>

            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" maxlength="80" required></textarea>
            </div>

            <div class="form-group">
                <label for="coletor">Tipo de coletor:</label>
                <select id="coletor" name="coletor" required>
                    <option value="">Selecionar tipo de coletor</option>
                    <?php foreach ($coletores as $coletor): ?>
                        <option value="<?php echo $coletor->getidColetor(); ?>"><?php echo $coletor->getNome(); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button name="botao" type="submit" class="submit-btn">Cadastrar</button>
        </form>
        <br>
        <a href="index.php" class="btn-voltar">Voltar à Listagem</a>
    </main>
</body>
</html>