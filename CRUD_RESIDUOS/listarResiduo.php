<?php
// Conectar ao banco de dados
$conn = new mysqli("localhost", "root", "", "recicla_if");

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Consultar resíduos
$sql = "SELECT nome, categoria, descricao FROM residuos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de Resíduos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="logo">Recicla</div>
        <div class="usuario">Bem-vindo, Usuário</div>
    </header>

    <main>
        <div class="form-container">
            <h1>Listagem de Resíduos Cadastrados</h1>

            <?php
            // Exibir dados dos resíduos
            if ($result->num_rows > 0) {
                echo "<table>";
                echo "<tr><th>Nome</th><th>Categoria</th><th>Descrição</th></tr>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["nome"] . "</td>";
                    echo "<td>" . $row["categoria"] . "</td>";
                    echo "<td>" . $row["descricao"] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>Nenhum resíduo encontrado.</p>";
            }

            $conn->close();
            ?>

        </div>
    </main>
</body>
</html>
