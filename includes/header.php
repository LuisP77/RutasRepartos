<!DOCTYPE html>
<html>
<head>
  <title>Encabezado</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <style>
  /* Note: Try to remove the following lines to see the effect of CSS positioning */
  .affix {
      top: 0;
      width: 100%;
  }

  .affix + .container-fluid {
      padding-top: 20px;
  }
  </style>
</head>
<body>
<nav class="navbar navbar-inverse" >
  <ul class="nav navbar-nav">
  
<?php if ($sec=="inicio"){
echo	'<li class="active"><a href="/gestio/lliuradors/index.php"><img src="/gestio/lliuradors/img/logo.png" alt="elcomprador.cat" style="width:100px;height:20px;"></a></li>
		<li><a href="/gestio/lliuradors/repartidores/repartidores.php"><span class="glyphicon glyphicon-user"></span> LLIURADORS </a></li>
		<li><a href="/gestio/lliuradors/furgonetas/furgonetas.php"><span class="glyphicon glyphicon-bed"> FURGONETES </a></li>
		<li><a href="/gestio/lliuradors/crear_rutas/crear_rutas.php"><span class="glyphicon glyphicon-random"> CREAR RUTES </a></li>
		<li><a href="/gestio/lliuradors/historic/historic.php"><span class="glyphicon glyphicon-level-up"> HISTÒRIC </a></li>
		<li><a href="/gestio/lliuradors/estadisticas/estadisticas.php"><span class="glyphicon glyphicon-stats"> ESTADÍSTIQUES </a></li>';
	}
	
    if ($sec=="repartidores"){
echo	'<li><a href="/gestio/lliuradors/index.php"><img src="/gestio/lliuradors/img/logo.png" alt="elcomprador.cat" style="width:100px;height:20px;"></a></li>
		<li class="active"><a href="/gestio/lliuradors/repartidores/repartidores.php"><span class="glyphicon glyphicon-user"></span> LLIURADORS </a></li>
		<li><a href="/gestio/lliuradors/furgonetas/furgonetas.php"><span class="glyphicon glyphicon-bed"> FURGONETES </a></li>
		<li><a href="/gestio/lliuradors/crear_rutas/crear_rutas.php"><span class="glyphicon glyphicon-random"> CREAR RUTES </a></li>
		<li><a href="/gestio/lliuradors/historic/historic.php"><span class="glyphicon glyphicon-level-up"> HISTÒRIC </a></li>
		<li><a href="/gestio/lliuradors/estadisticas/estadisticas.php"><span class="glyphicon glyphicon-stats"> ESTADÍSTIQUES </a></li>';
	}
	
	if ($sec=="furgonetas"){
echo	'<li><a href="/gestio/lliuradors/index.php"><img src="/gestio/lliuradors/img/logo.png" alt="elcomprador.cat" style="width:100px;height:20px;"></a></li>
		<li><a href="/gestio/lliuradors/repartidores/repartidores.php"><span class="glyphicon glyphicon-user"></span> LLIURADORS </a></li>
		<li class="active"><a href="/gestio/lliuradors/furgonetas/furgonetas.php"><span class="glyphicon glyphicon-bed"></span> FURGONETES </a></li>
		<li><a href="/gestio/lliuradors/crear_rutas/crear_rutas.php"><span class="glyphicon glyphicon-random"> CREAR RUTES </a></li>
		<li><a href="/gestio/lliuradors/historic/historic.php"><span class="glyphicon glyphicon-level-up"> HISTÒRIC </a></li>
		<li><a href="/gestio/lliuradors/estadisticas/estadisticas.php"><span class="glyphicon glyphicon-stats"> ESTADÍSTIQUES </a></li>';
	}
	
	if ($sec=="crear_rutas"){
echo	'<li><a href="/gestio/lliuradors/index.php"><img src="/gestio/lliuradors/img/logo.png" alt="elcomprador.cat" style="width:100px;height:20px;"></a></li>
		<li><a href="/gestio/lliuradors/repartidores/repartidores.php"><span class="glyphicon glyphicon-user"></span> LLIURADORS </a></li>
		<li><a href="/gestio/lliuradors/furgonetas/furgonetas.php"><span class="glyphicon glyphicon-bed"></span> FURGONETES </a></li>
		<li class="active"><a href="/gestio/lliuradors/crear_rutas/crear_rutas.php"><span class="glyphicon glyphicon-random"> CREAR RUTES </a></li>
		<li><a href="/gestio/lliuradors/historic/historic.php"><span class="glyphicon glyphicon-level-up"> HISTÒRIC </a></li>
		<li><a href="/gestio/lliuradors/estadisticas/estadisticas.php"><span class="glyphicon glyphicon-stats"> ESTADÍSTIQUES </a></li>';
	}

	if ($sec=="historic"){
echo	'<li><a href="/gestio/lliuradors/index.php"><img src="/gestio/lliuradors/img/logo.png" alt="elcomprador.cat" style="width:100px;height:20px;"></a></li>
		<li><a href="/gestio/lliuradors/repartidores/repartidores.php"><span class="glyphicon glyphicon-user"></span> LLIURADORS </a></li>
		<li><a href="/gestio/lliuradors/furgonetas/furgonetas.php"><span class="glyphicon glyphicon-bed"> FURGONETES </a></li>
		<li><a href="/gestio/lliuradors/crear_rutas/crear_rutas.php"><span class="glyphicon glyphicon-random"> CREAR RUTES </a></li>
		<li class="active"><a href="/gestio/lliuradors/historic/historic.php"><span class="glyphicon glyphicon-level-up"> HISTÒRIC </a></li>
		<li><a href="/gestio/lliuradors/estadisticas/estadisticas.php"><span class="glyphicon glyphicon-stats"> ESTADÍSTIQUES </a></li>';
	}
	
	if ($sec=="estadisticas"){
echo	'<li><a href="/gestio/lliuradors/index.php"><img src="/gestio/lliuradors/img/logo.png" alt="elcomprador.cat" style="width:100px;height:20px;"></a></li>
		<li><a href="/gestio/lliuradors/repartidores/repartidores.php"><span class="glyphicon glyphicon-user"></span> LLIURADORS </a></li>
		<li><a href="/gestio/lliuradors/furgonetas/furgonetas.php"><span class="glyphicon glyphicon-bed"> FURGONETES </a></li>
		<li><a href="/gestio/lliuradors/crear_rutas/crear_rutas.php"><span class="glyphicon glyphicon-random"> CREAR RUTES </a></li>
		<li><a href="/gestio/lliuradors/historic/historic.php"><span class="glyphicon glyphicon-level-up"> HISTÒRIC </a></li>
		<li class="active"><a href="/gestio/lliuradors/estadisticas/estadisticas.php"><span class="glyphicon glyphicon-stats"> ESTADÍSTIQUES </a></li>';
	}
?>
  </ul>
</nav>
</body>
</html>