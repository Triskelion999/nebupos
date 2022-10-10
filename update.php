<?php
// Include config file
require_once "config.php";
// Define variables and initialize with empty values
$nombre = $direccion = $telefono = $correo = "";
$nombre_err = $direccion_err = $telefono_err = $correo_err = "";
// Processing form data when form is submitted
if(isset($_POST["rut_cliente"]) && !empty($_POST["rut_cliente"])){
  // Get hidden input value
  $rut_cliente = $_POST["rut_cliente"];

  // Validar nombre
  $input_nombre = trim($_POST["nombre"]);
  if(empty($input_nombre)){
    $nombre_err = "Favor ingresar nombre.";
  } elseif(!filter_var($input_nombre, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z áéíóúÁÉÍÓÚñÑ\s]+$/")))){
    $nombre_err = "Favor ingresar nombre válido.";
  } else{
    $nombre = $input_nombre;
  }

  // Validar direccion
  $direccion = trim($_POST["direccion"]);

  // Validar telefono
  $telefono = trim($_POST["telefono"]);

  // Validar correo
  $correo = trim($_POST["correo"]);

  // Check input errors before inserting in database
  if(empty($nombre_err)  && empty($estado_err)){
    // Prepare an update statement
    $sql = "UPDATE cliente SET nombre=?, direccion=?, telefono = ?, correo = ? WHERE
    rut_cliente=?";

    if($stmt = mysqli_prepare($link, $sql)){
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "sssss", $param_nombre,
      $param_direccion, $param_telefono, $param_correo, $param_rut_cliente);

      // Set parameters
      $param_nombre = $nombre;
      $param_direccion = $direccion;
      $param_rut_cliente = $rut_cliente;
      $param_telefono = $telefono;
      $param_correo = $correo;

      // Attempt to execute the prepared statement
      if(mysqli_stmt_execute($stmt)){
        // Records updated successfully. Redirect to landing page
        header("location: cliente.php");
        exit();
      } else{
        echo "OH NO! ALGO SALIÓ MAL. VUELVA A INTENTAR MÁS TARDE.";
      }
    }
    // Close statement
    mysqli_stmt_close($stmt);
  }
  // Close connection
  mysqli_close($link);
  } else{
    // Check existence of id parameter before processing further
    if(isset($_GET["rut_cliente"]) && !empty(trim($_GET["rut_cliente"]))){
      // Get URL parameter
      $rut_cliente = trim($_GET["rut_cliente"]);
      // Prepare a select statement
      $sql = "SELECT * FROM cliente WHERE rut_cliente = ?";
      if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_rut_cliente);
        // Set parameters
        $param_rut_cliente = $rut_cliente;
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
          $result = mysqli_stmt_get_result($stmt);
          if(mysqli_num_rows($result) == 1){
            /* Fetch result row as an associative array. Since
            the result set
            contains only one row, we don't need to use while
            loop */
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            // Retrieve individual field value
            $nombre = $row["nombre"];
            $direccion = $row["direccion"];
            $telefono = $row["telefono"];
            $correo = $row["correo"];


          } else{
            // URL doesn't contain valid id. Redirect to landing page
            header("location: error.php");
            exit();
          }
        } else{
          echo "OH NO! ALGO SALIÓ MAL. VUELVA A INTENTAR MÁS TARDE.";
        }
      }
      // Close statement
      mysqli_stmt_close($stmt);
      // Close connection
      mysqli_close($link);
    } else{
      // URL doesn't contain id parameter. Redirect to error page
      header("location: error.php");
      exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Actualizar Cliente</title>
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
<h2 class="mt-5">Actualizar Cliente de RUT <?php echo $_GET['rut_cliente'] ?></h2>
<p>Favor editar los valores, para actualizar al cliente.</p>
<form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">

<div class="form-group">
<label>Nombre</label>
<input type="text" name="nombre" class="form-control <?php echo (!empty($nombre_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nombre; ?>">
<span class="invalid-feedback"><?php echo $nombre_err;?></span>
</div>

<div class="form-group">
<label>Direccion</label>
<textarea name="direccion" class="form-control <?php echo (!empty($direccion_err)) ? 'is-invalid' : ''; ?>"><?php echo $direccion; ?></textarea>
<span class="invalid-feedback"><?php echo $direccion_err;?></span>
</div>

<div class="form-group">
<label>Telefono</label>
<input type="text" name="telefono" class="form-control <?php echo (!empty($telefono_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $telefono; ?>">
<span class="invalid-feedback"><?php echo $telefono_err;?></span>
</div>

<div class="form-group">
<label>Correo</label>
<input type="text" name="correo" class="form-control <?php echo (!empty($correo_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $correo; ?>">
<span class="invalid-feedback"><?php echo $correo_err;?></span>
</div>

<input type="hidden" name="rut_cliente" value="<?php echo $rut_cliente; ?>"/>
<input type="submit" class="btn btn-success" value="Enviar">
<a href="cliente.php" class="btn btn-secondary ml-2">Cancelar</a>
</form>
</div>
</div>
</div>
</div>
  <?php require 'footer.php'; ?>
</body>
</html>
