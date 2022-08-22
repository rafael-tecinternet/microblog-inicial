<?php 
require_once "../inc/cabecalho-admin.php";
?>


<div class="row">
	<article class="col-12 bg-white rounded shadow my-1 py-4">
		
		<h2 class="text-center">
		Doações <span class="badge bg-dark">X</span>
		</h2>

		
				
		<div class="table-responsive">
		
			<table class="table table-hover">
				<thead class="table-light">
					<tr>
						<th>Nome</th>
						<th>doação</th>
						<th>Quantidade</th>
						<th class="text-center">Operações</th>
					</tr>
				</thead>

				<tbody>

					<tr>
						<td> Nome... </td>
						<td class="text-center" colspan="3">
							<a class="btn btn-warning" 
							href="categoria-atualiza.php">
							<i class="bi bi-pencil"></i> Atualizar
							</a>
						
							<a class="btn btn-danger excluir" 
							href="categoria-exclui.php">
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

