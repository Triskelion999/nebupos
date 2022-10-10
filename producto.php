<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<title>Productos</title>

<link rel="stylesheet"
href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap
.min.css">

<link rel="stylesheet"
href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awes
ome.min.css">

<script
src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script
src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min
.js"></script>

<script
src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.m
in.js"></script>

<script>
$(document).ready(function(){
$('[data-toggle="tooltip"]').tooltip();
});
</script>
</head>

<body>
<?php
require 'header.php';
?>

<div class="wrapper">
<div class="container-fluid">
<div class="row">
<div class="col-md-12">
<div class="mt-5 mb-3 clearfix">
<h2 class="pull-left">PRODUCTOS</h2>
<a href="create_producto.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Añadir producto</a>
</div>
<?php
// Include config file
require_once "config.php";
// Attempt select query execution
$sql = "SELECT * FROM producto";
if($result = mysqli_query($link, $sql)){
if(mysqli_num_rows($result) > 0){
echo '<table class="table table-bordered table-striped">';
echo "<thead>";
echo "<tr>";
echo "<th>Código</th>";
echo "<th>Tipo</th>";
echo "<th>Nombre</th>";
echo "<th>Precio</th>";
echo "<th>Costo</th>";
echo "<th>Stock</th>";
echo "<th>Stock mínimo</th>";
echo "<th>Estado</th>";
echo "<th>Descripción</th>";

echo "</tr>";
echo "</thead>";
echo "<tbody>";

while($row =
mysqli_fetch_array($result)){
echo "<tr>";
echo "<td>" . $row['codigo'] . "</td>";
if ($row['tipo'] == 0){
    echo "<td>" . 'Insumo' ."</td>";
}else{
    echo "<td>" . 'Producto' ."</td>";
}
echo "<td>" . $row['nombre'] . "</td>";
echo "<td>" . $row['precio'] . "</td>";
echo "<td>" . $row['costo'] . "</td>";
echo "<td>" . $row['stock'] . "</td>";
echo "<td>" . $row['stock_min'] . "</td>";
if ($row["estado"] == 1){
    echo "<td>" . 'Habilitado' ."</td>";
}else{
    echo "<td>" . 'Inhabilitado' ."</td>";
}
echo "<td>" . $row['descripcion'] . "</td>";


echo "<td>";
echo '<a
href="read_producto.php?codigo='. $row['codigo'] .'" class="mr-3" title="Ver Producto"
data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
echo '<a
href="update_producto.php?codigo='. $row['codigo'] .'" class="mr-3" title="Actualizar
Producto" data-toggle="tooltip"><span class="fa fa-pencil" style="color:orange;"></span></a>';
echo '<a
href="delete_producto.php?codigo='. $row['codigo'] .'&estado='. $row['estado'] .'" title="Inhabilitar/Habilitar Producto"
data-toggle="tooltip"><span class="fa fa-trash" style="color: red;"></span></a>';
echo "</td>";
echo "</tr>";
}
echo "</tbody>";
echo "</table>";

// Free result set
mysqli_free_result($result);
} else{
echo '<div class="alert
alert-danger"><em>No hay productos para mostrar.</em></div>';
}
} else{
echo "Oops! Something went wrong. Please try again later.";
}
// Close connection
mysqli_close($link);
?>

</div>

</div>

</div>

</div>
<?php
require 'footer.php';
?>
</body>

</html>
