<?php
 include_once "../includes/conexion.php";
//---------------------------------------------------------------------------------------------------------------
//                                  LISTAR                                                                 
//---------------------------------------------------------------------------------------------------------------
if($_POST['accio']=="listar")
{
	if (!isset($_POST['fecha']))
	{
		echo -1; 
		exit(-1);
	}

	$fecha = $_POST['fecha'];
	
    $result = mysql_query("SELECT id, nom FROM lliuradors 
					WHERE id
					NOT IN	(SELECT lliurador FROM rutes_informacio WHERE data = '$fecha')
					ORDER BY nom",$link);
	$total_repartidores = mysql_num_rows($result);	
	
	$html = "<table class='table table-condensed table-hover table-responsive'>
				<thead style='font-size:80%'>
					<th>ID</th>
					<th>Nom</th>
				</thead>
			<tbody style='font-size:120%'>";
	
	for ($i=0;$i<$total_repartidores;$i++){
		$id = mysql_result($result,$i,"id");
		$nombre = mysql_result($result,$i,"nom");
		
		$html = $html . <<<HTML
			<tr onclick="guardar_repartidor($id,'$nombre')">
				<td style="font-size:60%">$id</td>
				<td style="font-size:60%">$nombre</td>
			</tr>
HTML;
	}
	$html = $html . <<<HTML
			</tbody>
		</table>
HTML;
	mysql_free_result($result);
	echo($html);
	exit();
	
}
//---------------------------------------------------------------------------------------------------------------
//                                      GUARDAR
//---------------------------------------------------------------------------------------------------------------
if ($_POST['accio']=="guardar")
{
	if ((!isset($_POST['ruta']))OR(!isset($_POST['id']))or(!isset($_POST['fecha'])))
	{
		echo -1; 
		exit(-1);
	}
	$ruta = $_POST['ruta'];
	$id = $_POST['id'];
	$fecha = $_POST['fecha'];
	
	$consulta1="SELECT * FROM rutes_informacio WHERE data='$fecha' AND ruta='$ruta'";
	$resultado1=mysql_query($consulta1,$link) or die (mysql_error());
	
	if (mysql_num_rows($resultado1)>0){
		$consulta2 = "UPDATE rutes_informacio SET 
							   lliurador='$id'
						WHERE data='$fecha' AND ruta='$ruta'";
		$resultado2 = mysql_query($consulta2,$link);
	}else{
		$consulta3 = "INSERT INTO rutes_informacio(data,ruta,lliurador) 
						VALUES ('$fecha','$ruta','$id')";
		$resultado3 = mysql_query($consulta3,$link);
		
	}
	mysql_free_result($resultado1);
	mysql_free_result($resultado2);
	mysql_free_result($resultado3);
	echo(1);
	exit();
}
//---------------------------------------------------------------------------------------------------------------
//                                      Limpiar
//---------------------------------------------------------------------------------------------------------------
if ($_POST['accio']=="limpiar")
{
	if ((!isset($_POST['ruta']))OR(!isset($_POST['fecha'])))
	{
		echo -1; 
		exit(-1);
	}
	$ruta = $_POST['ruta'];
	$fecha = $_POST['fecha'];
	
	$consulta = "UPDATE rutes_informacio SET 
				   lliurador='0'
				WHERE data='$fecha' AND ruta='$ruta'";
	$resultado = mysql_query($consulta,$link);
	mysql_free_result($resultado);
	echo(1);
	exit();
}


?>