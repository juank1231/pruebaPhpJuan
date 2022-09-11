<?php

    $inicio = ($pagina>0) ? (($pagina*$registros)-$registros) : 0;
    $tabla="";
    
    if(isset($_POST['txt_buscador']) && $_POST['txt_buscador']!=""){
        $busqueda = $_POST['txt_buscador'];
        $consulta_datos="SELECT * FROM productos WHERE ((nombre_producto LIKE '%$busqueda%' 
        OR referencia LIKE '%$busqueda%' OR categoria LIKE '%$busqueda%' OR fecha_creacion LIKE '%$busqueda%'
        OR precio LIKE '%$busqueda%' OR peso LIKE '%$busqueda%')) 
        ORDER BY nombre_producto ASC LIMIT";

        $consulta_total="SELECT count(id) FROM productos WHERE((nombre_producto LIKE '%$busqueda%' OR referencia LIKE '%$busqueda%'
        OR categoria LIKE '%$busqueda%' OR precio LIKE '%$busqueda%' OR fecha_creacion LIKE '%$busqueda%')) ";
    }else{
        $consulta_datos="SELECT * FROM productos where true
        ORDER BY nombre_producto ASC LIMIT $inicio,$registros";

        $consulta_total="SELECT count(id) FROM productos";
    }
    var_dump($consulta_datos);
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
                    <th>ID</th>
                    <th>Nombre del producto</th>
                    <th>Referencia</th>
                    <th>Precio</th>
                    <th>Peso</th>
                    <th>Categoria</th>
                    <th>Stock</th>
                    <th>Fecha de Crecion</th>
                    <th colspan="2">Opciones</th>
                </tr>
            </thead>
            <tbody>
    
    ';
    if($total>=1 && $pagina<=$Npaginas){
        $contador=$inicio+1;
        $pag_inicio=$inicio+1;
        foreach($datos as $rows){
            $tabla.='
            <tr class="has-text-centered" >
                <td>'.$rows['id'].'</td>
                <td>'.$rows['nombre_producto'].'</td>
                <td>'.$rows['referencia'].'</td>
                <td>'.$rows['precio'].'</td>
                <td>'.$rows['peso'].'</td>
                <td>'.$rows['categoria'].'</td>
                <td>'.$rows['stock'].'</td>
                <td>'.$rows['fecha_creacion'].'</td>
                <td>
                    <a href="index.php?vista=product_update&idpro='.$rows['id'].'" class="button is-success is-rounded is-small">Actualizar</a>
                </td>
                <td>
                    <a href="'.$url.$pagina.'&produc_del='.$rows['id'].'" class="button is-danger is-rounded is-small">Eliminar</a>
                </td>
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
        $tabla.=' <p class="has-text-right">Mostrando usuarios <strong>'.
        $pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un 
        <strong>total de '.$total.'</strong></p>';
    }


    $conexion=null;
    echo $tabla;
    if($total>=1 && $pagina<=$Npaginas){
        echo paginador_tablas($pagina,$Npaginas,$url,7);
    }
?>





