<?php

//CONTROLLER DE ATUALIZAÇÃO DO USUARIO
//chama o model de usuario
require_once("../../model/user.model.php");
//chama class de validaçãos
require_once("../validacao.php");
$ret = [];
//classe de validação
$validacao = new Validacao();
//valida se o usuario está logado!
$ret = $validacao->isAuth();
if ($ret['erro'] == 9) {
    echo json_encode($ret);
    exit;
}
$ret = $validacao->validUser($_POST['uid']);
if ($ret['erro'] == 14) {
    echo json_encode($ret);
    exit;
}
//teste dos campos
#$ret = $validacao->camposEmBranco($_POST);
if ($ret['erro'] == 10) {
    echo json_encode($ret);
    exit;
}

//construção
$user = new User();
if( isset( $_POST['senha'] ) && $_POST['senha'] != ""  ){
    $user->updateSenha($_POST['senha'],$_SESSION['user_id']);
}
$result = $user->update($_POST['nome'], $_POST['email'],$_SESSION['user_id']);
if ($result) {
    $_SESSION["nome"] = $_POST['nome'];
    $ret['erro'] = 0;
    $ret['msg'] = 'Usuario atualizado com sucesso';
} else {
    $ret['erro'] = 1;
    $ret['msg'] = 'Algum erro ocorreu tente novamente ou entre em contato com o suporte!';
}

//retorno
echo json_encode($ret);
