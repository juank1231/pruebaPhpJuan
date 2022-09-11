<?php

    require_once "../inc/start_session.php";
    require_once "./main.php";

   
     #almacenar datos
    $id=limpiarCadena($_POST['usuario_id']);
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
    # agregar stock
    $check_producto=conexion();
    $consult=("SELECT id,nombre_producto,referencia,precio,stock FROM productos 
    WHERE id='$producto'");
    $datoss=$check_producto->query($consult);
    $datoss=$datoss->fetchAll();
    $suma=0;
    $cantidades=0;
    if($cantidad<0){
        echo '
            <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
           El stock no puede ingresarse con numero negativo
            </div>
        ';
        exit();
    }
    if($cantidad!=""){

        $check_stock1= conexion();
        $check_stock=("SELECT stock FROM productos WHERE id='$id'");
        $datos=$check_stock1->query($check_stock);
        $datos=$datos->fetchAll();
        foreach($datos as $rows){
            $suma=$rows['stock'];
        }
        
        $cantidades = $suma+$cantidad;
        $check_stock1=null;
        //var_dump($cantidad) ;   
    }else{
        $check_stock12= conexion();
        $check_stock1=("SELECT stock FROM productos WHERE id='$id'");
        $datoss=$check_stock12->query($check_stock1);
        $datoss=$datoss->fetchAll();
        foreach($datoss as $rows){
            $suma=$rows['stock'];
        }
        $cantidades=$suma;
    }
    #Actualiza datos
    $actualiza_datos = conexion();
    $actualiza_datos = $actualiza_datos->prepare("UPDATE productos SET nombre_producto=:producto,referencia=:referencia,
    precio=:precio,peso=:peso,categoria=:categoria,stock=:cantidad, fecha_creacion=:fecha,usuario_id=:usuario  WHERE id=:id"); 

    $fecha = date("Y-m-d");
    $marcadores=[
        ":producto"=>$producto,
        ":referencia"=>$referencia,
        ":precio"=>$precio,
        ":peso"=>$peso,
        ":categoria"=>$categoria,
        ":cantidad"=>$cantidades,
        ":fecha"=>$fecha,
        ":usuario"=>$usuario,
        ":id"=>$id
      
  
    ];
    //var_dump($marcadores);
    if($actualiza_datos->execute($marcadores)){
        echo '
            <div class="notification is-info is-light">
                <strong>¡PRODUCTO ACTUALIZADO!</strong><br>
                El producto se actualizo correctamente
            </div>
        ';
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo actualizar, por favor intente nuevamente.
            </div>
        ';
    }
    $actualiza_datos=null;
?>
