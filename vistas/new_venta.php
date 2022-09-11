<div class="container is-fluid mb-6">
	<h1 class="title">Ventas</h1>
	<h2 class="subtitle">Nueva venta</h2>
</div>
<div class="container pb-6 pt-6">

	<div class="form-rest mb-6 mt-6"></div>

	<form action="./php/venta_guardar.php" method="POST" class="FormularioAjaxj" autocomplete="off" >
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Producto</label>
				  	<select class="input" name="producto"required >
                        <option value="">Seleccione</option>
                        <?php
                            //$check_stock1= conexion();
                            $conn = new PDO('mysql:host=localhost;dbname=cafeteria_konecta','root','');
                            $result=$conn->query("SELECT id,nombre_producto FROM productos");
                          
                            while ($row = $result->fetch()) {
                                //print "<p>Name: {$row[0]} {$row[1]}</p>";
                                echo '<option value='.$row["id"].'>'.$row["nombre_producto"].'</option>';
                              }
                          
                        ?>
                    </select>
				  	<input class="input" type="hidden" name="usuarioc" value="<?php echo $_SESSION['id']; ?>" >
				</div>
		  	</div>
            <div class="column">
		    	<div class="control">
					<label>Cantidad</label>
				  	<input class="input" type="number" name="cantidad" required >
				</div>
		  	</div>
		  
		</div>
	

     
		<p class="has-text-centered">
			<button type="submit" class="button is-info is-rounded">Enviar</button>
		</p>
	</form>
</div>
