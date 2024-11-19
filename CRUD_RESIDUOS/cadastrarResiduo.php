<?php
// Conexão com o banco de dados
$host = 'localhost';
$dbname = 'recicla_if';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}

// Busca os coletores do banco de dados
$coletores = [];
try {
    $stmt = $conn->query("SELECT id, nome FROM coletor");
    $coletores = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao buscar coletores: " . $e->getMessage();
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $tipo = $_POST['tipo'];
    $imagem = null;

    // Verifica se uma imagem foi enviada
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == UPLOAD_ERR_OK) {
        $diretorioUpload = 'uploads/';
        if (!is_dir($diretorioUpload)) {
            mkdir($diretorioUpload, 0755, true);
        }
        $nomeImagem = time() . '_' . basename($_FILES['imagem']['name']);
        $caminhoImagem = $diretorioUpload . $nomeImagem;

        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoImagem)) {
            $imagem = $caminhoImagem;
        } else {
            echo "Erro ao salvar a imagem.";
        }
    }

    // Insere os dados no banco de dados
    $sql = "INSERT INTO residuo (nome, descricao, coletor_descarte, imagem_residuo) VALUES (:nome, :descricao, :tipo, :imagem)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':tipo', $tipo);
    $stmt->bindParam(':imagem', $imagem);

    if ($stmt->execute()) {
        echo "Resíduo cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar o resíduo.";
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Resíduo</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <header>
        <div class="logo">Recicla</div>
        <div class="usuario">
            <span>Conteudista</span>
        </div>
    </header>
    <main>
        <div class="form-container">
            <h1>Cadastrar resíduo</h1>
            <form action="#" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="imagem">Adicionar Imagem</label>
                    <input type="file" id="imagem" name="imagem" accept="image/*">
                </div>

                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" required>
                </div>

                <div class="form-group">
                    <label for="descricao">Descrição:</label>
                    <textarea id="descricao" name="descricao" required></textarea>
                </div>

                <div class="form-group">

                    <!--FAZER AS OPÇÕES DE COLETOR VIRAREM AS PRÉ-DETERMINADAS DO BANCO DE DADOS-->
                    <label for="tipo">Tipo:</label>
                    <select id="tipo" name="tipo" required>
                        <option value="">Selecionar tipo de coletor</option>
                        <?php foreach ($coletores as $coletor): ?>
                            <option value="<?= $coletor['id'] ?>"><?= htmlspecialchars($coletor['nome']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="submit-btn">Cadastrar</button>
            </form>
        </div>
    </main>
</body>
</html>