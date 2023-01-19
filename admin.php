<?php
/*
Título: Uchagram-usuarios-SQL
Autor: Sebastián Rodŕiguez Jiménez
Data modificación: 19/01/202
Versión 1.0 #
*/

session_start();
include('DAO.php');




//Gestion de Usuarios

if(isset($_GET['eliminar'])){
    $filaEliminar=$_GET['eliminar'];
    unset($datos[$filaEliminar]);
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
escribirUsuarios($datos);


//Gestion de Publicaciones
$datos2 = obtenerPublicaciones();
if (isset($_GET['eliminar2'])) {
  $filaEliminar2 = $_GET['eliminar2'];
  unset($datos2[$filaEliminar2]);
}

//Vista de Publicaciones
if (isset($_GET['ver'])) {
  $filaVer = $_GET['ver'];
  $cod = $filaVer[0];
  setcookie('Codigo', $cod);
  var_dump($filaVer);
  var_dump($cod);
   header('Location: publicacion.php');
}

escribirPublicaciones($datos2);




?>



<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Administracion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- <link rel="stylesheet" type="text/css" media="screen" href="main.css" /> -->
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
      <form action="usuarios.php" method="post" id="registro">
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
            $contFila=0;
            foreach($datos as $usuario) {
          ?>
          <tr>
            <td><?php ?></td>
            <td><?php ?></td>
            <td><?php ?></td>
            <td><?php ?></td>
            <td><a href="usuarios.php?eliminar=<?php echo $contFila++; ?>">Eliminar</a></td>     
          </tr>
          <?php } ?>
        </table>

        <h2>GESTION DE PUBLICACIONES</h2>

        <table>
          <tr>
            <th>CODIGO</th>
            <th>TITULO</th>
            <th>DATA</th>
            <th>PUBLICADO</th>
            <th>OPERACION</th>
          </tr>
          <?php
          $datos2 = obtenerPublicaciones();
          $contFila2=0;
          $ver = 0;
            foreach($datos2 as $publicacion) {
          ?>
          <tr>
            <td><?php echo $publicacion->getCodigo()?></td>
            <td><?php echo $publicacion->getTitulo()?></td>
            <td><?php $hora = $publicacion->getDataPublicacion(); echo date("d-m-Y",$hora);?></td>
            <td><?php var_dump($publicacion->publicado($hora)) ; ?></td>
            <td><a href="usuarios.php?eliminar2=<?php echo $contFila2++; ?>">Eliminar /</a><a href="usuarios.php?ver=<?php echo $ver++; ?>"> Ver</a></td>     
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