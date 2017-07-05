<?php
/*
	classe de conexão com o banco, executas as consultas no banco de dados
*/
class Banco{
private $db  = "mutley";
private $user = "mutley";
private $pass = "HSpZBoMjAVj5";
private $host = "mutley.mysql.dbaas.com.br";
	/**
	* @nome: executaQuery
	* @var: $sql = query string para consulta no banco
	* @desc: excutar um query junto ao banco de dados
	* @return: true/false = para insert/delete 
	* @return: rows/row para update ou select com as linhas  
	*  a fetadas
	*/
	public function executaQuery($sql){
		$mysqli = new mysqli($this->host, $this->user, $this->pass, $this->db);
		if ($mysqli->connect_errno) {
			echo "hie";
			echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
			die();
		}

		$ret = array('erro' => 15 , 'msg' => 'contate o suporte' );
		//$erro = "<div align='center'><h1 style='color:red'>".$mysqli->error."</h1></div>";
		$result = $mysqli->query($sql) or die( "<div align='center'><h1 style='color:red'>".$mysqli->error."</h1></div>" );
		$mysqli->close();
		return $result;
	}



	public function escapeString($string){
		$mysqli = new mysqli($this->host, $this->user, $this->pass, $this->db);
		if ($mysqli->connect_errno) {
			echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
			die();
		}
		$string = $mysqli->real_escape_string($string);
		$mysqli->close();
		return $string;
	}


}