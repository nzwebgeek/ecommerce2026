<?php 
session_start();
session_destroy();
header("locations:../../public/");
echo "Logged Out <br> <a href='../index.php'>Click here to return to Home Page</a>";
?>