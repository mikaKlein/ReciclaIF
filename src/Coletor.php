<?php

class Coletor implements ActiveRecord{

    private int $idColetor;
    
    public function __construct(private string $nome, private string $caminho_imagem){
    }

    public function setidColetor(int $idColetor):void{
        $this->idColetor = $idColetor;
    }

    public function getidColetor():int{
        return $this->idColetor;
    }

    public function setNome(string $nome):void{
        $this->nome = $nome;
    }

    public function getNome():string{
        return $this->nome;
    }

    public function setCaminhoImagem(string $caminho_imagem):void{
        $this->caminho_imagem = $caminho_imagem;
    }

    public function getCaminhoImagem():string{
        return $this->caminho_imagem;
    }

    public function save():bool{
        $conexao = new MySQL();
        if(isset($this->idColetor)){
            $sql = "UPDATE coletor SET nome = '{$this->nome}', icone = '{$this->caminho_imagem}' WHERE id = {$this->idColetor}";
        }else{
            $sql = "INSERT INTO coletor (nome, icone) VALUES ('{$this->nome}', '{$this->caminho_imagem}')";
        }
        return $conexao->executa($sql);
        
    }
    public function delete():bool{
        $conexao = new MySQL();
        $sql = "DELETE FROM coletor WHERE id = {$this->idColetor}";
        return $conexao->executa($sql);
    }

    public static function find($idColetor):Coletor{
        $conexao = new MySQL();
        $sql = "SELECT * FROM coletor WHERE id = {$idColetor}";
        $resultado = $conexao->consulta($sql);
        $c = new Coletor($resultado[0]['nome'], $resultado[0]['icone']);
        $c->setidColetor($resultado[0]['id']);
        return $c;
    }
    public static function findall():array{
        $conexao = new MySQL();
        $sql = "SELECT * FROM coletor";
        $resultados = $conexao->consulta($sql);
        $coletores = array();
        foreach($resultados as $resultado){
            $c = new Coletor($resultado['nome'], $resultado['icone']);
            $c->setidColetor($resultado['id']);
            $coletores[] = $c;
        }
        return $coletores;
    }
}