<?php require "./inc/start_session.php" ?>
<!DOCTYPE html>
<html>
<head>
   <?php require "./inc/head.php"?>
</head>
<body>
    <?php 

    if(!isset($_GET["vista"]) || $_GET["vista"]==""){
        $_GET["vista"]="login";
    }
    if(is_file("./vistas/".$_GET["vista"].".php") && $_GET["vista"]!="login" && $_GET["vista"]!="404"){
        
        #cerrar sesion forzada #
        if((!isset($_SESSION['id']) || $_SESSION['id']=="") || (!isset($_SESSION['usuario']) ||
        $_SESSION['usuario']="")){
            include "./vistas/logout.php";
            exit();
        }
        include "./inc/navbar.php";
        include "./vistas/".$_GET["vista"].".php";
        include "./inc/script.php";

    }else{
        if($_GET["vista"]=="login"){
            include "./vistas/login.php";
        }else{
            include "./vistas/404.php";
        }
    }
 
     ?>
</body>

</html>
