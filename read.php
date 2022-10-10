
<?php

// Check existence of id parameter before processing further
if(isset($_GET["rut_cliente"]) && !empty(trim($_GET["rut_cliente"]))){
    // Include config file
    require_once "config.php";
    // Prepare a select statement
    $sql = "SELECT * FROM cliente WHERE rut_cliente = ?";
    if($stmt = mysqli_prepare($link, $sql)){
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "i", $param_id);
    // Set parameters
    $param_id = trim($_GET["rut_cliente"]);
    // Attempt to execute the prepared statement
    if(mysqli_stmt_execute($stmt)){
    $result = mysqli_stmt_get_result($stmt);
    if(mysqli_num_rows($result) == 1){
    /* Fetch result row as an associative array. Since the
    result set
    contains only one row, we don't need to use while loop
    */
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    // Retrieve individual field value
    $rut_cliente = $row["rut_cliente"];
    $nombre = $row["nombre"];
    $direccion = $row["direccion"];
    $telefono = $row["telefono"];
    $estado = $row["estado"];
    $correo = $row["correo"];
    } else{
    // URL doesn't contain valid id parameter. Redirect to error page
    header("location: error.php");
    exit();
    }
    } else{
    echo "Oops! Something went wrong. Please try again
    later.";
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
    ?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<title>Consultar Cliente</title>

<link rel="stylesheet"
href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap
.min.css">

<style>
.wrapper{
width: 600px;
margin: 0 auto;
}
</style>

</head>

<body>

<?php
require 'header.php';
?>

<div class="wrapper">

<div class="container-fluid">

<div class="row">

<div class="col-md-12">

<h1 class="mt-5 mb-3">Consultar Cliente</h1>

<div class="form-group">
<label><b>Rut</b></label>
<p><?php echo $row["rut_cliente"]; ?></p>
</div>

<div class="form-group">
<label><b>Nombre</b></label>
<p><?php echo $row["nombre"]; ?></p>
</div>

<div class="form-group">
<label><b>Direccion</b></label>
<p><?php echo $row["direccion"]; ?></p>
</div>

<div class="form-group">
<label><b>Telefono</b></label>
<p><?php echo $row["telefono"]; ?></p>
</div>

<div class="form-group">
<label><b>Estado</b></label>
<p><?php
if ($row["estado"] = 1){
    echo "Habilitado";
}else{
    echo "Inhabilitado";
}
?></p>
</div>

<div class="form-group">
<label><b>Correo</b></label>
<p><?php echo $row["correo"]; ?></p>
</div>

<p><a href="cliente.php" class="btn
btn-success">Volver</a></p>

</div>
</div>
</div>
</div>




<?php
require 'footer.php';
?>
</body>

</html>
