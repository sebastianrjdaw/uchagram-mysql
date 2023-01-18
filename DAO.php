<?php

require_once("usuario.class.php");
//hola

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
            $stmt->bindParam(":rol", $usuario->getRol());
            $stmt->bindParam(":usuario", $usuario->getUsername());
            $stmt->bindParam(":hashContrasinal", $usuario->getPassword());
            $stmt->bindParam(":email", $usuario->getEmail());
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    }
}
?>