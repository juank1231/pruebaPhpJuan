<nav class="navbar" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
    <a class="navbar-item" href="index.php?vista=home">
      <img src="./img/logo.png" width="112" height="28">
    </a>

    <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>

  <div id="navbarBasicExample" class="navbar-menu">
    <div class="navbar-start">
   
      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link">
          Usuarios
        </a>
        <div class="navbar-dropdown">
            <a class="navbar-item" href="index.php?vista=user_new">Nuevo</a>
            <a class="navbar-item" href="index.php?vista=user_list">Lista</a>
        </div>
      </div>
      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link">
          Productos
        </a>
        <div class="navbar-dropdown">
            <a class="navbar-item" href="index.php?vista=new_product">Agregar</a>
            <a class="navbar-item" href="index.php?vista=list_product">Lista</a>
        </div>
       
      </div>
      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link">
          Ventas
        </a>
        <div class="navbar-dropdown">
            <a class="navbar-item" href="index.php?vista=new_venta">Nueva Venta</a>
            <a class="navbar-item" href="index.php?vista=list_venta">Lista</a>
        </div>
      </div>
    </div>

    <div class="navbar-end">
      <div class="navbar-item">
        <div class="buttons">
          <a href="index.php?vista=user_update&user_id=<?php echo $_SESSION['id']; ?>" class="button is-primary is-rounded">
            Mi cuenta
          </a>
          <a href="index.php?vista=logout" class="button is-light is-rounded">
            Salir
          </a>
        </div>
      </div>
    </div>
  </div>
</nav>