<?php 
require_once "../inc/cabecalho-admin.php";

use CalorDado\Doacoes;
use CalorDado\Utilitarios;
require_once "../inc/cabecalho-admin.php";
$doacao = new Doacoes;
$listaDeDoacoes = $doacao->listarDoacoes();

Utilitarios::dump($listaDeDoacoes);
?>


<div class="row">
	<article class="col-12 bg-white rounded shadow my-1 py-4">
		
		<h2 class="text-center">
		Doações <span class="badge bg-dark"><?=count($listaDeDoacoes)?></span>
		</h2>

		<br>
				
		<div class="table-responsive">
		
			<table class="table table-hover">
				<thead class="table-light">
					<tr>
                        <th class="col-2">Doação</th>
                        <th class="col-1">Quantidade</th>
                        <th class="col-2">usuario</th>
						<th class="text-center" colspan="2">Operações</th>
						<!-- tabela de doacoes quebrada, precisa alinhar ela -->
					</tr>
				</thead>

				<tbody>

				<?php foreach ($listaDeDoacoes as $ListaDeDoacao) { ?>
					<tr>
                        <td> <?=$ListaDeDoacao['doacao']?> </td>
                        <td> <?=$ListaDeDoacao['quantidade']?> </td>
                        <td> <?=$ListaDeDoacao['nome']?> </td>
						
						<td class="text-center">
							<a class="btn btn-warning" 
							href="noticia-atualiza.php?=id">
							<i class="bi bi-pencil"></i> Atualizar
							</a>
						
							<a class="btn btn-danger excluir" 
							href="noticia-exclui.php">
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

