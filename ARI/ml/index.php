<?php
session_start();
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');

setcookie("subx", $_SESSION['sub'], time() + (86400 * 30), "/");
?>
<!DOCTYPE html>
<html>
 
<head>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.9.0/p5.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.9.0/addons/p5.dom.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.9.0/addons/p5.sound.min.js"></script>
  
  <script src="https://unpkg.com/ml5@0.5.0/dist/ml5.min.js"></script>
  
  <link rel="stylesheet" type="text/css" href="style.css">
  <meta charset="utf-8" />

</head>

<body>
  <script src="sketch.js"></script>
</body>

</html>