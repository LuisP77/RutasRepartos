<?php

 include_once "../includes/conexion.php";
//---------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------
if ($_POST['accio']=="elimRutaInfo")
{
	if ((!isset($_POST['ruta']))OR(!isset($_POST['fecha'])))
	{
		echo -1; 
		exit(-1);
	}
	
	$ruta = $_POST['ruta'];
	$fecha = $_POST['fecha'];
	
	$consulta="DELETE FROM rutes_informacio WHERE data='$fecha' AND ruta='$ruta'";
	$resultado=mysql_query($consulta,$link) or die (mysql_error());
	mysql_free_result($resultado);
	echo(1);
	exit();
}	
?>