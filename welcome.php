<?php
// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
header("location: index.php");
exit;
}
?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<title>Bienvenida</title>

<link rel="stylesheet"
href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<style>
.my-5{ 
  font-family: sans-serif; 
  text-align: center; 
}
</style>

</head>

<body>

<?php require 'header.php'; ?>

<h1 class="my-5">¡Hola, <b><?php echo
htmlspecialchars($_SESSION["nombre"]); ?></b>!  </br> </br> <img src="img/face.jpg" alt="smile-face" height="50"> </br> </br>Bienvenido a PDV NEBU</h1>


<?php require 'footer.php'; ?>

</body>

</html>
