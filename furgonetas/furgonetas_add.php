<?php
	$sec = "furgonetas";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>El Comprador - Furgonetes</title>
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
 $matricula = $_POST['matricula'];
 $marca = $_POST['marca'];
 $modelo = $_POST['modelo'];
 $volumen = $_POST['volumen'];
 $largo = $_POST['largo'];
 $ancho = $_POST['ancho'];
 $alto = $_POST['alto'];
 $taller = isset($_POST['taller']) ? 1 : 0;
 $activo = isset($_POST['activo']) ? 1 : 0;
 // fin variables ingreso datos
 
 // sql para insertar
 $sql_query = "INSERT INTO furgonetes(nom,matricula,marca,model,volum,llarg,ample,alt,taller,actiu)
               VALUES('$nombre','$matricula','$marca','$modelo','$volumen','$largo','$ancho','$alto','$taller','$activo')";
 // sql para insertar
 
 // ejecutar sql query
 if(mysql_query($sql_query))
 {

  ?>
  
  <script type="text/javascript">
    alert('Les dades s’han guardat correctament');
    window.location.href='/gestio/lliuradors/furgonetas/furgonetas.php';
  </script>
  <?php
 }
 else
 {
  ?>
  <script type="text/javascript">
  alert('Error al guardar les dades');
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
 <div class="container-fluid"> <h4>EL COMPRADOR - AFEGIR FURGONETA</h4> </div>
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
			<label for="usr">Matr&iacute;cula:</label>
			<input type="text" class="form-control" name="matricula" placeholder="Matr&iacute;cula" required>
		</td>
	
		<td class="form-group">
			<label for="usr">Marca:</label>
			<input type="text" class="form-control" name="marca" placeholder="Marca" required>
		</td>
	
		<td class="form-group">
			<label for="usr">Model:</label>
			<input type="text" class="form-control" name="modelo" placeholder="Model" required>
		</td>
	</tr>
	
	<tr>
		<td class="form-group">
			<label for="usr">Volum:</label>
			<input type="number" class="form-control" name="volumen" placeholder="Volum" required>
		</td>
	
		<td class="form-group">
			<label for="usr">Llarg:</label>
			<input type="number" class="form-control" name="largo" placeholder="Llarg">
		</td>
	
		<td class="form-group">
			<label for="usr">Ample:</label>
			<input type="number" class="form-control" name="ancho" placeholder="Ample">
		</td>
	
		<td class="form-group">
			<label for="usr">Alt:</label>
			<input type="number" class="form-control" name="alto" placeholder="Alt">
		</td>
	</tr>
	
	<tr>
		<td class="checkbox">
			<label><input type="checkbox" name="taller" value="">Taller</label>
		</td>
	
		<td class="checkbox">
			<label><input type="checkbox" name="activo" value="" checked="">Activa</label>
		</td>	
    </tr>
	
	<tr>
		<td>
			<button class="btn btn-large btn-primary" name='btn-save'><i class="glyphicon glyphicon-save"></i> &nbsp; <strong>GUARDAR</strong></button>
			<a href="furgonetas.php" class="btn btn-large btn-warning" role="button"><i class="glyphicon glyphicon-arrow-left"></i> &nbsp;<strong>Cancelar</a></strong>
		</td>
	</tr>
    
	</table>
   </form>
  </div>
</div>
</center>
</body>
</html>