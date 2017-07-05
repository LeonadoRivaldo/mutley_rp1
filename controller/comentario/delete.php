<?php
//CONTROLLER QUE BUSCA COMENTARIOS COM BASE NO ID DO POST
//chama o a classe de interação com o banco
//chama o a classe de interação com o banco
require_once("../../model/comentario.model.php");
//chama class de validação
require_once("../validacao.php");
$ret = [];
//validação
$validacao = new Validacao();
//valida se o usuario está logado!
$ret = $validacao->isAuth();
if( $ret['erro'] == 9 ){
	echo json_encode($ret);
	exit;
}

//valida se os dados não estão em branco
$ret = $validacao->camposEmBranco($_POST);
if( $ret['erro'] == 10 ){
	echo json_encode($ret);
	exit;
}

//contrução
$comentario = new Comentario();
$result = $comentario->excluir($_POST['comentarioId']);
if( $result ){
	$ret['erro'] = 0;
	$ret['msg'] = 'Comentario apagado';
}else{
	$ret['erro'] = 1;
	$ret['msg'] = 'Algum erro ocorreu tente novamente ou entre em contato com o suporte!';
}

//retorno
echo json_encode($ret);