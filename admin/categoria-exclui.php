<?php
use Microblog\ControleDeAcesso;
require_once "../vendor/autoload.php";
$sessao = new ControleDeAcesso;
$sessao->verfificaAcesso();
$sessao->verfificaAcessoAdmin();