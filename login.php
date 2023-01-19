<!DOCTYPE html>
<?php
/*
Título: Uchagram-login 
Autor: Sebastián Rodŕiguez Jiménez
Data modificación: 28/12/2022
Versión 1.0 #
*/
session_start();
?>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Login</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='css/login.css'>
</head>
<body>
   <div class="form-body">
    <img src="img/uchagram.png" alt="logo_uchagram">
    <p class="text">Bienvendo a  dasdasd Uchagram</p>

    <form class="login-form" action="login.php" method="POST">
    <input type='text' name='username' placeholder="Introduce nombre de usuario" value="<?php
     if (isset($_POST['username']))echo $_POST['username'] 
     ?>">
    <input type='password' placeholder="Introduce contraseña" name='password'> 
    <button type="submit" name="Enviar">Iniciar Sesión</button>       
    </form>
   </div> 
</body>
<?php
include('DAO.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


    if (isset($_POST['Enviar'])) {
        DAO::conectar();
       $login= DAO::login($_POST['username'], $_POST['password']);
        if ($login) {
            header('Location: index.php');
        } else {
            echo 'Usuario o Contraseña incorectos';
        }
    }
?>
</html>
