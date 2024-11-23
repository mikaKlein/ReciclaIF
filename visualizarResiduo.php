<?php
if(isset($_GET['idResiduo'])){
    require_once __DIR__."/vendor/autoload.php";
    $residuo = Residuo::find($_GET['idResiduo']);
    $nome = $residuo->getNome();
    $descricao = $residuo->getDescricao();
    $imagem = $residuo->getCaminhoImagem();
    $coletorId = $residuo->getIdColetor();

    $coletor = Coletor::find($coletorId);
    $coletorImagem = $coletor->getCaminhoImagem();
} else {
    $nome = '';
    $descricao = '';
    $imagem = '';
    $coletorId = '';
    $coletorImagem = '';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Resíduo</title>
    <link rel="stylesheet" href="style.css"> <!-- Referência ao arquivo de estilo externo -->
</head>
<body>
    <header>
        <div class="logo">Recicla IF</div>
        <div class="usuario">
            <span>Conteudista</span>
        </div>
    </header>
    <main>
        <div class="visualizar-container">
            <h2>Visualizar Resíduo</h2>

            <div class="residuo-info">
                <img src="<?php echo $imagem; ?>" alt="Imagem do resíduo">
                <div>
                    <h3><?php echo htmlspecialchars($nome); ?></h3>
                    <p><strong>Descrição:</strong> <?php echo htmlspecialchars($descricao); ?></p>
                </div>
            </div>

            <div class="coletor-info">
                <img src="<?php echo $coletorImagem; ?>" alt="Imagem do coletor">
                <div>
                    <p><strong>Coletor: </strong><?php echo $coletor->getNome(); ?></p>
                </div>
            </div>

            <div class="button-container">
                <a href="editarResiduo.php?idResiduo=<?php echo $_GET['idResiduo']; ?>" class="btn-editar">Editar</a>
                <a href="deletarResiduo.php?idResiduo=<?php echo $_GET['idResiduo']; ?>" class="btn-excluir" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                <a href="index.php" class="btn-voltar">Voltar à Listagem</a>
                <a href="cadastrarResiduo.php" class="btn-novo">Cadastrar Novo Resíduo</a>
            </div>
        </div>
    </main>
</body>
</html>