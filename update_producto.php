<?php
require_once "config.php";
// Define variables and initialize with empty values
$nombre = $descripcion = $precio = $costo = $stock = $tipo_producto = $stock_min = "" ;
$nombre_err = $descripcion_err = $precio_err = $costo_err = $stock_err = $stock_min_err = $tipo_producto_err = "";
// Processing form data when form is submitted
if(isset($_POST["codigo"]) && !empty($_POST["codigo"])){
  // Get hidden input value
  $codigo = $_POST["codigo"];

  // Validate name
  $input_nombre = trim($_POST["nombre"]);
    if(empty($input_nombre)){
      $nombre_err = "Favor ingresar nombre del producto.";
    } elseif(!filter_var($input_nombre, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z ñÑ\s]+$/")))){
      $nombre_err = "Favor ingresar un nombre válido.";
    } else{
      $nombre = $input_nombre;
    }

    // Validate descripcion
    $input_descripcion = trim($_POST["descripcion"]);
    if(empty($input_descripcion)){
      $descripcion_err = "Favor ingresar descripcion.";
    } else{
      $descripcion = $input_descripcion;
    }

    // Validar precio
    $input_precio = trim($_POST["precio"]);
    if(empty($input_precio)){
      $precio_err = "Favor ingresar el precio.";
    } elseif(!ctype_digit($input_precio)){
      $precio_err = "Favor ingresar valor numérico.";
    } else{
        $precio = $input_precio;
    }

    // (no) Validar stock
    $input_stock = trim($_POST["stock"]);
    if(empty($input_stock)){
      $stock = 1;
    }else{
      $stock = $input_stock;
    }

    // (no) Validar costo
    $input_costo = trim($_POST["costo"]);
    if(empty($input_costo)){
      $costo_err = "Favor ingresar costo.";
    }elseif(!ctype_digit($input_costo)){
      $costo_err = "Favor ingresar valor numérico.";
    }else{
      $costo = $input_costo;
    }

    // (no) Validar stock_min
    $input_stock_min = trim($_POST["stock_min"]);
    if(empty($input_stock_min)){
      $stock_min = 0 ;
    }else{
      $stock_min = $input_stock_min;
    }

    // (no) Validar insumo o producto
    $input_tipo_producto = $_POST["tipo_producto"];
    if(empty($input_tipo_producto)){
      $tipo_producto_err = "Favor ingresar seleccionar el tipo de producto.";
    }else{
      $tipo_producto = $input_tipo_producto;
    }

    // Check input errors before inserting in database
    if(empty($nombre_err) && empty($descripcion_err) && empty($precio_err) && empty($costo_err)){
      // Prepare an insert statement
      $sql = "UPDATE producto SET nombre=?, descripcion=?, precio=?, stock=?, costo=?, stock_min=?, tipo=? WHERE codigo=?";
      
      if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ssiiiiii", $param_nombre, $param_descripcion, $param_precio, $param_stock, $param_costo, $param_stock_min, $param_tipo, $param_codigo);
        // Set parameters
        $param_nombre = $nombre;
        $param_descripcion = $descripcion;
        $param_precio = $precio;
        $param_stock = $stock;
        $param_costo = $costo;
        $param_stock_min = $stock_min;
        $param_tipo = $tipo_producto;
        $param_codigo = $codigo;
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
          // Records created successfully. Redirect to landing page
          header("location: producto.php");
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
} else {
      // Check existence of id parameter before processing further
      if (isset($_GET["codigo"]) && !empty(trim($_GET["codigo"]))){
        // Get URL parameter
        $codigo = trim($_GET["codigo"]);
        // Prepare a select statement
        $sql = "SELECT * FROM producto WHERE codigo = ?";
        if($stmt = mysqli_prepare($link, $sql)){
          // Bind variables to the prepared statement as parameters
          mysqli_stmt_bind_param($stmt, "i", $param_codigo);
          // Set parameters
          $param_codigo = $codigo;
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
              $tipo_producto = $row["tipo"];
              $nombre = $row["nombre"];
              $precio = $row["precio"];
              $costo = $row["costo"];
              $stock = $row["stock"];
              $stock_min = $row["stock_min"];
              $descripcion = $row["descripcion"];
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
<title>Nuevo producto</title>
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
<h2 class="mt-5">Actualizar Producto de Código <?php echo $_GET['codigo'] ?></h2>
<p>Favor editar los valores, para actualizar el producto.</p>
<form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">

<div class="form-group">
  <label>Nombre</label>
  <input type="text" name="nombre" class="form-control <?php echo (!empty($nombre_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nombre; ?>" required maxlength="50">
  <span class="invalid-feedback"><?php echo $nombre_err;?></span>
</div>

<!--  Cambiar  -->
<label>Tipo producto</label>
<div class="form-check" style="margin-bottom:20px;" >
  <input class="form-check-input" type="radio" name="tipo_producto"  value = "0" checked>
  <label class="form-check-label" style="margin-right:40px;">
    Insumo
  </label>
  <input class="form-check-input" type="radio" name="tipo_producto"  value = "1">
  <label class="form-check-label">
    Producto
  </label>
</div>

<div class="form-group">
  <label>Precio</label>
  <input type = "number" required max="999999" class="form-control <?php echo (!empty($precio_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $precio; ?>" name="precio" class="form-control <?php echo (!empty($precio_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $precio; ?>" >
  <span class="invalid-feedback"><?php echo $precio_err;?></span>
</div>

<div class="form-group">
  <label>Costo</label>
  <input type = "number" required max="999999" name="costo" class="form-control <?php echo (!empty($costo_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $costo; ?>" >
  <span class="invalid-feedback"><?php echo $costo_err;?></span>
</div>

<div class="form-group">
  <label>Stock</label>
  <input type = "number" max="9999" name="stock" class="form-control <?php echo (!empty($stock_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $stock; ?>" >
  <span class="invalid-feedback"><?php echo $stock_err;?></span>
</div>

<div class="form-group">
  <label>Stock mínimo</label>
<input type = "number" max="9999" name="stock_min" class="form-control <?php echo (!empty($stock_min_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $stock_min; ?>" >
<span class="invalid-feedback"><?php echo $stock_min_err;?></span>
</div>

<div class="form-group">
<label>Descripcion</label>
<textarea name="descripcion" class="form-control <?php echo (!empty($descripcion_err)) ? 'is-invalid' : ''; ?>" required maxlength="150"><?php echo $descripcion; ?></textarea>
<span class="invalid-feedback"><?php echo $descripcion_err;?></span>
</div>

<input type="hidden" name="codigo" value="<?php echo $codigo; ?>"/>
<input type="submit" class="btn btn-success" value="Enviar">
<a href="producto.php" class="btn btn-secondary ml-2">Cancelar</a>
</form>
</div>
</div>
</div>
</div>
<?php require 'footer.php'; ?>
</body>
</html>
