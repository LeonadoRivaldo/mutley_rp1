<?php
//CONTROLLER DE DELETAR POST ESPECIFICO
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
	$post = new Post();
	$result = $post->deletePost($_POST['postId']);
	if( $result ){
		$ret['erro'] = 0;
		$ret['msg'] = 'Post removido com sucesso';
	}else{
		$ret['erro'] = 1;
		$ret['msg'] = 'Algum erro ocorreu tente novamente ou entre em contato com o suporte!';
	}

}

//retorno
echo json_encode($ret);