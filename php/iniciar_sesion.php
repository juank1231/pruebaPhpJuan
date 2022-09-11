<?php

    #ALMACENAR DATOS #

    $usuario = limpiarCadena($_POST['login_usuario']);
    $clave = limpiarCadena($_POST['login_clave']);

    #verificar datos obligatorios #
    if($usuario=="" || $clave==""){
        echo '
            <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }
    if(verificarDatos("[a-zA-Z0-9]{4,20}",$usuario)){
        echo '
            <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
           El USUARIO no coincide con el formato solicitado
            </div>
        ';
        exit();
    }
    if(verificarDatos("[a-zA-Z0-9$@.-]{7,100}",$clave)){
        echo '
            <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
           El CLAVE no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    $check_user = conexion();
    $check_user=$check_user->query("SELECT * FROM usuarios WHERE usuario_usuario='$usuario'");

    if($check_user->rowCount()==1){
        $check_user=$check_user->fetch();
        if($check_user['usuario_usuario']==$usuario && password_verify($clave,$check_user['usuario_clave'])){
            $_SESSION['nombre']=$check_user['usuario_nombre'];
            $_SESSION['id']=$check_user['usuario_id'];
            $_SESSION['apellido']=$check_user['usuario_apellido'];
            $_SESSION['usuario']=$check_user['usuario_usuario'];
            if(headers_sent()){
                echo "<script> window.location.href='index.php?vista=home'</script>";
            }else{
                header("Location: index.php?vista=home");
            }
        }else{

        }
    }else{
        echo '
            <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
           Usuario o Clave incorrectos
            </div>
        ';
    }
    $check_user=null;
?>