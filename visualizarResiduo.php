<?php
if (isset($_GET['idResiduo'])) {
    require_once __DIR__ . "/vendor/autoload.php";

    session_start();
    if(isset($_SESSION['id'])){
        $usuario_id = $_SESSION['id'];
        $usuario = Usuario::find($usuario_id);
    }

    $residuo = Residuo::find($_GET['idResiduo']);
    $nome = $residuo->getNome();
    $descricao = $residuo->getDescricao();
    $imagem = $residuo->getCaminhoImagem();
    $coletorId = $residuo->getIdColetor();

    $coletor = Coletor::find($coletorId);
    $coletorNome = $coletor->getNome();
    $coletorImagem = $coletor->getCaminhoImagem();
    $corColetor = $coletor->getCor();

    $coresPastel = [
        "Amarelo" => "#FFF9C4", // Metal
        "Cinza" => "#CFD8DC",   // Não reciclável
        "Marrom" => "#D7CCC8",  // Orgânico
        "Branco" => "#F5F5F5",  // Outros
        "Azul" => "#BBDEFB",    // Papel
        "Vermelho" => "#FFCDD2",// Plástico
        "Verde" => "#C8E6C9"    // Vidro
    ];

    $corDeFundo = isset($coresPastel[$corColetor]) ? $coresPastel[$corColetor] : "#FFFFFF";
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
            <span>
                <?php 
                    if(isset($usuario_id)){
                        echo "Olá, " . htmlspecialchars($usuario->getEmailInstitucional());
                        echo '<a href="logout.php">Sair</a>';
                    } else {
                        echo '<a class="btn-entrar" href="login.php">Entrar</a>';
                    } 
                ?>
            </span>
            
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
            <div class="residuo-view-info">
                <h1><?php echo htmlspecialchars($nome); ?></h1>
                <p><?php echo htmlspecialchars($descricao); ?></p>
                <p>
                    <strong>Tipo de coletor:</strong> 
                    <?php echo htmlspecialchars($coletorNome); ?>
                </p>
                <div class="imagem-view">
                    <img src="<?php echo htmlspecialchars($coletorImagem); ?>" alt="Ícone do coletor" class="coletor-icone">
                </div>
            </div>

            <!-- Botões de Ação -->
            <div class="residuo-view-buttons">
                <?php if (isset($_SESSION['id'])): // Verifica se o usuário está logado ?>
                    <a href="editarResiduo.php?idResiduo=<?php echo $_GET['idResiduo']; ?>" class="btn-editar">Editar</a>
                    <button class="btn-excluir" onclick="openPopup(<?php echo $residuo->getIdResiduo(); ?>)">Excluir</button>
                <?php endif; ?>
                <a href="index.php" class="btn-voltar">Voltar à Listagem</a>
            </div>
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