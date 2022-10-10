<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<title>Clientes</title>

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
<h2 class="pull-left">CLIENTES</h2>
<a href="create_cliente.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Añadir cliente</a>
</div>
<?php
// Include config file
require_once "config.php";
// Attempt select query execution
$sql = "SELECT * FROM cliente";
if($result = mysqli_query($link, $sql)){
if(mysqli_num_rows($result) > 0){
echo '<table class="table table-bordered table-striped">';
echo "<thead>";
echo "<tr>";
echo "<th>Rut</th>";
echo "<th>Nombre</th>";
echo "<th>Direccion</th>";
echo "<th>Telefono</th>";
echo "<th>Estado</th>";
echo "<th>Correo</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";

while($row =
mysqli_fetch_array($result)){
echo "<tr>";
echo "<td>" . $row['rut_cliente'] .
"</td>";
echo "<td>" . $row['nombre'] .
"</td>";
echo "<td>" . $row['direccion']
. "</td>";
echo "<td>" . $row['telefono'] .
"</td>";
if ($row["estado"] == 1){
    echo "<td>" . 'Habilitado' ."</td>";
}else{
    echo "<td>" . 'Inhabilitado' ."</td>";
}
echo "<td>" . $row['correo'] . "</td>";

echo "<td>";
echo '<a
href="read.php?rut_cliente='. $row['rut_cliente'] .'" class="mr-3" title="Ver Cliente"
data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
echo '<a
href="update.php?rut_cliente='. $row['rut_cliente'] .'" class="mr-3" title="Actualizar
Cliente" data-toggle="tooltip"><span class="fa fa-pencil" style="color:orange;"></span></a>';
echo '<a
href="delete.php?rut_cliente='. $row['rut_cliente'] .'&estado='. $row['estado'] .'" title="Inhabilitar/Habilitar Cliente"
data-toggle="tooltip"><span class="fa fa-trash" style="color:red;"></span></a>';

echo "</td>";
echo "</tr>";
}
echo "</tbody>";
echo "</table>";
// Free result set
mysqli_free_result($result);
} else{
echo '<div class="alert
alert-danger"><em>No hay clientes...</em></div>';
}
} else{
echo "Oops! Something went wrong. Please try
again later.";
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
