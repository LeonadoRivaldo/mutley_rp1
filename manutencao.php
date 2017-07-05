<!DOCTYPE html>
  <html lang="pt-BR">
    <head>
<?php
  header('Content-type: text/html; charset=utf-8');
  if( !isset($site_title) ){
        $site_title = "Sistema Mutley";
    }
    session_start();
    require_once('./controller/utils/versionamento.php');
    $versao = new versao();
    if( isset($_SESSION['admin']) ){
      echo "<meta http-equiv='refresh' content='0;URL=index.php'>";
    }
?>
<meta charset="utf-8">
<base href="http://sistemamutley.com.br/">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="./public/files/default/favicon.ico" type="image/ico">
<link href="<?php echo $versao->auto_version('./public/css/estilos.css'); ?>" rel="stylesheet" type="text/css" />
 <title><?php echo $site_title; ?></title>
    </head>
    <body>
    <?php
      //topo
      include "./views/inc/topo.inc.php"; 
      //TEMPORARIO
      //conteudo
      echo "<div class='container'><div class='row'><div class='col-xs-12'><h3>Nossa pagina está em manutenção, se você tiver login de adminstrador, bastar entrar no sistema!</h3></div></div></div>";
      //rodape
      include "./views/inc/rodape.inc.php"; 
    ?>
    </body>
    <?php
      //rodape
      include "./views/inc/files.inc.php"; 
    ?>
  </html>