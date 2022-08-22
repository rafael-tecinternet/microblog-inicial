### COMANDOS SQL 

## Modelagem Física:

# Criar banco de dados:

``` sql
CREATE DATABASE calordado CHARACTER SET utf8mb4;

```

# Criar tabelas: admin

``` SQL
CREATE TABLE admin(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(45) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL
);
```

# Criar tabelas: cadastro

``` SQL
CREATE TABLE cadastro(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    endereco VARCHAR(80) NOT NULL,
    cep VARCHAR(8) NOT NULL,
    cidade VARCHAR(45) NOT NULL,
    numero_casa VARCHAR(5) NOT NULL,
    usuario_id INT NOT NULL
);
```

# Criar tabela: usuarios

``` SQL
CREATE TABLE usuarios(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(45) NOT NULL,
    email VARCHAR(45) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL
);
```
# Criar tabela: doacoes

``` SQL
CREATE TABLE doacoes(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    doacao ENUM('roupas', 'cobertores', 'calcados') NOT NULL,
    usuario_id INT NOT NULL
);
```
# Criar relacionamento entre usuarios e cadastro:

``` SQL
ALTER TABLE cadastro
    ADD CONSTRAINT fk_cadastro_usuarios
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id);
```

# Criar relacionamento entre: doacoes e usuarios

``` SQL
  ALTER TABLE doacoes
  ADD CONSTRAINT fk_doacoes_usuarios
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id);
```

# Adicionar campo quantidade na tabela doações

``` sql
ALTER TABLE `doacoes` ADD `Quantidade` INT NOT NULL AFTER `doacao`;
```