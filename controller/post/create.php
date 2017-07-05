<?php 
//CONTROLLER DE CRIAÇÃO DO USUARIO
//chama o model de post
require_once("../../model/post.model.php");
//chama o model de usuario
require_once("../../model/user.model.php");
//chama class de validaçãos
require_once("../validacao.php");
//variaveis
$ret = array();
$validacao = new Validacao();


//validação

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

$infos = $_POST;
$infos["autorId"] = $_SESSION['user_id'];
$user = new User();
$post = new Post();

if( $post->create($infos) ){
	$ret['erro'] = 0;
	$ret['msg'] = "Post criado com sucesso!";
	$user->lastPost($infos["autorId"],$infos['postId']);
}else{
	$ret['erro'] = 1;
	$ret['msg'] = "o post não foi criado, algum erro ocorreu, tente novamente, ou contate o suporte pelo email: suporte@sitemamutley.com.br";
}

//fim
echo json_encode($ret);