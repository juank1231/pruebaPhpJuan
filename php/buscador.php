<?php
    $modulo_buscador=limpiarCadena($_POST['modulo_buscador']);

    $modulos =["usuario","venta","productos"];

    if(in_array($modulo_buscador,$modulos)){
        $modulos_url=[
            "usuario"=>"user_list",
            "venta"=>"venta_list",
            "productos"=>"list_product",
        ];
        $modulos_url=$modulos_url[$modulo_buscador];

        $modulo_buscador="busqueda_".$modulo_buscador;

        if(isset($_POST['txt_buscador'])){
            $txt=limpiarCadena($_POST['txt_buscador']);

            if($txt==""){
                echo '
                    <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                        Introduce un termino de busqueda
                    </div>
                ';
            }else{
                if(verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}",$txt)){
                    echo '
                    <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                        El termino de busqueda no coincide con el formato solicitado 
                    </div>
                '; 
                }else{
                    $_SESSION[$modulo_buscador]=$txt;
                    header("Location: index.php?vista=$modulos_url",true,303);
                    exit();
                }
            }
        }
    }else{
        echo '
            <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
                No podemos procesar la peticion
            </div>
        ';
     
    }
?>