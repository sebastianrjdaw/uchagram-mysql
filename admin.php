<?php
/*
Título: Uchagram-usuarios-SQL
Autor: Sebastián Rodŕiguez Jiménez
Data modificación: 19/01/202
Versión 1.0 #
*/

session_start();
include('DAO.php');
DAO::conectar();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);




//Gestion de Usuarios

if(isset($_GET['eliminarU'])){
    $filaEliminar=$_GET['eliminarU'];      //Posicion en el array de usuarios del user que queremos borrar
    $usuarios=DAO::lerUsuarios();        //Obtener todos los usuarios
    $codigo= $usuarios[$filaEliminar]->getCodigo();   //filtrar el usuario en la posicion y obtener su codigo
    DAO::borrar($codigo);
}





if(isset($_POST['add'])){
  $rol = $_POST['rol'][0];
  $username=$_POST['username'];
  $haspassword=crypt($_POST['password'],'ripemd160');
  $email = $_POST['email'];
  $usuario = new Usuario();
  $usuario->Crear($rol, $username, $haspassword, $email);
  DAO::gardarUsuario($usuario);
}






?>



<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Administracion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link
      rel="stylesheet"
      type="text/css"
      media="screen"
      href="css/usuarios.css"
    />
  </head>
  <body>
      <h2>GESTION DE USUARIOS</h2>
      <div class="form-body">
      <form action="admin.php" method="post" id="registro">
        <input type="text" name="username" placeholder="Nombre de Usuario" />
        <input type="password" name="password" placeholder="Introduce Contraseña" />
        <input type="email" name="email" placeholder="Introduce Email" />

        <select name="rol[]" class="option-select">
          <option value="admin" <?php if (isset($_POST['rol']) && (in_array("admin", $_POST['rol'])))
                              echo "selected";
                            ?>>admin</option>
          <option value="user" <?php if (isset($_POST['rol']) && (in_array("user", $_POST['rol'])))
                              echo "selected";
                            ?>>client</option>
        </select>                    
        <button class="boton" type="sumbit" name="add">AÑADIR</button>
      </form>
      </div>  
      <div class="lista-users">
        <table>
          <tr>
            <th>CODIGO</th>
            <th>USERNAME</th>
            <th>CONTRASEÑA</th>
            <th>EMAIL</th>
            <th>ROL</th>
            <th> X </th>
          </tr>
          <?php
          $contEliminar = 0;
          $contModificar = 0;
          $usuarios = DAO::lerUsuarios();
          foreach ($usuarios as $usuario) {
            ?>
          <tr>
            <td><?php echo $usuario->getCodigo(); ?></td>
            <td><?php echo $usuario->getUsername(); ?></td>
            <td><?php echo $usuario->getHashpassword(); ?></td>
            <td><?php echo $usuario->getEmail(); ?></td>
            <td><?php echo $usuario->getRol(); ?></td>
            <td><a href="admin.php?eliminarU=<?php echo $contEliminar++; ?>">Eliminar</a> /  <a href="modificar.php?id=<?php echo $usuario->getCodigo(); ?>">Modificar</a></td>     
          </tr>
          <?php } ?>
        </table>

      </div>
      <div class="back-button">
        <button
          class="boton"
          id="salir"
          role="link"
          onclick="window.location='index.php'"
        >
          ATRAS
        </button>
      </div>
      
  </body>
</html>