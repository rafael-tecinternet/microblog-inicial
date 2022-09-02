<?php

if (isset($_POST["rest-senha-submit"]) ) {
    
    $selecionador = $_POST["selecionador"];
    $validacao = $_POST["validacao"];
    $senha = $_POST["senha"];
    $senhaConfirma = $_POST["senha-confirma"];
    
    /* caso o campo senha e/ou confirma-senha estiverem vazios, ele vai mandar o ususario para uma pagina de erro */
    if (empty($senha) || empty($senhaConfirma)) {
    header("../criar-nova-senha.php?novasenha=empty");
    die();
    /* caso a senha for diferente do confirma-senha ele vai dar uma tela/mensagem de erro e vai pedir novamente para o usuario colocar as senhas nos campos */
} else if ($senha != $senhaConfirma) {
    header("../criar-nova-senha.php?novasenha=senhadiferente");
    die();
}
    /* checando os tokens */

    $dataAtual = date("U");

    require '';

    } else {
    header("location: ../index.php");
}