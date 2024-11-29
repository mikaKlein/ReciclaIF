<?php

class Coletor implements ActiveRecord{

    private int $idColetor;
    
    public function __construct(private string $nome, private string $caminho_imagem, private string $cor){
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

    public function setCor(string $cor):void{
        $this->cor = $cor;
    }

    public function getCor():string{
        return $this->cor;
    }

    public function save():bool{
        $conexao = new MySQL();
        if(isset($this->idColetor)){
            $sql = "UPDATE coletor SET nome = '{$this->nome}', icone = '{$this->caminho_imagem}', cor = '{$this->cor}' WHERE id = {$this->idColetor}";
        }else{
            $sql = "INSERT INTO coletor (nome, icone, cor) VALUES ('{$this->nome}', '{$this->caminho_imagem}', '{$this->cor}')";
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
        $c = new Coletor($resultado[0]['nome'], $resultado[0]['icone'], $resultado[0]['cor']);
        $c->setidColetor($resultado[0]['id']);
        return $c;
    }
    public static function findAll():array{
        $conexao = new MySQL();
        $sql = "SELECT * FROM coletor";
        $resultados = $conexao->consulta($sql);
        $coletores = array();
        foreach($resultados as $resultado){
            $c = new Coletor($resultado['nome'], $resultado['icone'], $resultado['cor']);
            $c->setidColetor($resultado['id']);
            $coletores[] = $c;
        }
        return $coletores;
    }

    
}