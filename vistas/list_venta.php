<div class="container is-fluid mb-6">
    <h1 class="title">Ventas</h1>
    <h2 class="subtitle">Lista de Ventas</h2>
</div>
<?php
require_once "./php/main.php";
    if(isset($_POST['modulo_buscador'])){
        require_once "./php/buscador.php";
    }
?>
<div class="container pb-6 pt-6">
    <div class="columns">
        <div class="column">
            <form action="./php/buscador.php" method="POST" autocomplete="off">
                <input type="hidden" name="modulo_buscador" value="venta">
                <div class="field is-grouped">
                    <p class="control is-expanded">
                        <input class="input is-rounded" type="text" name="txt_buscador" placeholder="Que esta buscando?"
                        pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" maxlength="30">
                    </p>
                    <P class="control">
                        <button class="button is-info" type="submit">Buscar </button>
                    </P>
                </div>
            </form>
        </div>
    </div>    
    <?php
        require_once "./php/main.php";
        if(isset($_GET['produc_del'])){
            require_once "./php/eliminar_producto.php";
        }
        if(!isset($_GET['page'])){
            $pagina =1;
        }else{
            $pagina=(int) $_GET['page'];
            if($pagina<=1){
                $pagina=1;
                
            }
        }

        $pagina=limpiarCadena($pagina);
        $url="index.php?vista=list_venta&page=";
        $registros=15;
        $busqueda="";

        require_once "./php/lista_venta.php";
    ?>
  

</div>