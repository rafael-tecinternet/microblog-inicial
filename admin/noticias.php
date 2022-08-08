<?php
use Microblog\Noticia;
use Microblog\Utilitarios;

require_once "../inc/cabecalho-admin.php";
$noticia = new Noticia;
/* Capturando o id e o tipo do usuário logado e associando estes valores às propriedades do objeto usuário */
$noticia->usuario->setId($_SESSION['id']);
$noticia->usuario->setTipo($_SESSION['tipo']);
$listadeNoticias = $noticia->listar();

?>


<div class="row">
	<article class="col-12 bg-white rounded shadow my-1 py-4">
		
		<h2 class="text-center">
		Notícias <span class="badge bg-dark"><?=count($listadeNoticias)?></span>
		</h2>

		<p class="text-center mt-5">
			<a class="btn btn-primary" href="noticia-insere.php">
			<i class="bi bi-plus-circle"></i>	
			Inserir nova notícia</a>
		</p>
				
		<div class="table-responsive">
		
			<table class="table table-hover">
				<thead class="table-light">
					<tr>
                        <th>Título</th>
                        <th class="text-center">Data</th>
						<?php  if($_SESSION['tipo'] === 'admin') {  ?>
                        	<th class="text-center">Autor</th>
						<?php } ?>
						<th>Destaque</th>
						<th colspan="2" class="text-center">Operações</th>
					</tr>
				</thead>

				<tbody class="text-center">
<?php foreach($listadeNoticias as $noticia){ ?>
					<tr>
                        <td class="text-start"> <?=$noticia['titulo']?> </td>
                        <td> <?=Utilitarios::formataData($noticia['data'])?> </td>
						<?php  if($_SESSION['tipo'] === 'admin') {  ?>
							<!-- Operador ?? operador de Coalescência Nula: Na pràtica, o valor à esquerda é exibido(desde que ele exista), caso contrário o valor à direita -->
							<td> <?=$noticia['autor'] ?? "Equipe Microblog"?> </td>
						<?php } ?>
                        <td> <?=$noticia['destaque']?> </td>
						<td class="text-center">
							<a class="btn btn-warning" 
							href="noticia-atualiza.php?id=<?=$noticia['id']?>">
							<i class="bi bi-pencil"></i> Atualizar
							</a>
						</td>
						<td>
							<a class="btn btn-danger excluir" 
							href="noticia-exclui.php?id=<?=$noticia['id']?>">
							<i class="bi bi-trash"></i> Excluir
							</a>
						</td>
					</tr>
<?php } ?>
				</tbody>                
			</table>
	</div>
		
	</article>
</div>


<?php 
require_once "../inc/rodape-admin.php";
?>

