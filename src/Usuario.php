<?php
include_once 'ActiveRecord.php'; 
include_once 'MySQL.php'; 

class Usuario implements ActiveRecord {

    private int $idUser;

    public function __construct(private string $emailInstitucional, private string $senha) {
    }

    public function setIdUser(int $idUser): void {
        $this->idUser = $idUser;
    }

    public function getIdUser(): int {
        return $this->idUser;
    }

    public function setEmailInstitucional(string $emailInstitucional): void {
        $this->emailInstitucional = $emailInstitucional;
    }

    public function getEmailInstitucional(): string {
        return $this->emailInstitucional;
    }

    public function setSenha(string $senha): void {
        $this->senha = $senha;
    }

    public function getSenha(): string {
        return $this->senha;
    }

    public function save(): bool {
        $conexao = new MySQL();
        if (isset($this->idUser)) {
            $this->senha = password_hash($this->senha);
            $sql = "UPDATE usuario SET email = '{$this->emailInstitucional}', senha = '{$this->senha}' WHERE id = {$this->idUser}";
        } else {
            $sql = "INSERT INTO usuario (email, senha) VALUES ('{$this->emailInstitucional}', '{$this->senha}')";
        }
        return $conexao->executa($sql);
    }

    public function delete(): bool {
        $conexao = new MySQL();
        $sql = "DELETE FROM usuario WHERE id = {$this->idUser}";
        return $conexao->executa($sql);
    }

    public static function find($idUser): Usuario {
        $conexao = new MySQL();
        $sql = "SELECT * FROM usuario WHERE id = {$idUser}";
        $resultado = $conexao->consulta($sql);

        $senha = $resultado[0]["senha"];
        $u = new Usuario($resultado[0]['email'], $senha);
        $u->setIdUser($resultado[0]['id']);
        return $u;
    }

    public static function findall(): array {
        $conexao = new MySQL();
        $sql = "SELECT * FROM usuario";
        $resultados = $conexao->consulta($sql);

        $users = [];
        foreach ($resultados as $resultado) {
            $senha = $resultado["senha"];
            $u = new Usuario($resultado['email'], $senha);
            $u->setIdUser($resultado['id']);
            $users[] = $r;
        }
        return $users;
    }    

    public static function findByEmail($email): ?Usuario {
        $conexao = new MySQL();
        $sql = "SELECT * FROM usuario WHERE email = '{$email}'";
        $resultado = $conexao->consulta($sql);
        
        if(isset($resultado[0])){
            $senha = $resultado[0]["senha"];
            $u = new Usuario($resultado[0]['email'], $senha);
            $u->setIdUser($resultado[0]['id']);
            return $u;
        }
        return null;
    }
}
?>