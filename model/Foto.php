<?php

require_once 'Banco.php';
require_once 'Conexao.php';

class Foto extends Banco{

    private $id;
    private $foto;
    private $fotoTipo;
    private $valor;
    private $descrcao;

    //métodos de acesso

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getFoto(){
        return $this->foto;
    }

    public function setFoto($foto){
        $this->foto = $foto;
    }

    public function getFotoTipo(){
        return $this->fotoTipo;
    }

    public function setFotoTipo($fotoTipo){
        $this->fotoTipo = $fotoTipo;
    }

    public function getPath(){
        return $this->path;
    }

    public function setPath($path){
        $this->path = $path;
    }


    public function save() {
        $result = false;
        //cria um objeto do tipo conexao
        $conexao = new Conexao();
        //cria a conexao com o banco de dados
        if($conn = $conexao->getConection()){
            if($this->id > 0){
                //cria query de update passando os atributos que serão atualizados
                $query = "UPDATE foto SET foto = :foto, fotoTipo = :fotoTipo, path = :path WHERE id = :id";
                //Prepara a query para execução
                $stmt = $conn->prepare($query);
                //executa a query
                if ($stmt->execute(
                    array(':foto' => $this->foto, ':fotoTipo' => $this->fotoTipo, ':id' => $this->id, ':path' => $this->path))){
                    $result = $stmt->rowCount();
                }
            }else{
                //cria query de inserção passando os atributos que serão armazenados
                $query = "insert into foto (id,  foto, fotoTipo, path) 
                values (null,:foto, :fotoTipo,:path)";
                //Prepara a query para execução
                $stmt = $conn->prepare($query);
                //executa a query
                if ($stmt->execute(array(':foto' => $this->foto, ':fotoTipo'=>$this->fotoTipo, ':path' => $this->path))) {
                    $result = $stmt->rowCount();
                }
            }
        }
        return $result;
    }

    public function find($id) {

        //cria um objeto do tipo conexao
        $conexao = new Conexao();
        //cria a conexao com o banco de dados
        $conn = $conexao->getConection();
        //cria query de seleção
        $query = "SELECT * FROM foto where id = :id";
        //Prepara a query para execução
        $stmt = $conn->prepare($query);
        //executa a query
        if ($stmt->execute(array(':id'=> $id))) {
            //verifica se houve algum registro encontrado
            if ($stmt->rowCount() > 0) {
                //o resultado da busca será retornado como um objeto da classe
                $result = $stmt->fetchObject(Foto::class);
            }else{
                $result = false;
            }
        }
        return $result;
    }

    public function remove($id) {

        $result = false;
        //cria um objeto do tipo conexao
        $conexao = new Conexao();
        //cria a conexao com o banco de dadosgi
        $conn = $conexao->getConection();
        //cria query de remoção
        $query = "DELETE FROM foto where id = :id";
        //Prepara a query para execução
        $stmt = $conn->prepare($query);
        //executa a query
        if ($stmt->execute(array(':id'=> $id))) {
            $result = true;
        }
        return $result;
    }

    public function count() {
        //cria um objeto do tipo conexao
        $conexao = new Conexao();
        //cria a conexao com o banco de dados
        $conn = $conexao->getConection();
        //cria query de seleção
        $query = "SELECT count(*) FROM foto";
        //Prepara a query para execução
        $stmt = $conn->prepare($query);
        $count = $stmt->execute();
        if (isset($count) && !empty($count)) {
            return $count;
        }
        return false;
    }

    public function listAll() {

        //cria um objeto do tipo conexao
        $conexao = new Conexao();
        //cria a conexao com o banco de dados
        $conn = $conexao->getConection();
        //cria query de seleção
        $query = "SELECT * FROM foto";
        //Prepara a query para execução
        $stmt = $conn->prepare($query);
        //Cria um array para receber o resultado da seleção
        $result = array();
        //executa a query
        if ($stmt->execute()) {
            //o resultado da busca será retornado como um objeto da classe
            while ($rs = $stmt->fetchObject(Foto::class)) {
                //armazena esse objeto em uma posição do vetor
                $result[] = $rs;
            }
        }else{
            $result = false;
        }

        return $result;
    }
  
}

?>