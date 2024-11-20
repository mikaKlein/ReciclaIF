<?php
require_once __DIR__."/vendor/autoload.php";
$residuo = Residuo::find($_GET['idResiduo']);
$caminho = $residuo->getCaminhoImagem();

echo $caminho;

if(file_exists($caminho)){
    echo "existe";
    unlink($caminho);
}

$residuo->delete();
header("location:index.php");
?>