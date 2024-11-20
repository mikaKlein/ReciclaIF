<?php
require_once __DIR__."/vendor/autoload.php";
$residuo = Residuo::find($_GET['idResiduo']);
$residuo->delete();
header("location:index.php");
?>