<!DOCTYPE html>
<?php
/*
Título: Uchagram-login 
Autor: Sebastián Rodŕiguez Jiménez
Data modificación: 17/11/2022
Versión 1.0 #
*/

?>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Registro</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='css/login.css'>
</head>
<body>
   <div class="form-body">
    <img src="uchagram.png" alt="logo_uchagram">
    <p class="text">Registro Uchagram</p>
    <form class="login-form" action="registro_a.php" method="POST">
    <input type='text' name='username' placeholder="Elige nombre de Usuario">
    <input type='email' placeholder="Introduce un email" name='email'>
    <input type='password' placeholder="Introduce una Contraseña" name='password'> 
    <input type='password' placeholder="Verifica Contraseña" name='v_password'>

    <button type="Submit" name="resgistrar">Registrar</button>       
    </form>
   </div> 
</body>
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include("DAO.php");

 if(isset($_POST['resgistrar'])){
    DAO::conectar();
    if(!empty($_POST['username'])){$username=$_POST['username'];}
    if(!empty($_POST['email'])){$email=$_POST['email'];}
    if(!empty($_POST['password'])&&(!empty($_POST['v_password']))&&($_POST['password']==$_POST['v_password'])){
        $haspassword=crypt($_POST['password'],'ripemd160');
    }
    
    $usuario = new Usuario();
    $usuario->Crear('user', $username, $haspassword, $email);
    DAO::gardarUsuario($usuario);
    header('Location: login.php');
} 

?>
</html>
