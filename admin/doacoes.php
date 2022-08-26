<?php 
require_once "../inc/cabecalho-admin.php";

use CalorDado\Doacoes;
use CalorDado\Utilitarios;
require_once "../inc/cabecalho-admin.php";
$doacao = new Doacoes;
$listaDeDoacoes = $doacao->listarDoacoes();
?>


<div class="row">
	<article class="col-12 bg-white rounded shadow my-1 py-4">
		
		<h2 class="text-center">
		Cadastro <span class="badge bg-dark"><?=count($listaDeDoacoes)?></span>
		</h2>

		<br>
				
		<div class="table-responsive">
		
			<table class="table table-hover">
				<thead class="table-light">
					<tr>
                        <th class="col-2">Endereço</th>
                        <th class="col-1">Cep</th>
                        <th class="col-2">Cidade</th>
						<th class="col-1">Número</th>
						<th class="text-center" colspan="2">Operações</th>
						<!-- tabela de doacoes quebrada, precisa alinhar ela -->
					</tr>
				</thead>

				<tbody>

					<tr>
                        <td> Título da notícia... </td>
                        <td> 21/12/2112 21:12 </td>
                        <td> Autor da notícia... </td>
						<td>Cidade</td>
						
						<td class="text-center">
							<a class="btn btn-warning" 
							href="noticia-atualiza.php">
							<i class="bi bi-pencil"></i> Atualizar
							</a>
						
							<a class="btn btn-danger excluir" 
							href="noticia-exclui.php">
							<i class="bi bi-trash"></i> Excluir
							</a>
						</td>
					</tr>

				</tbody>                
			</table>
	</div>
		
	</article>
</div>


<?php 
require_once "../inc/rodape-admin.php";
?>

