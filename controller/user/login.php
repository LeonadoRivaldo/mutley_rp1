<?php
//CONTORLLER DE LOGIN
//chama o model de usuario
require_once("../../model/user.model.php");
//chama class de validaçãos
require_once("../validacao.php");
$ret =[];
//validação
$validacao = new Validacao();
//teste dos campos
$ret = $validacao->camposEmBranco($_POST);
if( $ret['erro'] == 10 ){
	echo json_encode($ret);
	exit;
}

//valida email
$ret = $validacao->isEmail($_POST['email']);
if( $ret['erro'] == 2 ){
	echo json_encode($ret);
	exit;	
}


//contruindo as variaveis
$senha = $_POST['senha'];
$email = $_POST['email'];
//contrução
$user = new User();
$result = $user->auth($email,$senha);

//testa se o usuario existe

if( $result != null ){

	$ret = $validacao->isBloqueado($result);
	if( $ret['erro'] == 3 ){
		echo json_encode($ret);
		die();
	}


	$lifetime = 3600;

	session_set_cookie_params ($lifetime);
	session_start(); // ready to go!
	$_SESSION['nome'] = $result->nome;
	$_SESSION['email'] = $result->email;
	$_SESSION['user_id'] = $result->id;
	if( $result->id == "1467980245"){
		$_SESSION['admin'] = true;
	}
	$ret['erro'] = 0;
	$ret['msg'] = "Bem vindo ". $result->nome;
	$ret['usuario'] = [];
	$ret['usuario']['nome'] = $result->nome;
	$ret['usuario']['id'] = $result->id;
}else{
	$ret['erro'] = 1;
	$ret['msg'] = "Usuario não encontrado ou não cadastrado";
}

//retorno
echo json_encode($ret);
