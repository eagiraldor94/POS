<header class="main-header">
	
	<!-- sidebar -->

  <aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Brand Logo -->

    <a href="inicio" class="brand-link">
      <img src="Views/img/plantilla/AF_FAVICON-01.png" alt="Logotipo_Esforza" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Sistema POS</span>
    </a>
    <div class="sidebar">

    	<!-- sidebar-menu -->

		<nav class="mt-2">
        	<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

    	<!-- User panel -->

    		<li class="nav-item has-treeview" id="inicioTree">
            	<a href="inicio" class="nav-link" id="inicio">
              <?php 
                if($_SESSION['photo'] != ""){
                  echo '<img src="'.$_SESSION['photo'].'" class="nav-icon" alt="User Image">';
                }else{
                  echo '<img src="Views/img/usuarios/anonymous.png" class="nav-icon" alt="User Image">';
                }
               ?>
		         	
		            <p>
		              <?php echo $_SESSION['name'] ?>
		              <i class="right fa fa-angle-left"></i>
		            </p>
            	</a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link btnEditarMain" idUsuario="<?php echo $_SESSION['id'] ?>" data-toggle="modal" data-target="#modalEditarMain">
                  <i class="fa fa-key nav-icon"></i>
                  <p>Editar</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="usuario-salir" class="nav-link">
                  <i class="fa fa-times-circle nav-icon"></i>
                  <p>Salir</p>
                </a>
              </li>
            </ul>
          </li>
          <?php
        if ($_SESSION['rank']=='Admin') { 
          echo '
          <li class="nav-item has-treeview" id="reportesTree">
            <a href="#" class="nav-link" id="reportes">
              <i class="nav-icon fa fa-chart-line"></i>
              <p>
                Informes
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="reportes" class="nav-link" id="reportesGenerales">
                  <i class="fa fa-dot-circle nav-icon"></i>
                  <p>Informes Generales</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="informes-productos" class="nav-link" id="reportesPorProducto">
                  <i class="fa fa-dot-circle nav-icon"></i>
                  <p>Ventas por producto</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="informes-clientes" class="nav-link" id="reportesPorCliente">
                  <i class="fa fa-dot-circle nav-icon"></i>
                  <p>Ventas por cliente</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="usuarios" class="nav-link" id="usuarios">
              <i class="nav-icon fa fa-user"></i>
              <p>Usuarios</p>
            </a>
          </li>';
        }
        if ($_SESSION['rank']=='Admin' || $_SESSION['rank']=='Vendedor') { 
          echo '
          <li class="nav-item">
            <a href="categorias" class="nav-link" id="categorias">
              <i class="nav-icon fa fa-th"></i>
              <p>Categorias de Productos</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="productos" class="nav-link" id="productos">
              <i class="nav-icon fa fa-shopping-cart"></i>
              <p>Productos</p>
            </a>
          </li>';
        }
        ?>
          <li class="nav-item">
            <a href="clientes" class="nav-link" id="clientes">
              <i class="nav-icon fa fa-users"></i>
              <p>Clientes</p>
            </a>
          </li>
          <li class="nav-item has-treeview" id="ventasTree">
            <a href="#" class="nav-link" id="ventas">
              <i class="nav-icon fa fa-list"></i>
              <p>
                Ventas
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="ventas-administrar" class="nav-link" id="ventasAdmin">
                  <i class="fa fa-dot-circle nav-icon"></i>
                  <p>Administrar Ventas</p>
                </a>
              </li>
          <?php 
          if ($_SESSION['rank']=='Admin' || $_SESSION['rank']=='Vendedor') { 
            echo '
              <li class="nav-item">
                <a href="ventas-crear" class="nav-link" id="crearVenta">
                  <i class="fa fa-dot-circle nav-icon"></i>
                  <p>Crear Venta</p>
                </a>
              </li>';
            }
            if ($_SESSION['rank']=='Admin' || $_SESSION['rank']=='Contador') { 
              echo '
              <li class="nav-item">
                <a href="resoluciones" class="nav-link" id="resAdmin">
                  <i class="fa fa-dot-circle nav-icon"></i>
                  <p>Administrar resoluciones</p>
                </a>
              </li>';
            }
              ?>

            </ul>
          </li>
            <?php 
            if ($_SESSION['rank']=='Admin') { 
              echo '
          <li class="nav-item">
            <a href="proveedores" class="nav-link" id="proveedores">
              <i class="nav-icon fa fa-book"></i>
              <p>Proveedores</p>
            </a>
          </li>';
          }
          ?>    	
        </ul>
      </nav>

    </div>

   
  </aside>
	
</header>