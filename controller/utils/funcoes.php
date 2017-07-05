<?php 
 /**
  * class com funções uteis para todo o sistema! 
  */


class Funcoes{

	/**
	 * @var $mes , inteiro de 1 a 12
	 * @return nome do mes em portugues
	 */
	function mesBR($mes){
	$meses = array(
	    1 => 'Janeiro',
	    'Fevereiro',
	    'Março',
	    'Abril',
	    'Maio',
	    'Junho',
	    'Julho',
	    'Agosto',
	    'Setembro',
	    'Outubro',
	    'Novembro',
	    'Dezembro'
	);
		return $meses[$mes]; 
	}


	//funçao para fazer uplaod dos arquivos
	function moveFiles($files,$uploaddir,$postid,$validacao){
	    $cont = 0;
	    $data = array();
	    $error = false;
	    foreach ($files as $file) {
	        $cont++;
	        $filesize = $file["size"];
	        $file_ext = substr($file['name'], strripos($file['name'], '.'));
	        $newname  = $cont . $file_ext;
	        $data = $validacao->tamanhoDeArquivoPermitido($filesize);
	        if( $data['erro'] == 13 ){
	            echo json_encode($data);
	            exit;
	        }
	        $data = $validacao->estensaoPermitida($file_ext);
	        if ( $data['erro'] == 12 ) {
	            echo json_encode($data);
	            exit;
	        }
	                //faz upload da imagem
	        if (move_uploaded_file($file['tmp_name'], $uploaddir . basename($newname))) {
				$error = false;
	        } else {
	            $error = true;
	        }
	    }

	    $data = ($error) ? array('erro' => 1, 'msg' => 'Ouve um erro ao fazer upload do arquivo, contate o suporte!') : array('path' => $uploaddir, 'postId' => $postid, 'erro' => 0, 'ext' => $file_ext);

	    return $data;
	}
}