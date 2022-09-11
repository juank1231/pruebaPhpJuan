<?php 

    $user_id_del=limpiarCadena($_GET['user_id_del']);

    # Verificar el usuario #

    $check_usuario= conexion();
    $check_usuario=$check_usuario->query("SELECT usuario_id FROM usuarios WHERE usuario_id='$user_id_del'");
    if($check_usuario->rowCount()==1){
        $check_productos=conexion();
        $check_productos=$check_productos->query("SELECT usuario_id FROM usuarios WHERE usuario_id='$user_id_del' limit 1");
        
        if($check_productos->rowCount()<=1){
            $eliminar_usuario=conexion();
            $eliminar_usuario=$eliminar_usuario->prepare("DELETE FROM usuarios WHERE usuario_id=:id");

            $eliminar_usuario ->execute([":id"=>$user_id_del]);

            if($eliminar_usuario->rowCount()==1){
                echo '
                <div class="notification is-info is-light">
                <strong>¡Usuario eliminado!</strong><br>
                    Se ha eliminado el usuario
                </div>
            ';
            }else{
                echo '
                <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                    Nose pudo eliminar el usuario, por favor intente nuevamente
                </div>
            ';
            }
            $eliminar_usuario=null;
        }else{
            echo '
            <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
                No podemos eliminar el usuario ya que tiene productos registrados
            </div>
        ';
        }
        $check_productos=null;        
    }else{
        echo '
            <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
                El usuario que intenta eliminar no existe
            </div>
        ';
    }
    $check_usuario=null;
?>