<?php
namespace CalorDado;
use PDO, Exception;

final class Doacoes {
    private int $id;
    private array $doacao;
    private int $quantidade;
    private PDO $conexao;
    
    public function __construct(){
        $this->conexao = Banco::conecta();
    }
   
    public function listarDoacoes():array{
        /* faze right/inner join aqui depois com a tabela usuarios */
        $sql = "SELECT doacoes.id, doacoes.doacao, doacoes.quantidade, usuarios.nome FROM doacoes 
        LEFT JOIN usuarios
        ON doacoes.usuario_id = usuarios.id";
        
        try{
            $consulta = $this->conexao->prepare($sql);
            $consulta->execute();
            $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        } catch(Exception $erro){
            die("Erro: ".$erro->getMessage());
        }
        return $resultado;    
    }

    public function insere():void{
        $sql = "INSERT INTO doacoes(doacao, quantidade) VALUES  ";
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
    }

 
    
    public function getDoacao(): array
    {
        return $this->doacao;
    }

    public function setDoacao(array $doacao)
    {
        $this->doacao = filter_var_array($doacao ?? [], FILTER_SANITIZE_SPECIAL_CHARS);

        return $this;
    }


    
    public function getQuantidade(): int
    {
        return $this->quantidade;
    }
    
    public function setQuantidade(int $quantidade)
    {
        $this->quantidade = filter_var($quantidade, FILTER_SANITIZE_NUMBER_INT);

        return $this;
    }
}
