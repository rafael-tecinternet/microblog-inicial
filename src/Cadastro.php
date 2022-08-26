<?php
namespace CalorDado;
use PDO, Exception;

final class Cadastro {
    private int $id;
    private string $endereco;
    private string $cep;
    private string $cidade;
    private string $numero;
    private PDO $conexao;
    
    public function __construct(){
        $this->conexao = Banco::conecta();
    }
   
    public function listarCadastro():array{
        $sql = "SELECT id, endereco, cep, cidade, numero_casa FROM cadastro ORDER BY nome";
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
        $sql = "INSERT INTO cadastro(endereco, cep, cidade, numero_casa) VALUES  ";
    }

    

   
    public function getId(): int
    {
        return $this->id;
    }

    
    public function setId(int $id)
    {
        $this->id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

    }

   
    public function getEndereco(): string
    {
        return $this->endereco;
    }

    
    public function setEndereco(string $endereco)
    {
        $this->endereco = filter_var($endereco, FILTER_SANITIZE_SPECIAL_CHARS);

    }

    
    public function getCep(): string
    {
        return $this->cep;
    }

   
    public function setCep(string $cep)
    {
        $this->cep = filter_var($cep, FILTER_SANITIZE_SPECIAL_CHARS);

    }

    
    public function getCidade(): string
    {
        return $this->cidade;
    }

    
    public function setCidade(string $cidade)
    {
        $this->cidade = filter_var($cidade, FILTER_SANITIZE_SPECIAL_CHARS);

    }

    
    public function getNumero(): string
    {
        return $this->numero;
    }

    
    public function setNumero(string $numero)
    {
        $this->numero = filter_var($numero, FILTER_SANITIZE_SPECIAL_CHARS);

    }
}
