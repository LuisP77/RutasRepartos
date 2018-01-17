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

 if(isset($_GET['edit_id']))
{
 $sql_query="SELECT * FROM lliuradors WHERE id=".$_GET['edit_id'];
 $result_set=mysql_query($sql_query);
 $fetched_row=mysql_fetch_array($result_set);
}

if(isset($_POST['btn-update']))
{
 // variables ingreso datos
 $nombre = $_POST['nombre'];
 $tlf = $_POST['tlf'];
 $activo = isset($_POST['activo']) ? 1 : 0;
 $vacaciones = isset($_POST['vacaciones']) ? 1 : 0;
 $baja_laboral = isset($_POST['baja_laboral']) ? 1 : 0;
 // fin variables ingreso datos

 // sql para actualización
 $sql_query = "UPDATE lliuradors SET 
                 nom='$nombre',
				 tlf='$tlf',
			     actiu='$activo',
				 vacances='$vacaciones',
				 baixa_laboral='$baja_laboral'
			   WHERE id=".$_GET['edit_id'];
 // fin sql para actualización
 
 // ejecutar sql query
 if(mysql_query($sql_query))
 {
  ?>
  <script type="text/javascript">
  alert("Les dades s'han actualtzat correctament");
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
 <div class="container-fluid"> <h4>EL COMPRADOR - EDITAR LLIURADOR</h4> </div>
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
			<label for="usr">Tel&eacute;fono:</label>
			<input type="text" class="form-control" name="tlf" placeholder="Tel&eacute;fon" value="<?php echo $fetched_row['tlf']; ?>" required>
		</td>
	</tr>
	    
	<tr>
		<td class="checkbox">
			<label><input type="checkbox" name="activo" value="<?php echo $fetched_row['actiu'];?>"
						<?php echo ($fetched_row['actiu']==1 ? 'checked' : '');?>>Actiu</label>
			</td>
	</tr>
	
	<tr>
		<td class="checkbox">
			<label><input type="checkbox" name="vacaciones" value="<?php echo $fetched_row['vacances'];?>"
						<?php echo ($fetched_row['vacances']==1 ? 'checked' : '');?>>Vacances</label>
		</td>
	</tr>
	
	<tr>
		<td class="checkbox">
			<label><input type="checkbox" name="baja_laboral" value="<?php echo $fetched_row['baixa_laboral'];?>"
						<?php echo ($fetched_row['baixa_laboral']==1 ? 'checked' : '');?>>Baixa Laboral</label>
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