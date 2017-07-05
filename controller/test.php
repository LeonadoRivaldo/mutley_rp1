<?php
require_once 'envia_mail.php';

$enviaEmal = new Email();

$assunto = 'TESTE BONITO';
$mensagem = 'MENSAGEM FEIA';
$destinatarios = [];
$destinatarios[0]['nome'] = "cascadasdsfda";
$destinatarios[0]['email'] = "leonardo.rivaldo@gmail.com";
$enviaEmal->setSmtp('contato@sistemamutley.com.br', 'contatomutley');
$enviado = $enviaEmal->send($destinatarios, $mensagem, $assunto);

if( $enviado ){
	echo "email enviado";
}else{
	echo "ixo!";
}
