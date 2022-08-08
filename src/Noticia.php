<?php
namespace Microblog;
Use PDO, Exception;

final class Noticia {
    private int $id;
    private string $data;
    private string $titulo;
    private string $texto;
    private string $resumo;
    private string $imagem;
    private string $destaque;
    private int $categoriaId;
    /* Criando uma propriedade do tipo usuário, 
    ou seja, apartir da classe que criamos com o 
    objetivo de usar recursos dela. 
    Isto permitirá fazer ASSOCIAÇÂO entre classes */
    public Usuario $usuario;
    private PDO $conexao;
    
    public function __construct() {
        /* No momento em que um objeto Noticia for instanciado nas páginas, aproveitaremos para também instanciar um objeto Usuario e com isso acesssar recursos desta classe */
        $this->usuario = new Usuario;
        /* Reaproveitando a conexão já existente a partir da classe de Usuario */
        $this->conexao = $this->usuario->getConexao();;
    }

    public function inserir():void{
        $sql = "INSERT INTO noticias(titulo, texto, resumo, imagem, destaque, usuario_id, categoria_id) VALUES (:titulo, :texto, :resumo, :imagem, :destaque, :usuario_id, :categoria_id)";
        try {
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindParam(":titulo", $this->titulo, PDO::PARAM_STR);
            $consulta->bindParam(":texto", $this->texto, PDO::PARAM_STR);
            $consulta->bindParam(":resumo", $this->resumo, PDO::PARAM_STR);
            $consulta->bindParam(":imagem", $this->imagem, PDO::PARAM_STR);
            $consulta->bindParam(":destaque", $this->destaque, PDO::PARAM_STR);
            $consulta->bindParam(":categoria_id", $this->categoriaId, PDO::PARAM_INT);
            /* Aqui, primeiro chamamos o getter de ID a partir do objeto/classe de Usuario.
            E só depois atribuimos ele ao parâmetro :usuario_id usando para isso o bindValue.
            OBS.: bindParam pode ser usado, mas há riscos de erro devido a forma como ele é executado pelo PHP. Por isso, recomenda-se o uso de bindValue em situações como essa. */
            $consulta->bindValue(":usuario_id", $this->usuario->getId(), PDO::PARAM_INT);
            $consulta->execute();
        } catch (Exception $erro) {
            die("Erro: ".$erro->getMessage());
        }
    }

    public function upload(array $arquivo){
        /* Definindo os formato aceitos */
        $tiposValidos = ["image/png","image/jpeg", "image/gif", "image/svg+xml"];
        if (!in_array($arquivo['type'], $tiposValidos)){
            die("<script> alert('Formato inválido!'); history.back(); </script>");
        } 
        /* Acessando apenas o nome do arquivo */
        $nome = $arquivo['name'];
        /* Acessando os dados de acesso temporário */
        $temporario = $arquivo['tmp_name'];
        /* Definindo a pasta de destino junto com o nome do arquivo */
        $destino = "../imagem/".$nome;
        /* Usamos a função a baixo para pegar da área temporária e enviar para pasta de destino (com o nome do arquivo) */
        move_uploaded_file($temporario, $destino);
    }

    public function listar():array{
        /* Se o tipo de usuário logado for admin */
        if($this->usuario->getTipo() === 'admin'){
            /* Então ele poderá acessar as notícias de todo mundo */
            $sql = "SELECT noticias.id, noticias.titulo, noticias.data, noticias.destaque, usuarios.nome AS autor FROM noticias LEFT JOIN usuarios ON noticias.usuario_id = usuarios.id ORDER BY data DESC";
        } else {
            /* Se não (ou seja, é um editor), este usuário (editor) poderá acessar SOMENTE suas próprias notícias */
            $sql = "SELECT id, titulo, data, destaque 
            FROM noticias WHERE usuario_id = :usuario_id 
            ORDER BY data DESC";
        }
        try {
            $consulta = $this->conexao->prepare($sql);
            /* Se não for um usuário admin, então trate o parâmetro de usuário_id antes de executar */
            if ($this->usuario->getTipo() !== 'admin') {
                $consulta->bindValue(":usuario_id", $this->usuario->getId(), PDO::PARAM_INT);
            }
            $consulta->execute();
            $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

        } catch (Exception $erro) {
            die("Erro: ".$erro->getMessage());
        }
        return $resultado;
    } 

    
    public function getId(): int
    {
        return $this->id;
    }
    public function setId(int $id) {
        $this->id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
    }

    public function getTitulo(): string
    {
        return $this->titulo;
    }
    public function setTitulo(string $titulo)
    {
        $this->titulo = filter_var($titulo, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    public function getTexto(): string
    {
        return $this->texto;
    }
    public function setTexto(string $texto)
    {
        $this->texto = filter_var($texto, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    public function getResumo(): string
    {
        return $this->resumo;
    }
    public function setResumo(string $resumo)
    {
        $this->resumo = filter_var($resumo, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    public function getImagem(): string
    {
        return $this->imagem;
    }
    public function setImagem(string $imagem)
    {
        $this->imagem = filter_var($imagem, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    public function getDestaque(): string
    {
        return $this->destaque;
    }
    public function setDestaque(string $destaque)
    {
        $this->destaque = filter_var($destaque, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    public function getCategoriaId(): int
    {
        return $this->categoriaId;
    }
    public function setCategoriaId(int $categoriaId)
    {
        $this->categoriaId = filter_var($categoriaId, FILTER_SANITIZE_NUMBER_INT);
    }
}
