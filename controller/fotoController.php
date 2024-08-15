<?php
require_once 'model/Foto.php';

class fotoController{

    public static function salvar($fotoAtual = '', $fotoTipo=''){

        $foto = new Foto();

        $imagem = array();
        if(is_uploaded_file($_FILES['foto']['tmp_name'])){
            $imagem['data'] = file_get_contents($_FILES['foto']['tmp_name']);
            $imagem['tipo'] = $_FILES['foto']['type'];
            $path = 'imagens/'.$_FILES['foto']['name'];
            $imagem['path'] = $path;

            move_uploaded_file($_FILES['foto']['tmp_name'],$path);
        }
        
        if(!empty($imagem)){
            $foto->setFoto($imagem['data']);
            $foto->setFotoTipo($imagem['tipo']);
            $foto->setPath($imagem['path']);

            if(!empty($_POST['path']))
                unlink($_POST['path']);
           
        }else{
            $foto->setFoto($fotoAtual);
            $foto->setFotoTipo($fotoTipo);
            $foto->setPath($_POST['path']);
        }

        $foto->setId($_POST['id']);

        $foto->save();
    }
    
    public static function listar(){
        $fotos = new Foto();
        return $fotos->listAll();
    }

    public static function editar($id){
        $foto = new Foto();

        $foto = $foto->find($id);

        return $foto;
    }

    public static function excluir($id){
        $foto = new Foto();
        $foto = $foto->remove($id);
    }

    public static function logar(){
        $foto = new Foto();
        $foto->setLogin($_POST['login']);
        $foto->setSenha($_POST['senha']);
        return $foto->logar();
    }
}

?>