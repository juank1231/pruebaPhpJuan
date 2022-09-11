<?php

    $inicio = ($pagina>0) ? (($pagina*$registros)-$registros) : 0;
    $tabla="";

    if(isset($busqueda) && $busqueda!=""){
        $consulta_datos="SELECT * FROM ventas_producto WHERE ((nombre_producto LIKE '%$busqueda%' 
        OR referencia LIKE '%$busqueda%' OR categoria LIKE '%$busqueda%' OR fecha_creacion LIKE '%$busqueda%'
        OR precio LIKE '%$busqueda%' OR peso LIKE '%$busqueda%')) 
        ORDER BY nombre_producto ASC LIMIT $inicio,$registros";

        $consulta_total="SELECT count(id) FROM ventas_producto WHERE((nombre_producto LIKE '%$busqueda%' OR referencia LIKE '%$busqueda%'
        OR categoria LIKE '%$busqueda%' OR precio LIKE '%$busqueda%' OR fecha_creacion LIKE '%$busqueda%')) ";
    }else{
        $consulta_datos="SELECT * FROM ventas_producto where true
        ORDER BY id_venta ASC LIMIT $inicio,$registros";

        $consulta_total="SELECT count(id_venta) FROM ventas_producto";
    }
    //var_dump($consulta_datos);
    $conexion = conexion();

    $datos =  $conexion ->query($consulta_datos);
    $datos = $datos->fetchAll();

    $total = $conexion->query($consulta_total);
    $total = (int) $total->fetchColumn();

    $Npaginas=ceil($total/$registros);

    $tabla.='
    <div class="table-container">
        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
            <thead>
                <tr class="has-text-centered">
                    <th>ID Venta</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Valor Venta</th>
                    <th>Usuario Venta</th>
                    <th>Fecha Venta</th>                    
                    
                </tr>
            </thead>
            <tbody>
    
    ';
    if($total>=1 && $pagina<=$Npaginas){
        $contador=$inicio+1;
        $pag_inicio=$inicio+1;
        foreach($datos as $rows){
            $producto="";
            if($rows['id_producto']!=""){
                $productoa=("SELECT nombre_producto FROM productos where id='".$rows['id_producto']."'");
                $conexion1 = conexion();

                $datos1 =  $conexion1 ->query($productoa);
                $datos1 = $datos1->fetchAll();
                foreach($datos1 as $rows1){
                $producto=$rows1['nombre_producto'];
                }
            }
            $usuario="";
            if($rows['usuario_venta']!=""){
                $productos=("SELECT usuario_nombre,usuario_apellido FROM usuarios where usuario_id='".$rows['usuario_venta']."'");
                $conexion1 = conexion();

                $datos11 =  $conexion1 ->query($productos);
                $datos11 = $datos11->fetchAll();
                foreach($datos11 as $rows11){
                $usuario=$rows11['usuario_nombre'];
                }
            }
            $tabla.='
            <tr class="has-text-centered" >
                <td>'.$rows['id_venta'].'</td>
                <td>'.$producto.'</td>
                <td>'.$rows['cantidad'].'</td>
                <td>$'.number_format($rows['precio_total']).'</td>
                <td>'.$usuario.'</td>
                <td>'.$rows['fecha_venta'].'</td>
                
            </tr>   
            ';
            $contador++;
        }
        $pag_final=$contador-1;
    }else{
        if($total>=1){
            $tabla.='
            <tr class="has-text-centered" >
                <td colspan="7">
                    <a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
                        Haga clic acá para recargar el listado
                    </a>
                </td>
            </tr>
            ';
        }else{
            $tabla.='
            <tr class="has-text-centered" >
                <td colspan="7">
                    No hay registros en el sistema
                </td>
            </tr>
            ';
        }
    }

    $tabla.='</tbody></table></div>';

    if($total>=1 && $pagina<=$Npaginas){
        $tabla.=' <p class="has-text-right">Mostrando Ventas <strong>'.
        $pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un 
        <strong>total de '.$total.'</strong></p>';
    }


    $conexion=null;
    echo $tabla;
    if($total>=1 && $pagina<=$Npaginas){
        echo paginador_tablas($pagina,$Npaginas,$url,7);
    }
?>





