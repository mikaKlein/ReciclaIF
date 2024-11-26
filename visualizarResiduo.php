<?php
if (isset($_GET['idResiduo'])) {
    require_once __DIR__ . "/vendor/autoload.php";
    $residuo = Residuo::find($_GET['idResiduo']);
    $nome = $residuo->getNome();
    $descricao = $residuo->getDescricao();
    $imagem = $residuo->getCaminhoImagem();
    $coletorId = $residuo->getIdColetor();

    $coletor = Coletor::find($coletorId);
    $coletorNome = $coletor->getNome();
    $coletorImagem = $coletor->getCaminhoImagem();
    $corColetor = $coletor->getCor();

    // Mapeamento de cores do coletor para tons pastel
    $coresPastel = [
        "Amarelo" => "#FFF9C4", // Metal
        "Cinza" => "#CFD8DC",   // Não reciclável
        "Marrom" => "#D7CCC8",  // Orgânico
        "Branco" => "#F5F5F5",  // Outros
        "Azul" => "#BBDEFB",    // Papel
        "Vermelho" => "#FFCDD2",// Plástico
        "Verde" => "#C8E6C9"    // Vidro
    ];

    // Definindo a cor de fundo
    $corDeFundo = isset($coresPastel[$corColetor]) ? $coresPastel[$corColetor] : "#FFFFFF"; // Branco por padrão
} else {
    exit("Resíduo não encontrado.");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Resíduo</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body>
    <header>
        <div class="logo">Recicla IF</div>
        <div class="usuario">
            <span>Conteudista</span>
        </div>
    </header>
    <main>
        <!-- Container do Resíduo -->
        <div class="residuo-container" style="background-color: <?php echo htmlspecialchars($corDeFundo); ?>;">
            <!-- Imagem Grande do Resíduo -->
            <div class="residuo-imagem">
                <img src="<?php echo htmlspecialchars($imagem); ?>" alt="Imagem do resíduo">
            </div>

            <!-- Informações do Resíduo -->
            <div class="residuo-info">
                <h1><?php echo htmlspecialchars($nome); ?></h1>
                <p><?php echo htmlspecialchars($descricao); ?></p>
                <p>
                    <strong>Tipo de coletor:</strong> 
                    <?php echo htmlspecialchars($coletorNome); ?>
                    <img src="<?php echo htmlspecialchars($coletorImagem); ?>" alt="Ícone do coletor" class="coletor-icone">
                </p>
            </div>
        </div>

        <!-- Botões de Ação -->
        <div class="residuo-buttons">
            <a href="editarResiduo.php?idResiduo=<?php echo $_GET['idResiduo']; ?>" class="btn-editar">Editar</a>
            <button class="btn-excluir" onclick="openPopup(<?php echo $residuo->getIdResiduo(); ?>)">Excluir</button>
            <a href="index.php" class="btn-voltar">Voltar à Listagem</a>
        </div>

        <!-- Popup de Confirmação -->
        <div id="popup-delete" class="popup-overlay" style="display: none;">
            <div class="popup-content">
                <h2>Confirmação de Exclusão</h2>
                <p>Tem certeza de que deseja excluir este resíduo?</p>
                <div class="popup-buttons">
                    <a id="confirm-delete" href="#" class="btn-confirm">Sim, excluir</a>
                    <button class="btn-cancel" onclick="closePopup()">Cancelar</button>
                </div>
            </div>
        </div>
    </main>
</body>
</html>