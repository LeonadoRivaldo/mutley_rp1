<?php
//MODEL DE USUARIO
//chama arquivo com as configs do banco
require_once("config.php");
//classe de usuario para gerenciamento das interações com o banco de dados
class User extends Banco{
	private $nome;
	private $email;
	private $senha;
	private $bloqueado;
	private $lastPostId;
	//contructor function
	/*public function __construct($nome,$email,$senha) {
        $this->nome = $nome;
        $this->senha = $senha;
        $this->email = $email;
    }*/

    //faz autenticação de um usuario que está se logando
    public function auth($email,$senha){
        $senha = md5(parent::escapeString($senha));
        $sql = "SELECT `id`, `nome`, `email`, `bloqueado` 
                FROM `usuarios` 
                where `senha` = '$senha' 
                AND `email` = '$email'";
                
        $result = parent::executaQuery($sql);
        $row = mysqli_fetch_object ( $result );
        return $row;
    }
    //Salva o usuario com base no objeto instanciado
    public function saveUser($nome,$email,$senha){
    	$id = time();
        $nome = parent::escapeString($nome);
        $senha = md5(parent::escapeString($senha));
        $email = parent::escapeString($email);
    	//fazer uma validação para ver se o usuario já não está cad
    	$sql = "insert into `usuarios` ( `id`,`nome`, `email`, `senha` ) values ('$id','$nome', '$email', '$senha')"; 
        return parent::executaQuery($sql);
    }
   	//pega um usuario com base no id
    public function getUser($id){
    	$sql = "select * from `usuarios` where `id` = '$id'";
    	$result = parent::executaQuery($sql);
        $row = mysqli_fetch_object ( $result );
        return $row;
    }
    //deleta o usuario
    public function deleteUser($id){
    	$sql = "delete from `usuarios` where `id` = '$id'"; 
        return parent::executaQuery($sql);
    }
	//Atualiza usuario usando o id como base
    public function update($nome,$email,$id){
        $nome = parent::escapeString($nome);
        $email = parent::escapeString($email);
    	$sql = "UPDATE `usuarios` SET `nome` = '$nome', `email` = '$email' WHERE `id` = '$id'";
        return parent::executaQuery($sql);
    }
    //Atualiza usuario usando o id como base
    public function updateSenha($senha,$id){
        $senha = md5(parent::escapeString($senha));
        $sql = "UPDATE `usuarios` SET `senha` = '$senha' WHERE `id` = '$id'";
        return parent::executaQuery($sql);
    }
    public function lastPost($id,$lastPostId){
        $sql = "UPDATE `usuarios` SET `lastPostId` = '$lastPostId' WHERE `id` = '$id'";
        return parent::executaQuery($sql);
    }



    //função para bloqueio de usuario
    public function block($id){
        $sql = "update `usuarios` SET `bloqueado` = 1 WHERE `id` = '$id'";
        return parent::executaQuery($sql);
    }

    //pega os valores do usuario
    public function getNome(){
    	return $this->nome;
    }
    public function getEmail(){
    	return $this->email;
    }
    public function isBloqueado(){
    	return $this->bloqueado;
    }
    public function getLastPostId(){
    	return $this->lastPostId;
    }
}