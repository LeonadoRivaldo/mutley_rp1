<?php
//CONTROLLER DE BUSCAR USUARIOS
require_once("../../model/post.model.php");
//chama o model de usuario
require_once("../../model/user.model.php");
//chama o a classe de interação com o banco
require_once("../../model/comentario.model.php");
//chama class de validaçãos
require_once("../validacao.php");
//validação
$ret = [];
$validacao = new Validacao();
//valida se o usuario está logado!
$ret = $validacao->isAuth();
if( $ret['erro'] == 9 ){
	echo json_encode($ret);
	exit;
}
//contrução
$ret = $validacao->validUser($_POST['uid']);
if($ret['erro'] == 0){
	$user = new User();
	$posts = new Post();
	$comentario = new Comentario();
	$result = $user->deleteUser($_SESSION['user_id']);
	$deletePosts = $posts->delete($_SESSION['user_id']);
	$deleteComentarios = $comentario->excluirByUser($_SESSION['user_id']);

	if( $result  ){
		$ret['erro'] = 0;
		$ret['msg'] = 'Usuario removido com sucesso';
		$_SESSION = array();
		$logout = session_destroy();
	}else{
		$ret['erro'] = 1;
		$ret['msg'] = 'Algum erro ocorreu tente novamente ou entre em contato com o suporte!';
	}

}

//retorno
echo json_encode($ret);