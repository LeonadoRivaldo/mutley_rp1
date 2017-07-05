<?php 
//chama o model de post
require_once("../../model/post.model.php");
//chama class de validaçãos
require_once("../validacao.php");
//variaveis
$ret = array();
$validacao = new Validacao();
//valida campos se não estão em branco
$ret = $validacao->camposEmBranco($_POST);
if( $ret['erro'] == 10 ){
	echo json_encode($ret);
	exit;
}
//verifica login
$ret = $validacao->isAuth();
if( $ret['erro'] == 9 ){
	echo json_encode($ret);
	exit;
}

$ret = $validacao->validUser($_POST['uid']);
if( $ret['erro'] == 0 ){
	$post = new Post();
	$result = $post->update($_POST);
	if( $result ){
		$ret['erro'] = 0;
		$ret['msg'] = "Post atualizado com sucesso!";
	}else{
		$ret['erro'] = 1;
		$ret['msg'] = "O post não foi atualizado com sucesso,contate o suporte!";
	}
}
echo json_encode($ret);
