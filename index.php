<?php
require_once __DIR__ . "/vendor/autoload.php";
session_start();

// Verifica se o usuário está logado
if (isset($_SESSION['id'])) {
    $usuario_id = $_SESSION['id'];
    $usuario = Usuario::find($usuario_id);
}

// Inicializa os resíduos
$residuos = Residuo::findAll();

// Pegando os parâmetros de filtro da URL
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
$coletorFilter = isset($_GET['coletor']) ? $_GET['coletor'] : '';

// Se houver pesquisa por nome de resíduo, filtramos os resíduos
if ($searchTerm) {
    $residuos = Residuo::findByName($searchTerm);
}

// Se houver filtro por tipo de coletor, filtramos os resíduos pelo tipo de coletor
if ($coletorFilter) {
    $residuos = Residuo::findByColetor($coletorFilter);
}
// Filtrando simultaneamente por nome de resíduo e tipo de coletor
if ($searchTerm && $coletorFilter) {
    $residuos = Residuo::findByNameAndColetor($searchTerm, $coletorFilter);
}

// Cores de fundo para os coletores
$coresPastel = [
    "Amarelo" => "#FFF9C4",
    "Cinza" => "#CFD8DC",
    "Marrom" => "#D7CCC8",
    "Branco" => "#F5F5F5",
    "Azul" => "#BBDEFB",
    "Vermelho" => "#FFCDD2",
    "Verde" => "#C8E6C9"
];
$coletores = Coletor::findAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resíduos Cadastrados</title>
    <link rel="stylesheet" href="style.css">
    <script defer src="script.js"></script>
</head>
<body>
    <header>
        <div class="logo">Recicla IF</div>
        <div class="usuario">
            <span>
                <?php 
                    if (isset($usuario_id)) {
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
        <div class="filter-search">
            <form class="filter-search-form" method="GET" action="">
                <input type="text" class="search-bar" placeholder="Pesquisar resíduo" name="search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">

                <select name="coletor" class="coletor-filter">
                    <option value="">Filtrar por tipo de coletor</option>
                    <?php foreach ($coletores as $coletor): ?>
                        <option value="<?php echo $coletor->getidColetor(); ?>"
                            <?php echo (isset($_GET['coletor']) && $_GET['coletor'] == $coletor->getidColetor()) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($coletor->getNome()); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <button class="btn-search" type="submit">Filtrar</button>
            </form>

            <?php if (isset($usuario_id)): ?>
                <a href='cadastrarResiduo.php' class='btn-add'>
                <button class="btn-add-residuo">
                    <span class="btn-add-text">+</span> Adicionar Resíduo
                </button>
                </a>
            <?php endif; ?>

        </div>
        <div class="residuos-container">
            <?php foreach ($residuos as $residuo): ?>
                <?php
                $coletor = Coletor::find($residuo->getIdColetor());
                $corFundo = isset($coresPastel[$coletor->getCor()]) ? $coresPastel[$coletor->getCor()] : "#FFFFFF";
                ?>
                <div class="residuo-card" style="background-color: <?php echo $corFundo; ?>;">
                    <a href="visualizarResiduo.php?idResiduo=<?php echo $residuo->getIdResiduo(); ?>" class="card-link">
                        <div class="residuo-content">
                            <img src="<?php echo $residuo->getCaminhoImagem(); ?>" alt="Imagem do Resíduo" class="residuo-imagem-listagem">
                            <div class="residuo-info">
                                <h1 class="residuo-nome"><?php echo htmlspecialchars($residuo->getNome()); ?></h1>
                                <div class="residuo-coletor">
                                    <label class="label-residuo" for="">Tipo de coletor: <?php echo htmlspecialchars($coletor->getNome()); ?></label>                                                                     
                                </div>
                                <img src="<?php echo $coletor->getCaminhoImagem(); ?>" alt="Ícone do Coletor" class="coletor-icone">
                            </div>
                        </div>
                    </a>
                    <?php if (isset($usuario_id)): ?>
                        <div class="card-actions">           
                            <a href="editarResiduo.php?idResiduo=<?php echo $residuo->getIdResiduo(); ?>" class="btn-editar">Editar</a>
                            <button class="btn-excluir" onclick="openPopup(<?php echo $residuo->getIdResiduo(); ?>)">Excluir</button>   
                        </div>
                    <?php endif; ?>
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
