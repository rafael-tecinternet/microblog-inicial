<?php
namespace Microblog;
Use PDO, Exception;

final class Cadastro {
    private int $id;
    private string $telefone;
    private string $endereco;
    private string $cep;
    private string $cidade;
    private string $numero;
    private string $bairro;
    private string $complemento;
    private int $doacoesId;
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
        $this->conexao = $this->usuario->getConexao();
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

    public function listarUm():array{
        if($this->usuario->getTipo() === 'admin'){
            $sql = "SELECT titulo, texto, resumo, imagem, usuario_id, categoria_id, destaque FROM noticias WHERE id = :id";
        } else {
            $sql = "SELECT titulo, texto, resumo, imagem, usuario_id, categoria_id, destaque FROM noticias WHERE id = :id AND usuario_id = :usuario_id";
        }
        try {
            $consulta = $this->conexao->prepare($sql);
            /* parâmetro id noticia (todos os usuarios) */
            $consulta->bindParam(":id", $this->id, PDO::PARAM_INT);
            if ($this->usuario->getTipo() !== 'admin') {
                /* parâmetro usuario_id */
                $consulta->bindValue(":usuario_id", $this->usuario->getId(), PDO::PARAM_INT);
            }
            $consulta->execute();
            $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        } catch (Exception $erro) {
            die("Erro: ".$erro->getMessage());
        }
        return $resultado;
    }

    public function atualizar():void{
        if($this->usuario->getTipo() === 'admin'){
            $sql = "UPDATE noticias SET titulo = :titulo, texto = :texto, resumo = :resumo, imagem = :imagem, categoria_id = :categoria_id, destaque = :destaque WHERE id = :id";
        } else {
            $sql = "UPDATE noticias SET titulo = :titulo, texto = :texto, resumo = :resumo, imagem = :imagem, categoria_id = :categoria_id, destaque = :destaque WHERE id = :id AND usuario_id = :usuario_id";
        }
        try {
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindParam(":id", $this->id, PDO::PARAM_INT);
            $consulta->bindParam(":titulo", $this->titulo, PDO::PARAM_STR);
            $consulta->bindParam(":texto", $this->texto, PDO::PARAM_STR);
            $consulta->bindParam(":resumo", $this->resumo, PDO::PARAM_STR);
            $consulta->bindParam(":imagem", $this->imagem, PDO::PARAM_STR);
            $consulta->bindParam(":categoria_id", $this->categoriaId, PDO::PARAM_INT);
            $consulta->bindParam(":destaque", $this->destaque, PDO::PARAM_STR);
            if ($this->usuario->getTipo() !== 'admin') {
                /* parâmetro usuario_id */
                $consulta->bindValue(":usuario_id", $this->usuario->getId(), PDO::PARAM_INT);
            }
            $consulta->execute();
        } catch (Exception $erro) {
            die("Erro: ".$erro->getMessage());
        }
        
    }

    public function excluir():void {
        if( $this->usuario->getTipo() === 'admin' ){
            $sql = "DELETE FROM noticias WHERE id = :id";
        } else {
            $sql = "DELETE FROM noticias 
                    WHERE id = :id AND usuario_id = :usuario_id";
        }

        try {
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindParam(":id", $this->id, PDO::PARAM_INT);
            if ($this->usuario->getTipo() !== 'admin') {
                $consulta->bindValue(":usuario_id", $this->usuario->getId(), PDO::PARAM_INT);
            }
            $consulta->execute();
        } catch (Exception $erro) {
            die("Erro: ". $erro->getMessage());
        }
    }

    /* Métodos para a área pública do site */
    public function listarDestaques():array {
        $sql = "SELECT titulo, imagem, resumo, id FROM noticias WHERE destaque = :destaque ORDER BY data DESC";
        try {
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindParam(':destaque', $this->destaque, PDO::PARAM_STR);
            $consulta->execute();
            $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $erro) {
            die("Erro: " .$erro->getMessage());
        }
        return $resultado;
    }

    public function listarTodas():array {
        $sql = "SELECT data, titulo, resumo, id FROM noticias ORDER BY data DESC";
        try {
            $consulta = $this->conexao->prepare($sql);
            $consulta->execute();
            $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $erro) {
            die("Erro: " .$erro->getMessage());
        }
        return $resultado;
    }

    public function listarDetalhes():array{
        $sql = "SELECT noticias.id, noticias.titulo, noticias.data, noticias.imagem, noticias.texto, usuarios.nome AS autor FROM noticias LEFT JOIN usuarios ON noticias.usuario_id = usuarios.id WHERE noticias.id = :id";
        try {
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindParam(":id", $this->id, PDO::PARAM_INT);
            $consulta->execute();
            $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $erro) {
            die("Erro: ".$erro->getMessage());
        }
        return $resultado;
    } 

    public function listarPorCategorias():array{
        $sql = "SELECT noticias.id, noticias.titulo, noticias.data, noticias.resumo, usuarios.nome AS autor, categorias.nome AS categoria FROM noticias LEFT JOIN usuarios ON noticias.usuario_id = usuarios.id INNER JOIN categorias ON noticias.categoria_id = categorias.id WHERE noticias.categoria_id = :categoria_id";
        try {
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindParam(":categoria_id", $this->categoriaId, PDO::PARAM_INT);
            $consulta->execute();
            $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $erro) {
            die("Erro: ".$erro->getMessage());
        }
        return $resultado;
    } 

    public function busca():array {
        $sql = "SELECT titulo, data, resumo, id FROM noticias WHERE titulo LIKE :termo OR texto LIKE :termo OR resumo LIKE :termo ORDER BY data DESC";
        try {
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindValue(":termo", '%'.$this->termo.'%', PDO::PARAM_STR);
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

    public function getTelefone(): string
    {
        return $this->telefone;
    }
    public function setTelefone(string $telefone)
    {
        $this->telefone = $telefone;
    }

    public function getEndereco(): string
    {
        return $this->endereco;
    }
    public function setEndereco(string $endereco)
    {
        $this->endereco = $endereco;
    }

    public function getCep(): string
    {
        return $this->cep;
    }
    public function setCep(string $cep)
    {
        $this->cep = $cep;
    }

    public function getCidade(): string
    {
        return $this->cidade;
    }
    public function setCidade(string $cidade)
    {
        $this->cidade = $cidade;
    }

    public function getNumero(): string
    {
        return $this->numero;
    }
    public function setNumero(string $numero)
    {
        $this->numero = $numero;
    }

    public function getBairro(): string
    {
        return $this->bairro;
    }
    public function setBairro(string $bairro)
    {
        $this->bairro = $bairro;
    }

    public function getComplemento(): string
    {
        return $this->complemento;
    }
    public function setComplemento(string $complemento)
    {
        $this->complemento = $complemento;
    }

    public function getDoacoesId(): int
    {
        return $this->doacoesId;
    }
    public function setDoacoesId(int $doacoesId)
    {
        $this->doacoesId = $doacoesId;
    }
}
