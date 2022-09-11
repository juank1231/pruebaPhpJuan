<?php
    require_once "./main.php";

    #almacenar datos

    $producto = limpiarCadena($_POST['producto']);
    $cantidad = limpiarCadena($_POST['cantidad']);
    $usuario = limpiarCadena($_POST['usuarioc']);

  


    #verificar datos obligatorios #
    if($producto=="" || $cantidad==""){
        echo '
            <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }



    # validando PRODUCTO ## 

    
    $check_producto=conexion();
    $consult=("SELECT id,nombre_producto,referencia,precio,stock FROM productos 
    WHERE id='$producto'");
    $datoss=$check_producto->query($consult);
    $datoss=$datoss->fetchAll();
    foreach($datoss as $rows){
        $stock =$rows['stock'];
        $precio=$rows['precio'];
    }
    //var_dump($stock);
    
    
    $cantidadto=0;
    $stockfin=0;
    

    if($stock<=0){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El PRODUCTO no tiene unidades disponibles
            </div>
        ';
        exit();
    }else{
        if($stock<$cantidad){
            echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La cantidad que ingreso supera el stock disponible, hay disponibles "'.$stock.'" unidades.
            </div>
        ';
        exit();
        }else{
        $cantidadto=$precio*$cantidad;
        $stockfin=$stock-$cantidad;
        }
        
    }
    $check_producto=null;       
        
    # una ves verificado empiezo a guardar la venta
    $guardar_producto=conexion();
    $guardar_producto= $guardar_producto->prepare("INSERT INTO ventas_producto(id_producto,cantidad,precio_total,usuario_venta,fecha_venta)
    VALUES(:producto,:cantidad,:precio,:usuario,:fecha)");
    $fecha = date("Y-m-d");
    $marcadores=[
        ":producto"=>$producto,
        ":cantidad"=>$cantidad,
        ":precio"=>$cantidadto,
        ":usuario"=>$usuario,       
        ":fecha"=>$fecha
      
  
    ];
 
    $guardar_producto->execute($marcadores);
        //var_dump($marcadores);
     
    if($guardar_producto->rowCount()==1){
        
        $guardar_producto1=conexion();
        $guardar_producto1= $guardar_producto1->query("UPDATE productos SET stock='$stockfin' where id='$producto'");
        echo '
        <div class="notification is-info is-light">
            <strong>VENTA REALIZADA!</strong><br>
            El producto a sido registrado exitosamente.
        </div>
        ';
    }else{
        echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No se pudo registrar la venta, por favor intente nuevamente.
        </div>
    ';
    }
    $guardar_producto=null;

    
?>

