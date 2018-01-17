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

 if(isset($_GET['edit_id']))
{
 $sql_query="SELECT * FROM furgonetes WHERE id=".$_GET['edit_id'];
 $result_set=mysql_query($sql_query);
 $fetched_row=mysql_fetch_array($result_set);
}

if(isset($_POST['btn-update']))
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

 // sql para actualización
 $sql_query = "UPDATE furgonetes SET 
                 nom='$nombre',
				 matricula='$matricula',
			     marca='$marca',
				 model='$modelo',
				 volum='$volumen',
			     llarg='$largo',
				 ample='$ancho',
				 alt='$alto',
				 taller='$taller',
				 actiu='$activo'
			   WHERE id=".$_GET['edit_id'];
 // fin sql para actualización
 
 // ejecutar sql query
 if(mysql_query($sql_query))
 {
  ?>
  <script type="text/javascript">
  alert("Les dades s'han actualitzat correctament");
  window.location.href='<?php echo $_GET['pagant']?>';
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
 <div class="container-fluid"> <h4>EL COMPRADOR - EDITAR FURGONETA</h4> </div>
</div>

<div id="body">
 <div id="content">
    <form method="post">
    <table class="table-condensed" align="center">
	
	<tr>
		<td class="form-group">
			<label for="usr">Nom:</label>
			<input type="text" class="form-control" name="nombre" placeholder="Nom" value="<?php echo $fetched_row['nom']; ?>" required>
		</td>
	
		<td class="form-group">
			<label for="usr">Matr&iacute;cula:</label>
			<input type="text" class="form-control" name="matricula" placeholder="Matr&iacute;cula" value="<?php echo $fetched_row['matricula']; ?>" required>
		</td>
	
		<td class="form-group">
			<label for="usr">Marca:</label>
			<input type="text" class="form-control" name="marca" placeholder="Marca" value="<?php echo $fetched_row['marca']; ?>" required>
		</td>
	
		<td class="form-group">
			<label for="usr">Model:</label>
			<input type="text" class="form-control" name="modelo" placeholder="Model" value="<?php echo $fetched_row['model']; ?>" required>
		</td>
	</tr>
	
	<tr>
		<td class="form-group">
			<label for="usr">Volum:</label>
			<input type="number" class="form-control" name="volumen" placeholder="Volum" value="<?php echo $fetched_row['volum']; ?>" required>
		</td>
	
		<td class="form-group">
			<label for="usr">Llarg:</label>
			<input type="number" class="form-control" name="largo" placeholder="Llarg" value="<?php echo $fetched_row['llarg']; ?>" required>
		</td>
	
		<td class="form-group">
			<label for="usr">Ample:</label>
			<input type="number" class="form-control" name="ancho" placeholder="Ample" value="<?php echo $fetched_row['ample']; ?>" required>
		</td>
	
		<td class="form-group">
			<label for="usr">Alt:</label>
			<input type="number" class="form-control" name="alto" placeholder="Alt" value="<?php echo $fetched_row['alt']; ?>" required>
		</td>
	</tr>
	
	<tr>
		<td class="checkbox">
			<label><input type="checkbox" name="taller" value="<?php echo $fetched_row['taller'];?>"
						<?php echo ($fetched_row['taller']==1 ? 'checked' : '');?>>Taller</label>
		</td>

		<td class="checkbox">
			<label><input type="checkbox" name="activo" value="<?php echo $fetched_row['actiu'];?>"
						<?php echo ($fetched_row['actiu']==1 ? 'checked' : '');?>>Actiu</label>
		</td>
	</tr>
	
    <tr>
		<td>
			<button class="btn btn-large btn-primary" name='btn-update'><i class="glyphicon glyphicon-edit"></i> &nbsp; <strong>ACTUALITZAR</strong></button>
			<a href= <?php echo$_GET['pagant']?> class="btn btn-large btn-warning" role="button"><i class="glyphicon glyphicon-arrow-left"></i> &nbsp;<strong>Cancelar</a></strong>
		</td>
    </tr>

   </table>
  </form>
 </div>
</div>

</center>
</body>
</html>