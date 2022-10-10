<?php
require_once 'config.php';
// Define variables and initialize with empty values
$rut_administrador = $contrasena_user =  $nombre = "";
$rut_administrador_err = $contrasena_err = $login_err = "";
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

  // Check if username is empty
  if(empty(trim($_POST["rut_administrador"]))){
    $rut_administrador_err = "Por favor ingresar RUT.";
  } else{
    $rut_administrador = trim($_POST["rut_administrador"]);
  }

  //Validar codigo verificador
  $rut_administrador_num = substr($rut_administrador,0,strlen($rut_administrador) - 1);
  $rut_administrador_dv = substr($rut_administrador, -1);
  $rut_administrador_aux = $rut_administrador_num.'-'.$rut_administrador_dv;
  $validacion = phpRule_ValidarRut($rut_administrador_aux);
  if($validacion['error']){
    $rut_administrador_err = $validacion['msj'];
  }


  // Check if password is empty
  if(empty(trim($_POST["contrasena"]))){
    $contrasena_err = "Por favor ingresar contraseña.";
  } else{
    $contrasena_user = trim($_POST["contrasena"]);
  }

  // Validate credentials
  if(empty($rut_administrador_err) && empty($contrasena_err)){
    // Prepare a select statement
    $sql = "SELECT rut_administrador, nombre, contrasena FROM administrador WHERE
    rut_administrador = ?";
    if($stmt = mysqli_prepare($link, $sql)){
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "s", $param_rut_administrador);
      // Set parameters
      $param_rut_administrador = $rut_administrador;
      // Attempt to execute the prepared statement
      if(mysqli_stmt_execute($stmt)){
        // Store result
        mysqli_stmt_store_result($stmt);
        // Check if username exists, if yes then verify password
        if(mysqli_stmt_num_rows($stmt) == 1){
          // Bind result variables
          mysqli_stmt_bind_result($stmt, $rut_administrador, $nombre, $contrasena);

          if(mysqli_stmt_fetch($stmt)){
            if($contrasena_user == $contrasena){
              // Password is correct, so start a new session
              session_start();
              // Store data in session variables
              $_SESSION["loggedin"] = true;
              $_SESSION["nombre"] = $nombre;
              $_SESSION["rut_administrador"] = $rut_administrador;
              // Redirect user to welcome page
              header("location: welcome.php");
            } else{
              // Password is not valid, display a generic error message
              $login_err = "Usuario o contraseña inválido(s).";
            }
          }
        } else{
          // Username doesn't exist, display a generic error message
          $login_err = "Usuario o contraseña inválido(s).";
        }
      } else{
        echo "Oops! Something went wrong. Please try again later.";
      }
      // Close statement
      mysqli_stmt_close($stmt);
    }
  }
  // Close connection
  mysqli_close($link);
  }

  function phpRule_ValidarRut($rut) {

    // Verifica que no esté vacio y que el string sea de tamaño mayor a 3 carácteres(1-9)        
    if ((empty($rut)) || strlen($rut) < 3) {
        return array('error' => true, 'msj' => 'RUT vacío o con menos de 3 caracteres.');
    }

    // Quitar los últimos 2 valores (el guión y el dígito verificador) y luego verificar que sólo sea
    // numérico
    $parteNumerica = str_replace(substr($rut, -2, 2), '', $rut);

    if (!preg_match("/^[0-9]*$/", $parteNumerica)) {
        return array('error' => true, 'msj' => 'La parte numérica del RUT sólo debe contener números.');
    }

    $guionYVerificador = substr($rut, -2, 2);
    // Verifica que el guion y dígito verificador tengan un largo de 2.
    if (strlen($guionYVerificador) != 2) {
        return array('error' => true, 'msj' => 'Error en el largo del dígito verificador.');
    }

    // obliga a que el dígito verificador tenga la forma -[0-9] o -[kK]
    if (!preg_match('/(^[-]{1}+[0-9kK]).{0}$/', $guionYVerificador)) {
        return array('error' => true, 'msj' => 'El dígito verificador no cuenta con el patrón requerido');
    }

    // Valida que sólo sean números, excepto el último dígito que pueda ser k
    if (!preg_match("/^[0-9.]+[-]?+[0-9kK]{1}/", $rut)) {
        return array('error' => true, 'msj' => 'Error al digitar el RUT');
    }

    $rutV = preg_replace('/[\.\-]/i', '', $rut);
    $dv = substr($rutV, -1);
    $numero = substr($rutV, 0, strlen($rutV) - 1);
    $i = 2;
    $suma = 0;
    foreach (array_reverse(str_split($numero)) as $v) {
        if ($i == 8) {
            $i = 2;
        }
        $suma += $v * $i;
        ++$i;
    }
    $dvr = 11 - ($suma % 11);
    if ($dvr == 11) {
        $dvr = 0;
    }
    if ($dvr == 10) {
        $dvr = 'K';
    }
    if ($dvr == strtoupper($dv)) {
        return array('error' => false, 'msj' => 'RUT ingresado correctamente.');
    } else {
        return array('error' => true, 'msj' => 'El RUT ingresado no es válido.');
    }
  }

?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Inicio</title>
<link rel="stylesheet"
href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script
src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script
src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script
src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<style>
.container{
  margin: 40px;
}
</style>
<script>
$(document).ready(function(){
$('[data-toggle="tooltip"]').tooltip();
});
</script>
</head>

<body>
<?php
require 'header_home.php';
?>

<div class="row">

<div class="container w-auto mx-auto">

  <h1> Iniciar sesión </h1>
  <form method = "post">
    <div class="form-group">
      <label for="rut_administrador">RUT </label>
      <input required maxlength = "9" type="text" style= "width:250px" name="rut_administrador" class="form-control 
      <?php echo (!empty($rut_administrador_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $rut_administrador; ?>">
      <span class="invalid-feedback"><?php echo $rut_administrador_err; ?></span>
    </div>

    <div class="form-group" >
      <label for="contrasena">Contraseña</label>
      <input  required maxlength="15" type="password" style= "width:250px" name="contrasena" class="form-control <?php echo (!empty($contrasena_err)) ? 'is-invalid' : ''; ?>">
      <span class="invalid-feedback"><?php echo $contrasena_err; ?></span>
    </div>

    <button type="submit" class="btn btn-success form-control 
    <?php echo(!empty($login_err)) ? 'is-invalid' : ''; ?>" style = "width: 250px;">Iniciar sesión</button>
    <span class="invalid-feedback"> <?php echo $login_err ?> </span>
  </form>

</div>

</div>

<?php
require 'footer.php';
?>

</body>

</html>
