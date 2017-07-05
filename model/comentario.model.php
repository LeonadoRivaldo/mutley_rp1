<?php
//MODEL DE COMENTARIO
//chama arquivo com as configs do banco
require_once("config.php");
//classe de comentaro para gerenciamento das interações com o banco de dados
class Comentario extends Banco{
	
	private $texto;
	private $postId;
	private $userId;

	public function __construct(){}
	//cria comentario
	public function create($texto,$postId,$user_id,$userName){
        $texto = parent::escapeString($texto);
        $postId = parent::escapeString($postId);
    	$id = time();
    	$sql = "INSERT into `comentarios` ( `id`,`texto`, `postId`, `userId`, `userName` ) 
                VALUES ('$id','$texto','$postId','$user_id', '$userName')"; 
    	if ( parent::executaQuery($sql) ){
    		return $id;	
    	}else{
    		return 0;
    	}
    }
    //lista todos os comentarios de um post
    public function lista($postId){
    	$sql = "SELECT `userName` as autorName, `texto`, `dataCriacao`, `userId` as autorId, `id`
                FROM `comentarios` 
                WHERE `postId` = '$postId'";
    	$result = parent::executaQuery($sql);
    	$x = 0;
    	$retorno = array();
    	while ( $row = mysqli_fetch_assoc( $result ) ){
    		$retorno[$x] = $row;
    		$x++;
    	}
        return $retorno;
    }

    //exclui um comentario
    public function excluir($id){
    	$sql = "delete from `comentarios` where `id` = '$id'";
    	$result = parent::executaQuery($sql);
        return $result;
    }
    //exclui um comentario
    public function excluirByUser($id){
        $sql = "delete from `comentarios` where `userId` = '$id'";
        $result = parent::executaQuery($sql);
        return $result;
    }


}