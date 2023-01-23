<?php
include('DAO.php');
DAO::conectar();
$codigo = $_GET['id'];
$usuario = DAO::lerModificado($codigo);
if (isset($_POST['addN'])) {
    $rol = $_POST['rol'][0];
    $username=$_POST['username'];
    $haspassword=crypt($_POST['password'],'ripemd160');
    $email = $_POST['email'];
    $usuarioMod = new Usuario();
    $usuarioMod->Crear($rol, $username, $haspassword, $email);
    DAO::modificarUsuario($usuarioMod);
    header('Location: admin.php');
}



?>
 <form action="modificar.php" method="post" id="registro">
        Username:<input type="text" name="username" placeholder="NUEVO Nombre de Usuario" value="<?php echo $usuario->getUsername()?>" /><br/>
        Contraseña: <input type="password" name="password" placeholder="NUEVA Introduce Contraseña" value="<?php echo $usuario->getHashpassword()?>" /><br/>
        Email: <input type="email" name="email" placeholder="Introduce NUEVO Email" value="<?php echo $usuario->getEmail()?>" /><br/>
        Rol:
        <select name="rol[]" class="option-select">
          <option value="admin" <?php if (isset($_POST['rol']) && (in_array("admin", $_POST['rol'])))
                              echo "selected";
                            ?>>admin</option>
          <option value="user" <?php if (isset($_POST['rol']) && (in_array("user", $_POST['rol'])))
                              echo "selected";
                            ?>>client</option>
        </select> 
        <br/>                   
        <button class="boton" type="sumbit" name="addN">GUARDAR</button>
      </form>