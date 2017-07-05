<?php
require_once '../controller/utils/versionamento.php';
$versao = new versao();
$file   = $_POST['post']['path'] . '1' . $_POST['post']['ext'];
$file   = explode("/", $file, 3);
$file   = $file[1] . "/" . $file[2];
$imagem = $versao->auto_version($file);
date_default_timezone_set('America/Sao_Paulo');
$dataCriacao = date("Y-m-d", strtotime($_POST['post']['dataCriacao']));
$today = date("Y-m-d");
?>
<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
		<a href="#" class="thumbnail visualizarPost" data-id="<?php echo $_POST['post']['id'] ?>" onClick="viewPost(this,event)">
			<div class="pane">
				<?php 
				if( $dataCriacao == $today ){
            		echo '<span class="label label-success"><i class="fa fa-paw"></i></span>';
            	}
            	
            	if( $_POST['post']['likes'] >= 5 ){
            	echo '<span class="label label-primary"><i class="fa fa-thumbs-up"></i></span>';
				}
				?>
			</div>
		    <img class="post-img" src="<?php echo $imagem; ?>" alt="Imagem do post!">
		</a>
</div>