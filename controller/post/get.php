<?php 
//CONTROLLER DE busca de posts
//chama o model de usuario
require_once("../../model/user.model.php");
//chama o model de post
require_once("../../model/post.model.php");
//chama o model de comentario
require_once("../../model/comentario.model.php");


//chama class de validaçãos
require_once("../validacao.php");

$ret = [];
//classe de validação
$validacao = new Validacao();

$post = new Post();
$user = new User();
$comentario = new Comentario();

$result = $post->get($_POST['postId']);


if( $result != null ){
	$ret['erro'] = 0;
	$ret['post'] = $result;
	$comentarios = $comentario->lista($_POST['postId']);
	if( $comentarios != null ){
		$ret['comentarios'] = $comentarios;
	}else{
		$ret['comentarios'] = 0;
	}

	$result = $user->getUser($ret['post']->autorId);
	if( $result != null ){
		$ret['autor'] = [];
		$ret['autor']['id'] =  $result->id;
		$ret['autor']['nome'] = $result->nome;
		$ret['autor']['cadastrado'] = $result->dataCriacao;
		$ret['autor']['email'] = $result->email;
	}else{
		$ret['autor'] = 0;
	}	
	
	
}else{
	$ret['erro'] = 1;
 	$ret['msg'] = 'post não encontrado';
}

echo json_encode($ret);



