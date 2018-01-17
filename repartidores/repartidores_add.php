<?php
	$sec = "repartidores";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>El Comprador - Lliuradors</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>

<?php

 include_once "../includes/header.php"; 
 include_once "../includes/conexion.php"; 

if(isset($_POST['btn-save']))
{
 // variables ingreso datos
 $nombre = $_POST['nombre'];
 $tlf = $_POST['tlf'];
 $activo = isset($_POST['activo']) ? 1 : 0;
 $vacaciones = isset($_POST['vacaciones']) ? 1 : 0;
 $baja_laboral = isset($_POST['baja_laboral']) ? 1 : 0;
 // fin variables ingreso datos
 
 // sql para insertar
 $sql_query = "INSERT INTO lliuradors(nom,tlf,actiu,vacances,baixa_laboral)
               VALUES('$nombre','$tlf','$activo','$vacaciones','$baja_laboral')";
 // sql para insertar
 
 // ejecutar sql query
 if(mysql_query($sql_query))
 {

  ?>
  
  <script type="text/javascript">
    alert('Les dades s’han actualtzat correctament');
    window.location.href='/gestio/lliuradors/repartidores/repartidores.php';
  </script>
  <?php
 }
 else
 {
  ?>
  <script type="text/javascript">
  alert('Error en actualitzar les dades');
  </script>
  <?php
 }
 // fin ejecutar sql query
}
?>

<body>

<center>

<div>
 <div class="clearfix"></div>
 <div class="container-fluid"> <h4>EL COMPRADOR - AFEGIR LLIURADOR</h4> </div>
</div>

<div class="clearfix"></div>
 <div class="container-fluid">
 
 <td></td>
   <form method="post">
    <table class="table-condensed" align="center">
    
	<tr>
		<td class="form-group">
			<label for="usr">Nom:</label>
			<input type="text" class="form-control" name="nombre" placeholder="Nom" required>
		</td>

		<td class="form-group">
			<label for="usr">Tel&eacute;fon:</label>
			<input type="text" class="form-control" name="tlf" placeholder="Tel&eacute;fon" required>
		</td>
	</tr>
	
	<tr>
		<td class="checkbox">
			<label><input type="checkbox" name="activo" value="" checked="">Actiu</label>
		</td>
	<tr>

	
	<tr>
		<td class="checkbox">
			<label><input type="checkbox" name="vacaciones" value="">Vacances</label>
		</td>
	<tr>
	
	
	<tr>
		<td class="checkbox">
			<label><input type="checkbox" name="baja_laboral" value="">Baixa Laboral</label>
		</td>
	<tr>
	
	
	<td>
	  <button class="btn btn-large btn-primary" name='btn-save'><i class="glyphicon glyphicon-save"></i> &nbsp; <strong>GUARDAR</strong></button>
      <a href="repartidores.php" class="btn btn-large btn-warning" role="button"><i class="glyphicon glyphicon-arrow-left"></i> &nbsp;<strong>Cancelar</a></strong>
	</td>
	
    </tr>
    </table>
    </form>
    </div>
</div>
</center>
</body>
</html>