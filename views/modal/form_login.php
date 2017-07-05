<!-- Modal  login de usuario -->
<div class="modal fade" id="modal_login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <form id="userForm" class="controle-de-formulario">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modal_usuario_title">Logar</h4>
                </div>
                <!-- modal body -->
                <div class="modal-body">
                    <div id="mensagem" class="alert" role="alert" style="display:none;">
                    </div>
                    <!-- campos do form -->
                    <div class="row">
                        <div class="col-xs-12 col-md-1 col-lg-2"></div>
                        <div class="col-xs-12 col-md-10 col-lg-8">
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
                                <button id="limparLogin" type="reset" class="btn btn-default">Limpar</button>
                                <button id="logar" class="btn btn-success"><i class="fa fa-paper-plane"></i> Enviar</button>   
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?php
$file = '../../public/js/login.js';
$mtime = filemtime($file);
echo "<script type='text/javascript' src='./public/js/login.js?v=".$mtime."'></script>";
?>