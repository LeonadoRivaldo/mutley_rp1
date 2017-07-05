<?php
require_once('../../controller/utils/versionamento.php');
$versao = new versao();
$url = "";
$postId = "";
$descricao = "";
$path = "";
$ext = "";
$classe = "col-xs-12 col-md-12 col-lg-12";
if (isset($_POST)) {
    if (isset($_POST['data']['url'])) {
        $url = $_POST['data']['url'];
    }
    if (isset($_POST['data']['postId'])) {
        $postId = $_POST['data']['postId'];
    }
    if (isset($_POST['data']['autorId'])) {
        $autorId = $_POST['data']['autorId'];
    }
    if (isset($_POST['data']['descricao'])) {
        $descricao = $_POST['data']['descricao'];
    }
    if (isset($_POST['data']['path'])) {
        $path = $_POST['data']['path'];
        $classe = "col-xs-12 col-md-6 col-lg-6";
    }
    if (isset($_POST['data']['path'])) {
        $path = $_POST['data']['path'];
    }
    if (isset($_POST['data']['ext'])) {
        $ext = $_POST['data']['ext'];
    }
}
?>


<!-- Modal  criar/editar post -->
<div class="modal fade" id="modal_post" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <form id="postForm" data-url="<?php echo $url; ?>">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">
                        Criar publicação
                    </h4>
                </div>
                <!-- modal body -->
                <div class="modal-body">
                    <div id="mensagem" class="alert" role="alert" style="display:none;"></div>
                    <!-- campos do form -->
                    <div class="row">
                        <div class="col-xs-12 col-md-1 col-lg-2"></div>
                        <div class="col-xs-12 col-md-10 col-lg-8">
                            <div class="form-group">
                                <input type="hidden" id="postId" value="<?php echo $postId; ?>">
                                <input type="hidden" id="autorId" value="<?php echo $autorId; ?>">
                                <label for="descricao" class="control-label">Descrição</label>
                                <textarea id="descricao" class="form-control" rows="3" placeholder="Ex: animal perdido, cor marrom com branco, medio porte, na rua silva, perto da igreja"><?php echo $descricao; ?></textarea>
                            </div>
                            <div class="form-group" id="postImagem">
                                <div class="<?php echo $classe; ?> create">
                                    <label for="imagem">Carregar imagem</label>
                                    <input type="file" id="imagem" class="form-control">
                                    <p class="help-block">Faça upload de imagens .PNG ou .JPG com tamanho de 2mb no maximo!</p>
                                </div>
                            </div>
                            <?php if (isset($_POST['data']['path'])) { ?>
                            <div class="<?php echo $classe; ?> thumbnail edit">
                                    <input type="hidden" id="path" value="<?php echo $path; ?>" />
                                    <input type="hidden" id="ext" value="<?php echo $ext; ?>" />
                                    <img src="<?php echo  $versao->auto_version($path.'1'.$ext) ?>" class="img-responsive">
                            </div>
                            <?php } ?>
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
                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Salvar</button>   
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript"></script>