<?php 

    $produc_del=limpiarCadena($_GET['produc_del']);

    # Verificar el producto #

    $check_producto= conexion();
    $check_producto=$check_producto->query("SELECT id FROM productos WHERE id='$produc_del'");
    if($check_producto->rowCount()==1){
        
            $eliminar_producto=conexion();
            $eliminar_producto=$eliminar_producto->prepare("DELETE FROM productos WHERE id=:id");

            $eliminar_producto ->execute([":id"=>$produc_del]);

            if($eliminar_producto->rowCount()==1){
                echo '
                <div class="notification is-info is-light">
                <strong>Producto eliminado!</strong><br>
                    Se ha eliminado el producto
                </div>
            ';
            }else{
                echo '
                <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                    Nose pudo eliminar el producto, por favor intente nuevamente
                </div>
            ';
            }
            $eliminar_producto=null;
        }else{
            echo '
            <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
                No podemos eliminar el producto
            </div>
        ';
        }
        $check_productos=null;        
  
?>