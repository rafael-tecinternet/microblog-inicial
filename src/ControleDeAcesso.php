<?php

namespace Microblog;

final class ControleDeAcesso {
    public function __construct() {
        /* Se não existir uma sessão em funcionamento */
        if(!isset($_SESSION)) {
            /* Então iniciamos a sessão */
            session_start();
        }
    }

    public function verfificaAcesso():void{
        /* Se NÃO EXISTIR uma variável de sessão relacionada ao id do usuário logado.. */
        if (!isset($_SESSION['id'])) {
            /* Então significa que o usuário não está logado, portando apqgue qualquer resquício de sessão e force o usuário a ir para o login.php */
            session_destroy();
            header("location:../login.php?acesso_proibido");
            die();
        }
    }
}

?>