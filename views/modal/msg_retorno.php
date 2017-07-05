<!-- Modal msg -->
<div class="modal fade" id="modal_msg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <form id="userForm" class="controle-de-formulario">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="">Mensagem do sistema</h4>
                </div>
                <!-- modal body -->
                <div class="modal-body">
                    <h5 id="msg">
                        <?php  if( isset($_POST['data']['msg']) && count($_POST) >= 1 ) {
                            echo $_POST['data']['msg'];
                        } ?>
                    </h5>
                </div>
                <!-- modal footer -->
                <div class="modal-footer">
	                <div class="row">
	                	<div class="col-sm-12">
							<div class="form-group">
                     			<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    		</div>
	                	</div>
	                </div>
                </div>
            </div>
        </form>
    </div>
</div>