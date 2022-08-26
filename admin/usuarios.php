<?php
use CalorDado\Usuario;
use CalorDado\Utilitarios;
require_once "../inc/cabecalho-admin.php";
$usuario = new Usuario;
$listaDeUsuarios = $usuario->listarUsuario();
?>


<div class="row">
	<article class="col-12 bg-white rounded shadow my-1 py-4">
		
		<h2 class="text-center">
		Usuários <span class="badge bg-dark"><?=count($listaDeUsuarios)?></span>
		</h2>
				
		<div class="table-responsive">
		
			<table class="table table-hover">
				<thead class="table-light">
					<tr>
						<th>Nome</th>
						<th>E-mail</th>
					</tr>
				</thead>

				<tbody>
				<?php foreach($listaDeUsuarios as $usuario) { ?>
					<tr>
						<td> <?=$usuario['nome']?> </td>
						<td> <?=$usuario['email']?> </td>
						<td class="text-center">
							<a class="btn btn-warning" 
							href="usuario-atualiza.php">
							<i class="bi bi-pencil"></i> Atualizar
							</a>
						
							<a class="btn btn-danger excluir" 
							href="usuario-exclui.php">
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

