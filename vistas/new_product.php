<div class="container is-fluid mb-6">
	<h1 class="title">Productos</h1>
	<h2 class="subtitle">Nuevo producto</h2>
</div>
<div class="container pb-6 pt-6">

	<div class="form-rest mb-6 mt-6"></div>

	<form action="./php/producto_guardar.php" method="POST" class="FormularioAjaxj" autocomplete="off" >
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Nombre Producto</label>
				  	<input class="input" type="text" name="nombre_producto" pattern="[a-zA-Z0-9]{3,40}" maxlength="40" required >
				  	<input class="input" type="hidden" name="usuarioc" value="<?php echo $_SESSION['id']; ?>" >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Referencia</label>
				  	<input class="input" type="text" name="referencia" pattern="[a-zA-Z0-9]{3,40}" maxlength="40" required >
				</div>
		  	</div>
		</div>
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Precio</label>
				  	<input class="input" type="number" name="precio" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Peso(gr)</label>
				  	<input class="input" type="number" name="peso" required>
				</div>
		  	</div>
		</div>
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Categoria</label>
				  	<input class="input" type="text" name="categoria" pattern="[a-zA-Z0-9]{3,40}" maxlength="50" required >
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
			<button type="submit" class="button is-info is-rounded">Guardar</button>
		</p>
	</form>
</div>
