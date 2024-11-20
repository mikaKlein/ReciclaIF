<?php

class Residuo implements ActiveRecord{

    private int $idResiduo;
    
    public function __construct(private string $nome, private string $descricao, private string $caminho_imagem, private int $id_coletor){
    }

    public function setIdResiduo(int $idResiduo):void{
        $this->idResiduo = $idResiduo;
    }

    public function getIdResiduo():int{
        return $this->idResiduo;
    }

    public function setNome(string $nome):void{
        $this->nome = $nome;
    }

    public function getNome():string{
        return $this->nome;
    }

    public function setDescricao(string $descricao):void{
        $this->descricao = $descricao;
    }

    public function getDescricao():string{  
        return $this->descricao;
    }

    public function setIdColetor(int $idColetor):void{
        $this->id_coletor = $idColetor;
    }

    public function getIdColetor():string{
        return $this->id_coletor;
    }

    public function setCaminhoImagem(string $caminho_imagem):void{
        $this->caminho_imagem = $caminho_imagem;
    }

    public function getCaminhoImagem():string{
        return $this->caminho_imagem;
    }

    public function save():bool{
        $conexao = new MySQL();
        if(isset($this->idResiduo)){
            $sql = "UPDATE residuo SET nome = '{$this->nome}', descricao = '{$this->descricao}', imagem_residuo = '{$this->caminho_imagem}', coletor_descarte = '{$this->id_coletor}' WHERE id = {$this->idResiduo}";
        }else{
            $sql = "INSERT INTO residuo (nome, descricao, imagem_residuo, coletor_descarte) VALUES ('{$this->nome}','{$this->descricao}','{$this->caminho_imagem}','{$this->id_coletor}')";
        }
        return $conexao->executa($sql);
        
    }
    public function delete():bool{
        $conexao = new MySQL();
        $sql = "DELETE FROM residuo WHERE id = {$this->idResiduo}";
        return $conexao->executa($sql);
    }

    public static function find($idResiduo):Residuo{
        $conexao = new MySQL();
        $sql = "SELECT * FROM residuo WHERE id = {$idResiduo}";
        $resultado = $conexao->consulta($sql);
        $r = new Residuo($resultado[0]['nome'], $resultado[0]['descricao'], $resultado[0]['imagem_residuo'], $resultado[0]['coletor_descarte']);
        $r->setidResiduo($resultado[0]['id']);
        return $r;
    }
    public static function findall():array{
        $conexao = new MySQL();
        $sql = "SELECT * FROM residuo";
        $resultados = $conexao->consulta($sql);
        $residuos = array();
        foreach($resultados as $resultado){
            $r = new Residuo($resultado['nome'], $resultado['descricao'], $resultado['imagem_residuo'], $resultado['coletor_descarte']);
            $r->setidResiduo($resultado['id']);
            $residuos[] = $r;
        }
        return $residuos;
    }
}