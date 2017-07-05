<?php
//CONTROLLER DE BUSCAR USUARIOS
//chama o model de usuario
require_once("../../model/user.model.php");
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
$user = new User();
$result = $user->getUser($_SESSION['user_id']);
if( $result != null ){
	$ret['erro'] = 0;
	$ret['usuario'] = [];
	$ret['usuario']['nome'] = $result->nome;
	$ret['usuario']['email'] = $result->email;
	$ret['usuario']['uid'] = $result->id;
	$ret['usuario']['dataCriacao'] = $result->dataCriacao;
	#$ret['usuario']['senha'] = $result->senha;
}else{
	$ret['erro'] = 1;
	$ret['msg'] = "Usuario não encontrado";
}

//retorno
echo json_encode($ret);