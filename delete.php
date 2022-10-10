<?php
// Process delete operation after confirmation
if(isset($_POST["rut_cliente"]) && !empty($_POST["rut_cliente"])){
  // Include config file
  require_once "config.php";

  if($_POST['estado'] == 1){
    // Preparar un SELECT
    $sql = "UPDATE cliente SET estado = 0 WHERE rut_cliente = ? ";
    if($stmt = mysqli_prepare($link, $sql)){
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "i", $param_rut_cliente);
      // Set parameters
      $param_rut_cliente = trim($_POST["rut_cliente"]);
      // Attempt to execute the prepared statement
      if(mysqli_stmt_execute($stmt)){
        // Records deleted successfully. Redirect to landing page
        header("location: cliente.php");
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
    $sql = "UPDATE cliente SET estado = 1 WHERE rut_cliente = ? ";
    if($stmt = mysqli_prepare($link, $sql)){
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "i", $param_rut_cliente);
      // Set parameters
      $param_rut_cliente = trim($_POST["rut_cliente"]);
      // Attempt to execute the prepared statement
      if(mysqli_stmt_execute($stmt)){
        // Records deleted successfully. Redirect to landing page
        
        header("location: cliente.php");
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
    if(empty(trim($_GET["rut_cliente"]))){
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
  echo '<h2 class="mt-5 mb-3">Habilitar cliente</h2>';
}
else
{
  echo '<h2 class="mt-5 mb-3">Inhabilitar cliente</h2>';
};
?>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

  <?php if($_GET['estado'] == 0){
    echo '<div class="alert alert-success">';
  }else{
    echo '<div class="alert alert-danger">';
  }; ?>


<input type="hidden" name="rut_cliente" value="<?php echo trim($_GET["rut_cliente"]); ?>"/>
<input type="hidden" name="estado" value="<?php echo trim($_GET["estado"]); ?>"/>

<?php if($_GET['estado'] == 0){
  echo '<p>¿Estás seguro que deseas habilitar a este cliente?</p>
  <p>
  <input type="submit" value="Si" class="btn btn-success">
  <a href="cliente.php" class="btn btn-secondary">No</a>
  </p>';
}else{
  echo '<p>¿Estás seguro que deseas inhabilitar a este cliente?</p>
  <p>
  <input type="submit" value="Si" class="btn btn-danger">
  <a href="cliente.php" class="btn btn-secondary">No</a>
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
