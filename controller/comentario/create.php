<?php
//CONTROLLER DE CRIAÇÃO DE COMENTARIOS
//chama o a classe de interação com o banco
require_once("../../model/comentario.model.php");
//chama class de validação
require_once("../validacao.php");
$ret = [];
//classe de validação
$validacao = new Validacao();

//valida se o usuario está logado!
$ret = $validacao->isAuth();
if( $ret['erro'] == 9 ){
	echo json_encode($ret);
	exit;
}


//construção do comentario
$comentario = new Comentario();
$result = $comentario->create($_POST['texto'],$_POST['postId'],$_SESSION['user_id'],$_SESSION['nome']);
if( $result != 0  ){
	$ret['erro'] = 0;
	$ret['comentarioId'] = $result;
	$ret['msg'] = 'Comentario criado';
}else{
	$ret['erro'] = 1;
	$ret['msg'] = 'Algum erro ocorreu tente novamente ou entre em contato com o suporte!';
}

//retorno
echo json_encode($ret);