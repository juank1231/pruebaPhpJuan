<?php
    require_once "./main.php";

    #almacenar datos

    $nombre = limpiarCadena($_POST['usuario_nombre']);
    $apellido = limpiarCadena($_POST['usuario_apellido']);

    $usuario = limpiarCadena($_POST['usuario_usuario']);
    $email = limpiarCadena($_POST['usuario_email']);

    $clave1 = limpiarCadena($_POST['usuario_clave_1']);
    $clave2 = limpiarCadena($_POST['usuario_clave_2']);


    #verificar datos obligatorios #
    if($nombre=="" || $apellido=="" || $usuario=="" || $clave1=="" || $clave2==""){
        echo '
            <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }

    if(verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$nombre)){
        echo '
            <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
           El NOMBRE no coincide con el formato solicitado
            </div>
        ';
        exit();
    }
    if(verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$apellido)){
        echo '
            <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
           El APELLIDO no coincide con el formato solicitado
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
    if(verificarDatos("[a-zA-Z0-9$@.-]{7,100}",$clave1) || verificarDatos("[a-zA-Z0-9$@.-]{7,100}",$clave2)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Las CLAVES no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    #verificar el email #

    if($email!=""){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $check_email=conexion();
            $check_email=$check_email->query("SELECT email FROM usuarios WHERE email='$email'");
            if($check_email->rowCount()>0){
                echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        El email ingresado ya se encuentra registrado, por favor elija otro
                    </div>
                ';
                exit();               
            }
            $check_email=null;

        }else{
            echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Las EMAIL ingresado no es valido
            </div>
            ';
            exit();
        }
    }

    # validando usuario ## 

    
    $check_usuario=conexion();
    $check_usuario=$check_usuario->query("SELECT usuario_usuario FROM usuarios 
    WHERE usuario_usuario='$usuario'");
    if($check_usuario->rowCount()>0){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El USUARIO ingresado ya se encuentra registrado, por favor elija otro
            </div>
        ';
        exit();    
    
    }
    $check_usuario=null;       

    # VERIFICAR CLAVES #

    if($clave1!=$clave2){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Las CLAVES ingresadas no coinciden
            </div>
        ';
        exit();
    }else{
        $clave= password_hash($clave1,PASSWORD_BCRYPT,["cost"=>10]);
    }  
    
    
    # una ves verificado empiezo a guardar el usuario

    $guardar_usuario=conexion();
    $guardar_usuario= $guardar_usuario->prepare("INSERT INTO usuarios(usuario_nombre,usuario_apellido,usuario_usuario,usuario_clave,email)
    values(:nombre,:apellido,:usuario,:clave,:email)");

    $marcadores=[
        ":nombre"=>$nombre,
        ":apellido"=>$apellido,
        ":usuario"=>$usuario,
        ":clave"=>$clave,
        ":email"=>$email
    ];
    $guardar_usuario->execute($marcadores);
      
    if($guardar_usuario->rowCount()==1){
        echo '
        <div class="notification is-info is-light">
            <strong>¡USUARIO REGISTRADO!</strong><br>
            El usuario a sido registrado exitosamente.
        </div>
        ';
    }else{
        echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No se pudo registrar el usuari, por favor intente nuevmente.
        </div>
    ';
    }
    $guardar_usuario=null;

    
?>

