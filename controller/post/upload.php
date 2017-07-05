<?php
//validação
require_once('../validacao.php');
//funcoes
require_once('../utils/funcoes.php');
//obetos
$funcoes = new Funcoes();
$validacao = new Validacao();
$ret = $validacao->isAuth();
if( $ret['erro'] == 9 ){
    echo json_encode($ret);
    exit;
}




if( !isset($_GET['id']) ) {
    $postid = time();
}else{
    $postid = $_GET['id'];
}


if (isset($_GET['files'])) {

    $files = array();
    $dir   = '../../public/files/posts/' . $postid . '/';
    $uploaddir = $dir;
    //cria diretorio
    if ( !is_dir($dir) ) {
        if(mkdir($dir)){
            $data = $funcoes->moveFiles($_FILES,$uploaddir,$postid,$validacao);
        }
    } else {
      $data =  $funcoes->moveFiles($_FILES,$uploaddir,$postid,$validacao);
      $data['alteracao'] = true;
    }
} else {
    $data = array('erro' => 1, 'msg' => 'Você esqueceu de anexar um arquivo!');
}
//fim
echo json_encode($data);