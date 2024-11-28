<?php
require_once __DIR__."/vendor/autoload.php";
session_start();
if(isset($_SESSION['id'])){
    $usuario_id = $_SESSION['id'];
    $usuario = Usuario::find($usuario_id);
}

$residuos = Residuo::findall();
$coresPastel = [
    "Amarelo" => "#FFF9C4",
    "Cinza" => "#CFD8DC",
    "Marrom" => "#D7CCC8",
    "Branco" => "#F5F5F5",
    "Azul" => "#BBDEFB",
    "Vermelho" => "#FFCDD2",
    "Verde" => "#C8E6C9"
];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resíduos Cadastrados</title>
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
                        echo "Vendo como visitante";
                        echo '<a class="btn-entrar" href="login.php">Entrar</a>';
                    } 
                ?>
            </span>
            
        </div>
    </header>
    <main>
        <?php if (isset($usuario_id)): ?>
            <a href='cadastrarResiduo.php' class='btn-add'>
            <button class="btn-add-residuo">
                <span class="btn-add-text">+</span> Adicionar Resíduo
            </button>
            </a>
        <?php endif; ?>
        <div class="residuos-container">
            <?php foreach ($residuos as $residuo): ?>
                <?php
                $coletor = Coletor::find($residuo->getIdColetor());
                $corFundo = isset($coresPastel[$coletor->getCor()]) ? $coresPastel[$coletor->getCor()] : "#FFFFFF";
                ?>
                <div class="residuo-card" style="background-color: <?php echo $corFundo; ?>;">
                    <a href="visualizarResiduo.php?idResiduo=<?php echo $residuo->getIdResiduo(); ?>" class="card-link">
                        <div class="residuo-content">
                            <img src="<?php echo $residuo->getCaminhoImagem(); ?>" alt="Imagem do Resíduo" class="residuo-imagem">
                            <div class="residuo-info">
                                <h1 class="residuo-nome"><?php echo htmlspecialchars($residuo->getNome()); ?></h1>
                                <div class="residuo-coletor">
                                    <label class="label-residuo" for="">Tipo de coletor: <?php echo htmlspecialchars($coletor->getNome()); ?></label>                                                                     
                                </div>
                                <img src="<?php echo $coletor->getCaminhoImagem(); ?>" alt="Ícone do Coletor" class="coletor-icone">
                            </div>
                        </div>
                    </a>
                    <div class="card-actions">
                        <?php if (isset($usuario_id)): ?>
                            <a href="editarResiduo.php?idResiduo=<?php echo $residuo->getIdResiduo(); ?>" class="btn-editar">Editar</a>
                            <button class="btn-excluir" onclick="openPopup(<?php echo $residuo->getIdResiduo(); ?>)">Excluir</button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
    
    <div id="popup-delete" class="popup-overlay" style="display: none;">
        <div class="popup-content">
            <h2>Confirmação de Exclusão</h2>
            <p>Tem certeza de que deseja excluir este resíduo?</p>
            <div class="popup-buttons">
                <a id="confirm-delete" href="" class="btn-confirm">Sim, excluir</a>
                <button class="btn-cancel" onclick="closePopup()">Cancelar</button>
            </div>
        </div>
    </div>
</body>
</html>