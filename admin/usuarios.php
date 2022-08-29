<?php
use CalorDado\Usuario;
use CalorDado\Utilitarios;
require_once "../inc/cabecalho-admin.php";
$usuario = new Usuario;



$listaDeUsuarios = $usuario->listarUsuario();
Utilitarios::dump($listaDeUsuarios);
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
						<th class="col-1">Nome</th>
						<th class="col-1">E-mail</th>
						<th class="col-2">Endereço</th>
						<th class="col-1">CEP</th>
						<th class="col-2">cidade</th>
						<th class="col-2">numero da casa</th>
						<th class="col-2 text-center" colspan="2">Operações</th>
						<!-- tabela de usuarios quebrada, precisa alinhar ela -->
					</tr>
				</thead>

				<tbody>
				<?php foreach($listaDeUsuarios as $usuario) { ?>
					<tr>
						<td> <?=$usuario['nome']?> </td>
						<td> <?=$usuario['email']?> </td>
						<td> <?=$usuario['endereco']?> </td>
						<td> <?=$usuario['cep']?> </td>
						<td> <?=$usuario['cidade']?> </td>
						<td> <?=$usuario['numero']?> </td>
						
						<td class="text-center" colspan="5">
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

