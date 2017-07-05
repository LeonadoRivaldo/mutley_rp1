<?php
require_once("../../model/config.php");
/* classe para criar as funções de validação dos dados */
/**
 * Erros padroes: 
 * 1 é reservado para erros que precisam de atenção do desenvolvedor
 * @return 2 => email invalido
 * @return 3 => usuario bloqueado
 * @return 9 => usuario não autenticado
 * @return 10 => campos em branco
 * @return 11 => email cadastrado
 * @return 12 => extensão de imagem não permitida
 * @return 13 => tamanho do arquivo de imagem não permitida
 * @return 14=> o ID de usuario enviado nao é o mesmo ID da seção
 * @return 15 => erro de banco
 * @return 20 => post && usuario autor bloqueados
 */
class Validacao extends Banco{
	/**
	* @nome: camposEmBranco
	* @var: $campos = array todos os campos de um formulario
	* @desc: função testa se os campos estão em branco
	* @return: erro
	* @return: false = todos os campos estão preenchidos
	*/
	public function camposEmBranco($campos){
		$ret = [];
		$ret['erros'] = 0;
		$ret['msg'] = "Os ";
		foreach ( $_POST as $parametro ) {
			if ($parametro == "" || $parametro == null ) {
				$ret['erros'] += 1;
				$ret['msg'] .= $parametro.', ';
			}
		}
		if($ret['erros']>=1){
			$ret['erro'] = 10;
			$ret['msg'] = "estão em branco";
		}else{
			$ret['erro'] = 0;
		}
		return $ret;
	}

	//TODO: desc
	public function isAuth(){
		$ret = [];
		session_start();
		if( isset($_SESSION['user_id']) ){
			$id = $_SESSION['user_id'];
			$sql = "SELECT `bloqueado` FROM `usuarios` WHERE `id` = '$id'";
			$result = parent::executaQuery($sql);
			$row = mysqli_fetch_object ( $result );
			$ret = $this->isBloqueado($row);
			if( $ret['erro'] != 3 ){
				$ret['erro'] = 0;	
			}else{
				$ret['erro'] = 9;
				$ret['msg'] = 'Usuario não autenticado ou bloqueado';
				$_SESSION = array();
				$logout = session_destroy();
			}
		}else{
			$ret['erro'] = 9;
			$ret['msg'] = 'Usuario não autenticado ou bloqueado';
		}


		return $ret;
	}

	//TODO: desc
	public function isEmail($email){
		$ret = [];
		for($x = 0; $x<strlen($email); $x++){
			if( $email{$x} == "@" ){
				$ret['erro'] = 0;
				return $ret;
			}
		}
		$ret['erro'] = 2;
		$ret['msg'] = "Email invalido";
		return $ret;
	}


	//TODO: desc
	public function emailExists($email){
		$ret = [];
		$sql = "SELECT `email` FROM `usuarios` WHERE `email` = '$email'";
		$result = parent::executaQuery($sql);
		$row = mysqli_fetch_object ( $result );
		if( $row!=null ){
			$ret['erro'] = 11;
			$ret['msg'] = "O email: ".$email." já está cadastrado. Se esse email é seu, tente recuperar a senha com o <a href='/controller/utils/password.php?email=".$email.">link</a>";
		}else{
			$ret['erro'] = 0;
		}
		return $ret;
	}


	//valida se o usuario ta bloqueado
	public function isBloqueado($user){
		if($user->bloqueado){
			$ret['erro'] = 3;
			$ret['msg'] = "Usuário bloqueado";
		}else{
			$ret['erro'] = 0;
		}
		return $ret;		    
		

	}


	//valida estensão das imagens para o post
	public function EstensaoPermitida($ext){
		$data = array();
		$allowed_file_types = array('.png','.jpg');
		if( !in_array($ext,$allowed_file_types) ){
			$data = array('erro' => 12, 'msg' => 'Esse arquivo não possui uma extensão permitida');
		}else{
			$data = array('erro' => 0);	
		}
		return $data;
	}

	//validação do tamanho da imagem para o post maximo 2mb
	public function tamanhoDeArquivoPermitido($size){
		$data = array();
		$MAX_SIZE = 2000000;
		if( $size > $MAX_SIZE ){
			$data = array('erro' => 13, 'msg' => 'O tamanho da imagem é maior que 2mb. Envie uma imagem menor');
		}else{
			$data = array('erro' => 0);
		}
		return $data;
	}

	public function validUser($uid){
		$ret = [];
		if($uid == $_SESSION['user_id']){
			$ret['erro'] = 0;
		}else{
			$ret['erro'] = 14;
			$ret['msg'] = 'Você não tem permissão para realizar essa ação!';
		}
		return $ret;
		
	}


}




