<?php
namespace CalorDado;
use PDO, Exception;

final class Admin {
    private int $id;
    private string $email;
    private string $senha;
    private PDO $conexao;
    
    public function __construct(){
        $this->conexao = Banco::conecta();
    }
   
    public function listar():array{
        $sql = "SELECT id, email, senha FROM admin ORDER BY nome";
        try{
            $consulta = $this->conexao->prepare($sql);
            $consulta->execute();
            $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        } catch(Exception $erro){
            die("Erro: ".$erro->getMessage());
        }
        return $resultado;    
    }

    /* precisa botar os valores aqui tambem embaixo */
    public function insere():void{
        $sql = "INSERT INTO admin(email, senha) VALUES  ";
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
    }



    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = filter_var($email, FILTER_SANITIZE_EMAIL);
    }



    public function getSenha(): string
    {
        return $this->senha;
    }

    public function setSenha(string $senha)
    {
        $this->senha = filter_var($senha, FILTER_SANITIZE_SPECIAL_CHARS);
    }

}
