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
</head>
<body>
    <header>
        <div class="logo">Recicla IF</div>
        <div class="usuario">
            <span>Conteudista</span>
        </div>
    </header>
    <main>
        <div class="form-container">
            <h1>Resíduos Cadastrados</h1>
            <table>
                <tr>
                    <td>Nome</td>
                    <td>Coletor</td>
                    <td>Opções</td>
                </tr>
                <?php
                foreach($residuos as $residuo){
                    echo "<tr>";
                    echo "<td>{$residuo->getNome()}</td>";
                    
                    $coletor_id = $residuo->getIdColetor();
                    $coletor = Coletor::find($coletor_id);
                    $caminho_imagem = $coletor->getCaminhoImagem();

                    echo "<td><img src='{$caminho_imagem}' width='50px'></td>";
                    echo "<td>
                            <a href='editarResiduo.php?idResiduo={$residuo->getIdResiduo()}'>Editar</a>
                            <a href='deletarResiduo.php?idResiduo={$residuo->getIdResiduo()}'>Excluir</a>
                        </td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
        <a href='cadastrarResiduo.php'>Adicionar Residuo</a>
    </main>
</body>
</html>