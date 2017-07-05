<?php
//CONTROLLER QUE BUSCA COMENTARIOS COM BASE NO ID DO POST
//chama o a classe de interação com o banco
require_once("../../model/comentario.model.php");
//chama class de validação
require_once("../validacao.php");
session_start();
//validação
$validacao = new Validacao();
//valida se os dados não estão em branco
$ret = $validacao->camposEmBranco($_POST);
if( $ret->erro == 10 ){
	echo json_encode($ret);
	exit;
}


//contrução
$comentario = new Comentario();
$result = $comentario->lista($_POST['postId']);
if( $result != null ){
	$ret['erro'] = 0;
	$ret['comentarios'] = $result;
}else{
	$ret['erro'] = 1;
	$ret['msg'] = "Não existem comentarios para esse post!";
}

//retorno
echo json_encode($ret);