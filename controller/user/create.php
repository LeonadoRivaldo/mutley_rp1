<?php
//CONTROLLER DE CRIAÇÃO DO USUARIO
//chama o model de usuario
require_once("../../model/user.model.php");
//chama class de validaçãos
require_once("../validacao.php");
//variaveis
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
$ret = $validacao->emailExists($_POST['email']);
if( $ret['erro'] == 11 ){
	echo json_encode($ret);
	exit;	
}

//contruindo as variaveis
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];
//contrução do objeto usuario
$user = new User();
//salvar no banco de dados
if( $user->saveUser($nome,$email,$senha) ){
	$ret['erro'] = 0;
	$ret['msg'] = "usuario criado com sucesso";

$result = $user->auth($email,$senha);
if( $result != null ){
	$lifetime = 3600;
	session_set_cookie_params ($lifetime);
	session_start(); // ready to go!
	$_SESSION['nome'] = $result->nome;
	$_SESSION['email'] = $result->email;
	$_SESSION['user_id'] = $result->id;
	$ret['erro'] = 0;
	$ret['msg'] = "Bem vindo ". $result->nome;
	$ret['usuario'] = [];
	$ret['usuario']['nome'] = $result->nome;
	$ret['usuario']['id'] = $result->id;
}
}else{
	$ret['erro'] = 1;
	$ret['msg'] = "Não foi possivel criar um usuario!";	
}


//retorno
echo json_encode($ret);
