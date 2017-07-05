<?php 
//chama o model de post
require_once("../../model/post.model.php");
//chama class de validaçãos
require_once("../validacao.php");
//variaveis
$ret = array();
$validacao = new Validacao();
$page = $_POST['page'];
$limit = $_POST['limite'];
if( isset($_POST['order']) &&  $_POST['order'] != 'default' ){
	$order = $_POST['order'];
}else{
	$order = "DESC";
}
$post = new Post();


$filtro = "default";
$lista = "default";
if( isset($_POST['data']) || isset($_POST['lista']) || isset($_POST['desc']) ){
	$filtro = [];
}
if( isset($_POST['data']) ){
	$filtro['data'] = $_POST['data'];
}
if( isset($_POST['lista']) && $_POST['lista'] == "user"  ){
	//valida se o usuario está logado!
	$ret = $validacao->isAuth();
	if( $ret['erro'] == 9 ){
		echo json_encode($ret);
		exit;
	}
	$filtro['lista'] = $_POST['lista'];
	$filtro['uid'] = $_SESSION["user_id"];
}
if( isset($_POST['desc']) ){
	$filtro['desc'] = $_POST['desc'];
}

$count = $post->countPosts();
$MAX_PAGE = (int) $count->total / $limit;
$MAX_PAGE++;
if( $page <= $MAX_PAGE ){
	$result = $post->lista($limit,$page,$order,$filtro);
	if( $result != null ){
		$ret['posts'] = $result;
		$ret['erro'] = 0;
	}else{
		$ret['erro'] = 1;
		$ret['msg'] = "Nenhum post foi encontrado!";
	}

}else{
	$ret['erro'] = 16;
	$ret['msg'] = "não existem mais posts a serem mostrados";
}

//
echo json_encode($ret);
