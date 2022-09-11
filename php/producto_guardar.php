<?php
    require_once "./main.php";

    #almacenar datos

    $producto = limpiarCadena($_POST['nombre_producto']);
    $referencia = limpiarCadena($_POST['referencia']);

    $precio = limpiarCadena($_POST['precio']);
    $peso = limpiarCadena($_POST['peso']);

    $categoria = limpiarCadena($_POST['categoria']);
    $cantidad = limpiarCadena($_POST['cantidad']);
    $usuario = limpiarCadena($_POST['usuarioc']);


    #verificar datos obligatorios #
    if($producto=="" || $referencia=="" || $precio=="" || $usuario=="" || $peso=="" || $cantidad=="" || $cantidad==""){
        echo '
            <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }

    if(verificarDatos("[a-zA-Z0-9]{3,40}",$producto)){
        echo '
            <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
           El PRODUCTO no coincide con el formato solicitado
            </div>
        ';
        exit();
    }
    if(verificarDatos("[a-zA-Z0-9]{3,40}",$categoria)){
        echo '
            <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
           La CATEGORIA no coincide con el formato solicitado
            </div>
        ';
        exit();
    }
    if(verificarDatos("[a-zA-Z0-9]{4,20}",$referencia)){
        echo '
            <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
           El REFERENCIA no coincide con el formato solicitado
            </div>
        ';
        exit();
    }


    # validando PRODUCTO ## 

    
    $check_producto=conexion();
    $check_producto=$check_producto->query("SELECT nombre_producto,referencia FROM productos 
    WHERE nombre_producto='$producto' AND referencia='$referencia'");
    if($check_producto->rowCount()>0){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El PRODUCTO ingresado ya se encuentra registrado, por favor elija otro
            </div>
        ';
        exit();    
    
    }
    $check_producto=null;       
        
    # una ves verificado empiezo a guardar el PRODUCTO
    $guardar_producto=conexion();
    $guardar_producto= $guardar_producto->prepare("INSERT INTO productos(nombre_producto,referencia,precio,peso,categoria,stock,fecha_creacion,usuario_id)
    VALUES(:producto,:referencia,:precio,:peso,:categoria,:stock,:fecha,:usuario)");
    $fecha = date("Ymd");
    $marcadores=[
        ":producto"=>$producto,
        ":referencia"=>$referencia,
        ":precio"=>$precio,
        ":peso"=>$peso,
        ":categoria"=>$categoria,
        ":stock"=>$cantidad,
        ":fecha"=>$fecha,
        ":usuario"=>$usuario
      
  
    ];
    //var_dump($guardar_producto);
    $guardar_producto->execute($marcadores);
      
    if($guardar_producto->rowCount()==1){
        echo '
        <div class="notification is-info is-light">
            <strong>PRODUCTO REGISTRADO!</strong><br>
            El producto a sido registrado exitosamente.
        </div>
        ';
    }else{
        echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No se pudo registrar el producto, por favor intente nuevmente.
        </div>
    ';
    }
    $guardar_producto=null;

    
?>

