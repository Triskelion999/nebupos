<?php
require_once "config.php";
// Define variables and initialize with empty values
$rut_cliente = $nombre = $direccion = $telefono = $correo = "";
$rut_cliente_err = $nombre_err = $direccion_err = $telefono_err = $correo_err = "";
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    //validar rut_cliente
    $input_rut_cliente = trim($_POST["rut_cliente"]);
    if(empty($input_rut_cliente)){
        $rut_cliente_err = "Porfavor, ingresar rut de cliente.";
    } else{
        $rut_cliente = $input_rut_cliente;
    }

    // Validar nombre
    $input_nombre = trim($_POST["nombre"]);
    if(empty($input_nombre)){
      $nombre_err = "Porfavor ingresar nombre del cliente.";
    } elseif(!filter_var($input_nombre, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
      $nombre_err = "Porfavor ingresar un nombre válido.";
    } else{
      $nombre = $input_nombre;
    }

    // (no) Validar direccion
    $input_direccion = trim($_POST["direccion"]);
    $direccion = $input_direccion;


    // (no) Validar telefono
    $telefono = $_POST["telefono"];


    // (no) Validar correo
    $input_correo = trim($_POST["correo"]);
    $correo = $input_correo;


    // Check input errors before inserting in database
    if(empty($rut_cliente_err) && empty($nombre_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO cliente (rut_cliente, nombre, direccion, telefono, correo) VALUES (?, ?, ?, ?, ?)";
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "sssss", $param_rut_cliente, $param_nombre, $param_direccion, $param_telefono, $param_correo);
        // Set parameters
        $param_rut_cliente = $rut_cliente;
        $param_nombre = $nombre;
        $param_direccion = $direccion;
        $param_telefono = $telefono;
        $param_correo = $correo;

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Records created successfully. Redirect to landing page
            header("location: cliente.php");
            exit();
        }else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
    // Close statement
    mysqli_stmt_close($stmt);
    }
    // Close connection
    mysqli_close($link);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Nuevo Cliente</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<style>
  .wrapper{
  width: 600px;
  margin: 0 auto;
  margin-block-end: 40px;
  }
</style>
</head>


<body>

<?php require 'header.php'; ?>

<div class="wrapper">
<div class="container-fluid">
<div class="row">
<div class="col-md-12">
<h2 class="mt-5">Nuevo cliente</h2>
<p>Ingrese los datos del cliente que desea agregar.</p>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

<div class="form-group">
  <label>Rut</label>
  <input type="text" name="rut_cliente" class="form-control <?php echo (!empty($rut_cliente_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $rut_cliente; ?>" maxlength="9">
  <span class="invalid-feedback"><?php echo $rut_cliente_err;?></span>
</div>

<div class="form-group">
  <label>Nombre</label>
  <input type="text" name="nombre" class="form-control <?php echo (!empty($nombre_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nombre; ?>" maxlength="50">
  <span class="invalid-feedback"><?php echo $nombre_err;?></span>
</div>

<div class="form-group">
<label>Direccion</label>
<textarea name="direccion" class="form-control <?php echo (!empty($direccion_err)) ? 'is-invalid' : ''; ?>" required maxlength="100"><?php echo $direccion; ?></textarea>
<span class="invalid-feedback"><?php echo $direccion_err;?></span>
</div>

<div class="form-group">
<label>Telefono</label>
<input type = "text" name="telefono" class="form-control <?php echo (!empty($telefono_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $telefono; ?>"  maxlength="15">
<span class="invalid-feedback"><?php echo $telefono_err;?></span>
</div>

<div class="form-group">
<label>Correo</label>
<input type = "email" name="correo" class="form-control <?php echo (!empty($correo_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $correo; ?>"  maxlength="100">
<span class="invalid-feedback"><?php echo $correo_err;?></span>
</div>

<input type="submit" class="btn btn-success" value="Enviar">
<a href="cliente.php" class="btn btn-secondary ml-2">Cancelar</a>
</form>
</div>
</div>
</div>
</div>



<?php
require 'footer.php';
?>
</body>

</html>
