<?php
use Microblog\Categoria;
use Microblog\ControleDeAcesso;
require_once "../vendor/autoload.php";
$sessao = new ControleDeAcesso;
$sessao->verfificaAcesso();
$sessao->verfificaAcessoAdmin();
$categoria = new Categoria;
$categoria->setId($_GET['id']);
$categoria->excluir();
header("location:categorias.php");