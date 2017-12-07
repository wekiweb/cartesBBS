<?php
$board = "threadboard";
$conn = mysqli_connect("localhost", "cartes", "/*passwd*/");
mysqli_select_db($conn, "db_cartes");
mysqli_query($conn, "set names utf8");
?>
