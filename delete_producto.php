<?php
// Process delete operation after confirmation
if(isset($_POST["codigo"]) && !empty($_POST["codigo"])){
  // Include config file
  require_once "config.php";

  if($_POST['estado'] == 1){
    // Preparar un SELECT
    $sql = "UPDATE producto SET estado = 0 WHERE codigo = ? ";
    if($stmt = mysqli_prepare($link, $sql)){
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "i", $param_codigo);
      // Set parameters
      $param_codigo = trim($_POST["codigo"]);
      // Attempt to execute the prepared statement
      if(mysqli_stmt_execute($stmt)){
        // Records deleted successfully. Redirect to landing page
        header("location: producto.php");
        exit();
      } else{
        echo "Oops! Something went wrong. Please try again
        later.";
      }
    }
    // Close statement
    mysqli_stmt_close($stmt);
    // Close connection
    mysqli_close($link);
  }else{
    $sql = "UPDATE producto SET estado = 1 WHERE codigo = ? ";
    if($stmt = mysqli_prepare($link, $sql)){
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "i", $param_codigo);
      // Set parameters
      $param_codigo = trim($_POST["codigo"]);
      // Attempt to execute the prepared statement
      if(mysqli_stmt_execute($stmt)){
        // Records deleted successfully. Redirect to landing page
        
        header("location: producto.php");
        exit();
      } else{
        echo "Oops! Something went wrong. Please try again
        later.";
      }
    }
    // Close statement
    mysqli_stmt_close($stmt);
    // Close connection
    mysqli_close($link);

  }

  }else{
    // Check existence of id parameter
    if(empty(trim($_GET["codigo"]))){
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
<title>Confirmación</title>
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
<div class="wrapper">
<div class="container-fluid">
<div class="row">
<div class="col-md-12">
<?php
if($_GET['estado'] == 0)
{
  echo '<h2 class="mt-5 mb-3">Habilitar Producto</h2>';
}
else
{
  echo '<h2 class="mt-5 mb-3">Inhabilitar Producto</h2>';
};
?>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

  <?php if($_GET['estado'] == 0){
    echo '<div class="alert alert-success">';
  }else{
    echo '<div class="alert alert-danger">';
  }; ?>


<input type="hidden" name="codigo" value="<?php echo trim($_GET["codigo"]); ?>"/>
<input type="hidden" name="estado" value="<?php echo trim($_GET["estado"]); ?>"/>

<?php if($_GET['estado'] == 0){
  echo '<p>¿Estás seguro que deseas habilitar este producto?</p>
  <p>
  <input type="submit" value="Si" class="btn btn-success">
  <a href="producto.php" class="btn btn-secondary">No</a>
  </p>';
}else{
  echo '<p>¿Estás seguro que deseas inhabilitar este producto?</p>
  <p>
  <input type="submit" value="Si" class="btn btn-danger">
  <a href="producto.php" class="btn btn-secondary">No</a>
  </p>';
}; ?>


</div>
</form>
</div>
</div>
</div>
</div>
</body>
</html>
