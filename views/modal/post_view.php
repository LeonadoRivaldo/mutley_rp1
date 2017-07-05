<?php 
session_start();
require_once('../../controller/utils/funcoes.php');
require_once('../../controller/utils/versionamento.php');
$versao = new versao();
$funcoes = new Funcoes();    
if( isset($_POST) && count($_POST) >= 1){
    $autor = Array( 
        'nome' => $_POST['data']['post']['autor']['nome'] ,
        'cadastrado' => $_POST['data']['post']['autor']['cadastrado'],   
        'email' => $_POST['data']['post']['autor']['email'],
        'id' => $_POST['data']['post']['autor']['id'] 
    );
    $post = array(
        'id' => $_POST['data']['post']['postId'] ,
        'path' =>$_POST['data']['post']['path'],
        'descricao' => $_POST['data']['post']['descricao'],
        'criacao' => $_POST['data']['post']['criacao'],
        'ext' => $_POST['data']['post']['ext'],
        'denuncias' => $_POST['data']['post']['denuncias'],
        'likes' => $_POST['data']['post']['likes'],                 
    );
    $comentarios = $_POST['data']['post']['comentarios'];
}
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
$post['criacao'] = strtotime($post['criacao']);
$post['criacao'] = date('d/m/Y \a\s g:i a', $post['criacao'] );
$autor['cadastrado'] = strtotime($autor['cadastrado']);
$autor['cadastrado'] = date('d/m/Y \a\s g:i a', $autor['cadastrado'] );
$hasComments = false;
if( count( $comentarios ) >= 1  && is_array($comentarios)){
    $hasComments = true;
}
?>

<div aria-labelledby="myLargeModalLabel" class="modal fade" id="modal_post_view" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div id="mainContent" class="modal-content post-content">
            <div class="modal-header post-header">
                <input type="hidden" name="postId" value="<?php echo $post['id']; ?>" data-id="<?php echo $post['id']; ?>">
                <input type="hidden" name="autorId" value="<?php echo $autor['id']; ?>">
                <input type="hidden" name="denuncias" value="<?php echo $post['denuncias']; ?>">
                <input type="hidden" name="likes" value="<?php echo $post['likes']; ?>">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 autor-info">
                        <h6 class="text-justify">
                            Criado por: 
                            <strong>
                                <a id="autorInfo" href="#"><?php echo $autor['nome']; ?></a>
                            </strong>
                            em <?php echo $post['criacao']; ?> 
                        </h6>
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-right options">
                        <a class="btn btn-primary btn-sm" id="likePublicacao">
                            <i class="fa fa-thumbs-up"></i> Gostei! <span class="badge"><?php echo $post['likes']; ?></span>
                        </a>
                        <?php 
                        if( isset($_SESSION['user_id']) ){ ?>
                            <a class="btn btn-danger btn-sm" id="denunciaPublicacao">
                            <i class="fa fa-ban"></i> Denunciar <span class="badge"><?php echo $post['denuncias']; ?></span>
                            </a>
                            <?php if(!$hasComments){ ?>
                                <a class="btn btn-success btn-sm" id="addComment"><i class="fa fa-commenting"></i> Comentar</a>
                            <?php } ?>
                            <?php if($_SESSION['user_id'] == $autor['id'] ){ ?>
                                <a class="btn btn-primary btn-sm" id="editarPublicacao"><i class="fa fa-edit"></i> Editar</a>
                            <?php } ?>
                        <?php } ?>
                        <a aria-label="Close" class="close" data-dismiss="modal"><i class="fa fa-times"></i></a>
                    </div>
                </div>
            </div>
            <div class="modal-body post-body">
                <div class="row">
                    <!-- Coluna 1 de 4 linhas: Data, imagem, denunciar e descrição -->
                    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7 content-left">
                        <div class="row rOne">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <img id="post-img" class="img-responsive img-rounded" src="<?php echo  $versao->auto_version($post['path'].'1'.$post['ext']) ?>"/>
                            </div>
                        </div>
                        <?php if( $hasComments ){ ?>
                            <div class="row rTwo">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <h4>Descrição</h4>
                                    <p class="text-justify">
                                        <?php echo $post['descricao']; ?>
                                    </p>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <!-- Coluna 2 de 1 linha: Comentários -->
                    <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5 content-right">
                        <?php if( $hasComments  ){ ?>
                            <h4 class="title">Comentários</h4>
                            <div id="comentarios"></div>
                            <div class="comentarios">
                            <?php 
                                $i = 0;
                                foreach ($comentarios as $comentario) {
                                    date_default_timezone_set('America/Sao_Paulo');
                                    $data = date('d/m/Y \a\s g:i a', strtotime($comentario['dataCriacao']));
                                    $html = '<div class="comentario_'.$i.'"><div class="well well-sm comentario">';
                                    $html .= $comentario['texto'];
                                    $html .= '<small class="pull-right" id="comment-autor">';
                                    $html .= 'Por: '.$comentario['autorName'].' em '. $data ;
                                    $html .= '</small>';
                                    if( isset($_SESSION['user_id']) ){
                                        if($_SESSION['user_id'] == $autor['id'] ){ 
                                           $html .= '<i onClick="deletaComentario(this)" data-index="'.$i.'" data-cid="'.$comentario['id'].'" class="fa fa-trash" id="deletComentario"></i>';
                                        }
                                    }
                                    $html .= '</div></div>';
                                    echo $html;
                                    $i++;
                                }
                            ?>
                            </div>
                            <?php if( isset($_SESSION['user_id']) ){ ?>
                                <div class="newComentario">
                                    <textarea class="form-control add-comentario" placeholder="deixe seu comentario..."></textarea>
                                    <div id="salvarComentario" class="btn-group btn-group-justified" role="group" aria-label="...">
                                        <a class="btn btn-sm btn-success"><i class="fa fa-save"></i> Salvar Comentario</a>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php }else{?>
                             <h4 class="title">Descrição</h4>
                             <p class="text-justify">
                                    <?php echo $post['descricao']; ?>
                                </p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">


function comentarioEmbranco(elem){
        if( elem.val().length <= 0 ){
            elem.addClass("erro").attr("placeholder","Não esqueça de preencher esse campo!").focus();
            return true;
        }else{
            elem.removeClass("erro").addClass("sucesso");
            return false;
        }
}


    $(document).ready(function(){
        $('#addComment').click(function(event){
            event.preventDefault();
            $(this).popover({
                html: true,
                content: '<div class="input-group">'+
                  '<input type="text" id="pop" class="form-control add-comentario" placeholder="deixe seu comentario..." />'+
                  '<span class="input-group-addon" id="popSalvar"><i class="fa fa-save"></i></span>'+
                '</div>',
                title: 'Escreva um comentario!',
                placement: 'bottom',
            }).popover('toggle');

            $("#popSalvar").click(function(e){
                e.preventDefault();
                if( !comentarioEmbranco($("#pop.add-comentario")) ){
                    comentario = $("#pop.add-comentario").val();
                    postId = $("input[name='postId']").val();
                    user ={
                        id: cookie.getCookie("user_id"),
                        nome: cookie.getCookie("user_name")
                    }; 
                    post.comentario(comentario, postId, user);
                }
            });
        });

        $('#autorInfo').click(function(event){
            autor = {
                email: <?php echo "'".$autor['email']."'" ?>,
                nome: <?php echo "'".$autor['nome']."'" ?>,
                cadastrado: <?php echo "'".$autor['cadastrado']."'" ?>
            }
            event.preventDefault();
            $(this).popover({
                html:true,
                content: '<b>Nome:</b> '+autor.nome+'<hr style="margin: 5px 0;"><b>E-mail: </b>'+autor.email+'<hr style="margin: 5px 0;"><b>Cadastrado: </b>'+autor.cadastrado,
                title: 'Dados do autor',
                placement: 'bottom',
            }).popover('toggle');
        });


        var likes = $("input[name='likes']").val();
        $("#likePublicacao").click(function(){
            cname = "likePost"+$("input[name='postId']").val();
            cpost = cookie.getCookie(cname);
            if( !(cpost == "liked") ){                
                likes++;
                $(this).find("span.badge").html(likes);
                 $.ajax({
                url:"../../controller/post/actions.php",
                method: 'POST',
                dataType: 'JSON',
                data: {
                    action: "like",
                    likes: likes,
                    postId: $("input[name='postId']").val()
                   },
                success: function(ret) {
                   console.log("Erro: "+ret.erro+", "+ret.msg);
                   cookie.setCookie(cname,"liked",0.001);
                }
                });
            }else{
                alert("Você realizou essa ação!");
            }
        });
        var complaints = $("input[name='denuncias']").val();
        $("#denunciaPublicacao").click(function(){
            cname = "complaintPost"+$("input[name='postId']").val();
            cpost = cookie.getCookie(cname);
            if( !(cpost == "complaint") ){                
                complaints++;
                $(this).find("span.badge").html(complaints);
                 $.ajax({
                url:"../../controller/post/actions.php",
                method: 'POST',
                dataType: 'JSON',
                data: {
                    action: "complaint",
                    complaints: complaints,
                    postId: $("input[name='postId']").val(),
                    uid: $("input[name='autorId']").val()
                   },
                success: function(ret) {
                   if( ret.erro == 20 || ret.erro == 21){
                        alert(ret.msg);
                        setTimeout(function(){
                            location.reload();
                        }, 2000);
                   }else{
                    console.log("Erro: "+ret.erro+", "+ret.msg);
                    cookie.setCookie(cname,"complaint",0.001);
                   }
                }
                });
            }else{
                alert("Você já denunciou esse post!");
            }
        });

        $("#editarPublicacao").click(function(event){
            event.preventDefault();
            cookie.setCookie("postEditing",true,1);
            $("#modal_post_view").modal('hide');
            dados = {
             postId: $("input[name='postId'").val(),
             autorId: $("input[name='autorId'").val(),
             ext: <?php echo "'".$post['ext']."'"; ?>,
             url: 'update.php',
             descricao:  <?php echo "'".$post['descricao']."'"; ?>,
             path: <?php echo "'".$post['path']."'"; ?>
            };
            modal.loadHtml("./views/modal/form_publicacao.php", modal.postForm, dados );
        });


        $("#salvarComentario").click(function(e){
            e.preventDefault();
            if(!comentarioEmbranco($(".add-comentario"))){
                comentario = $(".add-comentario").val();
                postId = $("input[name='postId']").val();
                user ={
                    id: cookie.getCookie("user_id"),
                    nome: cookie.getCookie("user_name")
                };
                comentariosContainer = $(".comentarios");
                post.comentario(comentario, postId, user,comentariosContainer);
            }
        });


    });
</script>