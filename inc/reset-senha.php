<?php

if (isset($_POST["reset-senha"])) {
    /* entendendo a logica: a variavel $token, pela funcao random bytes ira gerar letras e simbolos aleatorios no link, para que ninguem possa ter acesso a ela alem do usuario que quiser recuperar sua senha.

    a variavel $selecionador vai verificar e autenticar pra ver se é realmente aquele usuario especifico que quer redefinir sua senha
    */
    
    $selecionador = bin2hex(random_bytes(8));
    $token = random_bytes(32);

    /* a variavel URL vai pegar a pagina de recuperar a senha e concatenar com as variaveis $selecionador e $token */

    $url = "localhost/microblog-inicial/esqueceu-sua-senha.php?selecionador=".$selecionador. "&validator=". bin2hex($token);

    /* criando uma data de expiracao para o token */

    /* aqui, a data de expiracao vai ser 10 minutos (600 segundos) apos o token ser criado, o usuario tera 10min para poder fazer o reset de sua senha */

    $expiracao = date("U") + 600;

    
} else {
    // caso o usuario entrar nessa pagina de recuperacao de senha por engano, ele vai para a localizacao informada
    header("location: ../index.php");
}