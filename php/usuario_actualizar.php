<?php

    require_once "../inc/start_session.php";
    require_once "./main.php";

    $id=limpiarCadena($_POST['usuario_id']);

    //verificar usuario

    $check_user = conexion();

    $check_user=$check_user->query("SELECT * FROM usuarios WHERE usuario_id='$id'");

    if($check_user->rowCount()<=0){
        echo '
            <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
                El usuario no existe en el sistema
            </div>
        ';
        exit();
    }else{
       $datos=$check_user->fetch();
    }
    $check_user=null;

    $admin_usuario= limpiarCadena($_POST['administrador_usuario']);
    $admin_clave= limpiarCadena($_POST['administrador_clave']);

    #verificar datos obligatorios #
    if($admin_clave=="" || $admin_usuario==""){
        echo '
            <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No has llenado todos los campos que son obligatorios, 
            que corresponden a su USUARIO y CLAVE
            </div>
        ';
        exit();
    }
    if(verificarDatos("[a-zA-Z0-9]{4,20}",$admin_usuario)){
        echo '
            <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
           El USUARIO no coincide con el formato solicitado
            </div>
        ';
        exit();
    }
    if(verificarDatos("[a-zA-Z0-9$@.-]{7,100}",$admin_clave)){
        echo '
            <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
           El CLAVE no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    // VERIFICANDO ADMIN

    $check_admin= conexion();
    $check_admin=$check_admin->query("SELECT usuario_clave, usuario_usuario FROM usuarios
     WHERE usuario_usuario='$admin_usuario' AND usuario_id='".$_SESSION['id']."' ");

    if($check_admin->rowCount()==1){
        $check_admin=$check_admin->fetch();
        if($check_admin['usuario_usuario']!=$admin_usuario || 
        !password_verify($admin_clave,$check_admin['usuario_clave'])){
            echo '
                <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                USUARIO o CLAVE administrador incorrectos
                </div>
            ';
            exit();
        }
    }else{
        echo '
            <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            USUARIO o CLAVE administrador incorrectos
            </div>
        ';
        exit();
    }
    $check_admin=null;

     #almacenar datos

     $nombre = limpiarCadena($_POST['usuario_nombre']);
     $apellido = limpiarCadena($_POST['usuario_apellido']);
 
     $usuario = limpiarCadena($_POST['usuario_usuario']);
     $email = limpiarCadena($_POST['usuario_email']);
 
     $clave1 = limpiarCadena($_POST['usuario_clave_1']);
     $clave2 = limpiarCadena($_POST['usuario_clave_2']);
    
      #verificar datos obligatorios #
    if($nombre=="" || $apellido=="" || $usuario=="" ){
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

     #verificar el email #

     if($email!="" && $email!=$datos['email']){
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

    if($usuario!=$datos['usuario_usuario']){
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
    }
     # VERIFICAR CLAVES #
    if($clave1!="" || $clave2!=""){
        if(verificarDatos("[a-zA-Z0-9$@.-]{7,100}",$clave1) || verificarDatos("[a-zA-Z0-9$@.-]{7,100}",$clave2)){
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    Las CLAVES no coincide con el formato solicitado
                </div>
            ';
            exit();
        }else{
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
        }
        
    }else{
        $clave=$datos['usuario_clave'];
    }
     

    #Actualiza datos
    $actualiza_datos = conexion();
    $actualiza_datos = $actualiza_datos->prepare("UPDATE usuarios SET usuario_nombre=:nombre,usuario_apellido=:apellido,
    usuario_usuario=:usuario,usuario_clave=:clave,email=:email WHERE usuario_id=:id"); 
    
    $marcadores=[
        ":nombre"=>$nombre,
        ":apellido"=>$apellido,
        ":usuario"=>$usuario,
        ":clave"=>$clave,
        ":email"=>$email,
        ":id"=>$id
    ];
    //var_dump($marcadores);
    if($actualiza_datos->execute($marcadores)){
        echo '
            <div class="notification is-info is-light">
                <strong>¡USUARIO ACTUALIZADO!</strong><br>
                El usuario se actualizo correctamente
            </div>
        ';
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo actualizar, por favor intenete nuevamente.
            </div>
        ';
    }
    $actualiza_datos=null;
?>
