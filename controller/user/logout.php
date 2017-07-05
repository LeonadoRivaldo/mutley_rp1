<?php
//CONTROLLER DE LOGOUT
//chama class de validação
require_once("../validacao.php");
$ret = [];
$validacao = new Validacao();
//valida se o usuario está logado!



$ret = $validacao->isAuth();
if( $ret['erro'] == 9 ){
	echo json_encode($ret);
	exit;
}
$_SESSION = array();
$logout = session_destroy();

if( $logout ){
	$ret['erro'] = 0;
	$ret['msg'] = "Usuario deslogado";
}else{
	$ret['erro'] = 1;
	$ret['msg'] = "Oops, parece que algo está errado! Tente novamente";
}
echo json_encode($ret);