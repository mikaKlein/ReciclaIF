<?php
require_once __DIR__."/vendor/autoload.php";
$residuos = Residuo::findall();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Resíduo</title>
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
        <a href='cadastrarResiduo.php' class='btn-add'>
            <button class="btn-add-residuo">
                <span class="btn-add-text">+</span> Adicionar Resíduo
            </button>
        </a>
        <div class="form-container">
            <h1>Resíduos Cadastrados</h1>
            <table>
                <tr>
                    <td>Nome</td>
                    <td>Imagem</td>
                    <td>Coletor</td>
                    <td>Opções</td>
                </tr>
                <?php
                foreach($residuos as $residuo){
                    echo "<tr>";
                    echo "<td>{$residuo->getNome()}</td>";
                    echo "<td><img src='{$residuo->getCaminhoImagem()}' width='50px'></td>";

                    $coletor_id = $residuo->getIdColetor();
                    $coletor = Coletor::find($coletor_id);
                    $caminho_imagem = $coletor->getCaminhoImagem();
                    
                    echo "<td><img src='{$caminho_imagem}' width='50px'></td>";
                    echo "<td>
                            <a href='visualizarResiduo.php?idResiduo={$residuo->getIdResiduo()}' class='btn-visualizar'>Visualizar</a>
                            <a href='editarResiduo.php?idResiduo={$residuo->getIdResiduo()}' class='btn-editar'>Editar</a>
                            <button class='btn-excluir' onclick='openPopup({$residuo->getIdResiduo()})'>Excluir</button>
                        </td>";
                    echo "</tr>";
                }
                ?>
            </table>
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