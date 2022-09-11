<?php
    require_once "./php/main.php";

    $id=(isset($_GET['idpro'])) ? $_GET['idpro']: 0;
    $id=limpiarCadena($id);
?>
<div class="container is-fluid mb-6">   
    <h1 class="title">Productos</h1>
    <h2 class="subtitle">Actualizar productos</h2>  
</div>

<div class="container pb-6 pt-6">

    <?php 
    include "./inc/btn_atras.php"; 

    $check_productos=conexion();
    $check_productos=$check_productos->query("SELECT * FROM productos WHERE id='$id'");

    if($check_productos->rowCount()>0){
        $datos=$check_productos->fetch();
    ?>
	<div class="container pb-6 pt-6">

        <div class="form-rest mb-6 mt-6"></div>

        <form action="./php/" method="POST" class="FormularioAjaxj" autocomplete="off" >
            <div class="columns">
                <div class="column">
                    <div class="control">
                        <label>Nombre Producto</label>
                        <input class="input" type="text" name="nombre_producto" value="<?php echo $datos['nombre_producto']; ?>" pattern="[a-zA-Z0-9]{3,40}" maxlength="40" required >
                        <input class="input" type="hidden" name="usuarioc" value="<?php echo $_SESSION['id']; ?>" >
                        <input type="hidden" name="usuario_id" value="<?php echo $datos['id']; ?>" required >
                    </div>
                </div>
                <div class="column">
                    <div class="control">
                        <label>Referencia</label>
                        <input class="input" type="text" value="<?php echo $datos['referencia']; ?>" name="referencia" pattern="[a-zA-Z0-9]{3,40}" maxlength="40" required >
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column">
                    <div class="control">
                        <label>Precio</label>
                        <input class="input" type="number" value="<?php echo $datos['precio']; ?>" name="precio" required >
                    </div>
                </div>
                <div class="column">
                    <div class="control">
                        <label>Peso(gr)</label>
                        <input class="input" type="number" value="<?php echo $datos['peso']; ?>" name="peso" required>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column">
                    <div class="control">
                        <label>Categoria</label>
                        <input class="input" type="text" value="<?php echo $datos['categoria']; ?>" name="categoria" pattern="[a-zA-Z0-9]{3,40}" maxlength="50" required >
                    </div>
                </div>
                <div class="column">
                    <div class="control">
                        <label>Stock Actual</label>
                        <input class="input" disabled type="number" value="<?php echo $datos['stock']; ?>">
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column">
                    <div class="control">
                        <label>Stock a adicionar</label>
                        <input class="input" type="number"  name="cantidad">
                    </div>
                </div>
              
            </div>
            <p class="has-text-centered">
                <button type="submit" class="button is-info is-rounded">Guardar</button>
            </p>
        </form>
        </div>
	<?php
    }else{
        include "./inc/error_alert.php";
    }
    $check_usuarios=null;
    ?>
</div>