<?php
	header('Content-type: text/html; charset=utf-8');
	if( !isset($site_title) ){
        $site_title = "Sistema Mutley";
    }
    session_start();
    require_once('./controller/utils/versionamento.php');
    $versao = new versao();
    $manutencao = true;
    if( !isset( $_SESSION['admin'] ) && $manutencao ){
    	echo "<meta http-equiv='refresh' content='0;URL=manutencao.php'>";
    }




?>
<meta charset="utf-8">
<base href="http://localhost/mutley/">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="./public/files/default/favicon.ico" type="image/ico">
<link href="<?php echo $versao->auto_version('./public/css/estilos.css'); ?>" rel="stylesheet" type="text/css" />
 <title><?php echo $site_title; ?></title>
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->