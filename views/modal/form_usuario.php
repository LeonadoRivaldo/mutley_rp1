<!-- Modal  criar/editar usuario -->
<div class="modal fade" id="modal_usuario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<form id="userForm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="modal_usuario_title">Criar usuario</h4>
				</div>
				<!-- modal body -->
				<div class="modal-body">
					<div id="mensagem" class="alert" role="alert" style="display:none;"></div>
					<!-- campos do form -->
					<div class="row">
						<div class="col-xs-12 col-md-1 col-lg-2"></div>
						<div class="col-xs-12 col-md-10 col-lg-8">
							<div class="form-group">
								<input type="hidden" class="form-control" id="usuarioId">
								<label for="nomeUsuario" class="control-label">Nome</label>
								<input type="text" class="form-control" id="usuarioNome" placeholder="Nome">
							</div>
							<div class="form-group">
								<label for="usuarioEmail" class="control-label">E-mail</label>
								<input type="email" class="form-control" id="usuarioEmail" placeholder="E-mail">
							</div>
							<div class="form-group">
								<label for="usuarioPassword" class="control-label">Senha</label>
								<input type="password" class="form-control" id="usuarioPassword" placeholder="Senha">
							</div>
						</div>
						<div class="col-xs-12 col-md-1 col-lg-2"></div>
					</div>
					<!--campos do form[fim] -->
				</div>
				<!-- modal footer -->
				<div class="modal-footer">
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
							<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
							<button type="reset" class="btn btn-default">Limpar</button>
							<?php 
								session_start();
								if(isset($_SESSION['user_id'])) { ?>
								<button id="deleteUsuario" type="button" class="btn btn-danger">
								<i class="fa fa-trash"></i> Excluir
								</button>
							<?php } ?>
								<button id="salvar" class="btn btn-success"><i class="fa fa-save"></i> Salvar</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>