<?php
namespace CalorDado;
// Indicamos o uso das classes nativas do PHP (ou seja, classes que não fazer parte do nosso namespace)
use PDO, Exception;
abstract class Banco {
    // Propriedades / atributos de acesso ao servidor de Banco de Dados
    private static string $servidor = "localhost";
    private static string $usuario = "root";
    private static string $senha = "";
    private static string $banco = "calor-dado";
    // private static \PDO $conexao; não precisa do use PDO
    private static PDO $conexao; /* precisa do "use PDO" */
    // Método de conexão ao banco
    public static function conecta():PDO{
        try {
            // Criando a conexão com o MySQL (API/Driver de conexão)
            // Acessando recursos estáticos da propria classe com self::
            self::$conexao = new PDO("mysql:host=".self::$servidor."; dbname=".self::$banco."; charset=utf8", self::$usuario, self::$senha);
            // Habilida a verificação de erros (em geral e exceções)
            self::$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $erro) {
            die("Erro: ".$erro->getMessage());
        }
        return self::$conexao;
    }

}

?>