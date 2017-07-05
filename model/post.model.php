<?php

//MODEL DE Post
//chama arquivo com as configs do banco
require_once("config.php");

//classe de comentaro para gerenciamento das interações com o banco de dados
class Post extends Banco {

    private $descricao;
    private $imagem;
    private $autorId;
    private $id;

    //função para criação do post
    public function create($infos) {
        $descricao = parent::escapeString($infos['descricao']);
        $autorId = $infos['autorId'];
        $imagem  = $infos['imagem'];
        $id = $infos['postId'];
        $ext = $infos['ext'];
        $sql = "INSERT INTO `posts` (`id`, `descricao`, `imagem`, `autorId`,`ext`) VALUES ('$id', '$descricao', '$imagem', '$autorId','$ext')";
        return parent::executaQuery($sql);
    }

    //função para criação do post
    public function update($infos) {
        $descricao = parent::escapeString($infos['descricao']);
        $ext = $infos['ext'];
        $imagem  = $infos['imagem'];
        $id = $infos['postId'];
        $sql = "update `posts` SET `descricao` = '$descricao', `imagem` = '$imagem', `ext` = '$ext' WHERE `id` = '$id'";
        return parent::executaQuery($sql);
    }

    //função para criação do post
    public function lista($limit = 15 ,$page = 1, $order = "DESC", $filtro = "default"){
        $offset = ($page - 1)  * $limit;
        $sql = "";
        $campos = "`id`, `imagem`, `ext`, `likes`, `dataCriacao`";
        $filtroString = "`bloqueado` = 0 ";
        $oderBy = "ORDER BY `dataCriacao` $order";
        if($filtro != "default" ){
            if( isset($filtro['data']) ){
                $campo = "`dataCriacao`";
                $data = explode("GMT", $filtro['data']);
                #echo $data[0]."\n";
                date_default_timezone_set('UTC');
                $data = date("Y-m-d", strtotime($data[0]));
                #echo $data;
                #echo "\n";
                $filtroString .= "AND $campo LIKE '%$data%' ";
                $oderBy = "";
            }
            if( isset($filtro['lista']) && $filtro['lista'] == "user" ){
                $campo = "`autorId`";
                $uid = $filtro['uid'];
                $filtroString .= "AND $campo = $uid";
            }
            if( isset($filtro['desc']) ){
                $campo = "`descricao`";
                $desc = parent::escapeString($filtro['desc']);
                $filtroString .= "AND $campo LIKE '%$desc%'";
             }
        }
        if( $page == 1){
            $sql = "SELECT $campos 
                    FROM `posts` 
                    WHERE $filtroString
                    $oderBy
                    LIMIT $limit";    
        }else{
            $sql = "SELECT $campos
                    FROM `posts` 
                    WHERE $filtroString
                    $oderBy
                    LIMIT $limit OFFSET $offset";
        }
        #print_r($sql);
        #exit;
        $result = parent::executaQuery($sql);
        $x = 0;
        $retorno = array();
        while ( $row = mysqli_fetch_assoc( $result ) ){
            $retorno[$x] = $row;
            $x++;
        }
        return $retorno;
    }

    //pega um usuario com base no id
    public function get($id){ 
        $sql = "SELECT `descricao`, `imagem`, `autorId`, `dataCriacao`, `ext`, `denuncias`, `likes` 
                FROM `posts` 
                WHERE `id` = '$id'";
        $result = parent::executaQuery($sql);
        $row = mysqli_fetch_object ( $result );
        return $row;
    }

    //função para deletar TODOS os post do usuario
    public function delete($id) {
        $sql = "delete from `posts` where `autorId` = '$id'"; 
        return parent::executaQuery($sql);
    }

    //função para deletar UM post
     public function deletePost($id) {
        $sql = "delete from `posts` where `id` = '$id'"; 
        return parent::executaQuery($sql);
    }

    //função para criação do post
    public function block($id) {
        $sql = "update `posts` SET `bloqueado` = 1 WHERE `id` = '$id'";
        return parent::executaQuery($sql);
    }

    //função para denuncia do post
    public function complaint($id,$complaints) {
        $sql = "update `posts` SET `denuncias` = '$complaints' WHERE `id` = '$id'";
        return parent::executaQuery($sql);
    }

    //função para denuncia do post
    public function like($id,$likes) {
        $sql = "update `posts` SET `likes` = '$likes' WHERE `id` = '$id'";
        return parent::executaQuery($sql);
    }


    public function countPosts(){
        $sql = "SELECT COUNT(*) as total FROM `posts`";
        return mysqli_fetch_object ( parent::executaQuery($sql) );
    }


    public function getAll(){
        $sql = "select `dataCriacao`, `id` from `posts`"; 
        $result = parent::executaQuery($sql);
        $x = 0;
        $retorno = array();
        while ( $row = mysqli_fetch_assoc( $result ) ){
            $retorno[$x] = $row;
            $x++;
        }
        return $retorno;
    }

    //pega os valores do post
    public function getDescricao() {
        return $this->descricao;
    }

    public function getImagen() {
        return $this->imagem;
    }

    public function isAutorId() {
        return $this->autorId;
    }

}
