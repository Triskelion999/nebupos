
<?php

// Check existence of id parameter before processing further
if(isset($_GET["codigo"]) && !empty(trim($_GET["codigo"]))){
    // Include config file
    require_once "config.php";
    // Prepare a select statement
    $sql = "SELECT * FROM producto WHERE codigo = ?";
    if($stmt = mysqli_prepare($link, $sql)){
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "i", $param_codigo);
    // Set parameters
    $param_codigo = trim($_GET["codigo"]);
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
    $codigo = $row["codigo"];
    $tipo = $row["tipo"];
    $nombre = $row["nombre"];
    $precio = $row["precio"];
    $costo = $row["costo"];
    $stock = $row["stock"];
    $stock_min = $row["stock_min"];
    $estado = $row["estado"];
    $descripcion = $row["descripcion"];
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

<title>Consultar Producto</title>

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

<h1 class="mt-5 mb-3">Consultar Producto</h1>

<div class="form-group">
<label><b>Código</b></label>
<p><?php echo $row["codigo"]; ?></p>
</div>

<div class="form-group">
<label><b>Tipo</b></label>
<p><?php 
if ($row['tipo'] == 0){
    echo "Insumo";
}else{
    echo "Producto";
}
?></p>
</div>

<div class="form-group">
<label><b>Nombre</b></label>
<p><?php echo $row["nombre"]; ?></p>
</div>

<div class="form-group">
<label><b>Precio</b></label>
<p><?php echo $row["precio"]; ?></p>
</div>

<div class="form-group">
<label><b>Costo</b></label>
<p><?php echo $row["costo"]; ?></p>
</div>

<div class="form-group">
<label><b>Stock</b></label>
<p><?php echo $row["stock"]; ?></p>
</div>

<div class="form-group">
<label><b>Stock mínimo</b></label>
<p><?php echo $row["stock_min"]; ?></p>
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
<label><b>Descripción</b></label>
<p><?php echo $row["descripcion"]; ?></p>
</div>

<p><a href="producto.php" class="btn
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
