<?php
//chama o model de usuario
require_once("../../model/user.model.php");
//chama o model de post
require_once("../../model/post.model.php");
//chama class de validaçãos
require_once("../validacao.php");
//variaveis
$ret = array();
$post = new Post();
$user = new User();
$validacao = new Validacao();


if( $_POST['action'] == "like" ){
	$result = $post->like($_POST['postId'],$_POST['likes']);
	if( $result ){
		$ret['erro'] = 0;
		$ret['msg'] = "liked!";
	}else{
		$ret['erro'] = 1;
		$ret['msg'] = "cagadinha!";
	}
}else if( $_POST['action'] == "complaint" ){
	//verifica login
	$ret = $validacao->isAuth();
	if( $ret['erro'] == 9 ){
		echo json_encode($ret);
		exit;
	}

	$result = $post->complaint($_POST['postId'],$_POST['complaints']);
	if( $result ){
		$ret['erro'] = 0;
		$ret['msg'] = "denunciado";
		if( $_POST['complaints'] >= 10 ){
			$ret['postBlock'] = $post->block($_POST['postId']);
			$ret['userBlock'] = $user->block($_POST['uid']);
			if( $ret['postBlock'] && $ret['userBlock'] ){
				$ret['erro'] = 20;
				$ret['msg'] = "Obrigado por ajudar a manter a integridade do site! tanto a publicação quanto o autor estão bloqueados até verificação pelo suporte!";
			}else{
				$ret['erro'] = 1;
				$ret['msg'] = "Usuario ou post não existem!";		
			}
		}
	}else{
		$ret['erro'] = 1;
		$ret['msg'] = "Alguma coisa não está certa, por favor, contate o suporte, suporte@sistemamutley.com.br";
	}
}



echo json_encode($ret);