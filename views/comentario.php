<?php
class Comment{
	
	function cometarioHtml($infos){
	session_start();
	$index = $infos['index'];
	$texto     = $infos['texto'];
    $NomeAutor = $infos['userName'];
    date_default_timezone_set('America/Sao_Paulo');
    $data = date('d/m/Y \a\s g:i a', strtotime($infos['dataCriacao']));

	$html = '<div class="comentario_'.$index.'"><div class="well well-sm comentario">';
	$html .= $texto;
	$html .= '<small class="pull-right" id="comment-autor">';
	$html .= 'Por: '.$NomeAutor.' em'. $data;
	$html .= '</small>';
	if( isset($_SESSION['user_id']) ){
    	if($_SESSION['user_id'] == $infos['autorId'] ){ 
           $html .= '<i onClick="deletaComentario(this)" data-index="'.$index.'" data-cid="'.$infos['comentarioId'].'" class="fa fa-trash" ></i>';
        }
    }
	$html .= '</div></div>';
	return $html;
	}

}

$comment = new Comment();
if (isset($_POST) && count($_POST) >= 1 && isset($_POST['load'])) {
	echo $comment->cometarioHtml($_POST);
}




