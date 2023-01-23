<?php

require_once("usuario.class.php");
require_once("publicacion.class.php");



class DAO {
    private static $pdo;    

    public static function conectar() {
        self::$pdo = new PDO('mysql:host=localhost;dbname=uchagram', 'phpmyadmin', '1234');
        self::$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function lerUsuarios() {
        try {
            $stmt = self::$pdo->prepare("SELECT * FROM usuarios");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, "Usuario");
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    }

    public static function lerModificado($codigoUsuario)
    {
        try {
            $stmt = self::$pdo->prepare("SELECT * FROM usuarios WHERE codigo=:codigoUsuario");
            $stmt->bindParam(":codigoUsuario", $codigoUsuario);
            $stmt->execute();
            return $stmt->fetchObject("Usuario"); //Obtener solo un objeto
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }

    }

    public static function borrar($codigoUsuario) {
        try {
            $stmt = self::$pdo->prepare("DELETE FROM usuarios WHERE codigo = :codigo");
            $stmt->bindParam(":codigo", $codigoUsuario);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    }

    public static function gardarUsuario($usuario) {
        try {
            $stmt = self::$pdo->prepare("INSERT INTO usuarios (rol, username, hashpassword, email) VALUES (:rol, :usuario, :hashContrasinal, :email)");
            $stmt->bindValue(":rol", $usuario->getRol());       //bindValue para tomar la variable de la clase usuario 
            $stmt->bindValue(":usuario", $usuario->getUsername());
            $stmt->bindValue(":hashContrasinal", $usuario->getHashpassword());
            $stmt->bindValue(":email", $usuario->getEmail());
            $stmt->execute();

        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    }

    public static function modificarUsuario($usuario) {
        try {
            $stmt = self::$pdo->prepare("UPDATE usuarios SET username = :username, hashpassword = :hashpassword, email = :email WHERE codigo = :codigo");
            $stmt->bindParam(":username", $usuario->usuario);
            $stmt->bindParam(":hashpassword", $usuario->hashContrasinal);
            $stmt->bindParam(":email", $usuario->email);
            $stmt->bindParam(":codigo", $usuario->codigo);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    }



    //Funcion de inicio de sesion para login.php
    public static function login($usuario, $password) {
        $stmt = self::$pdo->prepare("SELECT * FROM usuarios WHERE username = :usuario");
        $stmt->bindValue(":usuario", $usuario);
        $stmt->execute();
        $result = $stmt->fetchObject('Usuario');
        if($result) {
            if (hash_equals($result->getHashpassword(), crypt($password, $result->getHashpassword()))) { //Primero codifica la contraseña de input con el hash de la BD y luego las compara
                $_SESSION['rol'] = $result->getRol();
                return true;
            }
        }
        return false;
    }


    //Gestion de Publicaciones

    public static function lerPublicaciones() {
        try {
            $stmt = self::$pdo->prepare("SELECT * FROM publicaciones");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, "Publicacion");
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    }


    public static function gardarPublicacion($publicacion) {
        try {
            $stmt = self::$pdo->prepare("INSERT INTO publicaciones (codigo, titulo, texto, multimedia, dataPublicacion, codUsuario) VALUES (:codigo, :titulo, :texto, :multimedia, :dataPublicacion, :codUsuario)");
            $stmt->bindValue(":codigo", $publicacion->getCodigo());       //bindValue para tomar la variable de la clase publicacion
            $stmt->bindValue(":titulo", $publicacion->getTitulo());       
            $stmt->bindValue(":texto", $publicacion->getTexto());       
            $stmt->bindValue(":multimedia", $publicacion->getMultimedia());       
            $stmt->bindValue(":dataPublicacion", $publicacion->getDataPublicacion());       
            $stmt->bindValue(":codUsuario", $publicacion->getCodUsuario());       

            
            $stmt->execute();

        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    }


    public static function borrarPublicacion($codigoPublicacion) {
        try {
            $stmt = self::$pdo->prepare("DELETE FROM publicaciones WHERE codigo = :codigo");
            $stmt->bindParam(":codigo", $codigoPublicacion);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    }


}


?>