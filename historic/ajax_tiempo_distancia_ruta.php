<?php
	include_once "../includes/conexion.php";

	if ((!isset($_POST['ruta']))OR(!isset($_POST['fecha']))
		OR(!isset($_POST['ncomandes']))OR(!isset($_POST['nlinies']))
		OR(!isset($_POST['distancia']))OR(!isset($_POST['tiempo'])))
	{
		echo -1; 
		exit(-1);
	}
	
	$ruta = $_POST['ruta'];
	$fecha = $_POST['fecha'];
	$ncomandes = $_POST['ncomandes'];
	$nlinies = $_POST['nlinies'];
	$distancia = $_POST['distancia'];
	$tiempo = $_POST['tiempo'];
	
	$consulta1="SELECT * FROM rutes_informacio WHERE data='$fecha' AND ruta='$ruta'";
	$resultado1=mysql_query($consulta1,$link) or die (mysql_error());
	
	if (mysql_num_rows($resultado1)>0){
		$consulta2 = "UPDATE rutes_informacio SET 
						comandes='$ncomandes', linies='$nlinies', distancia='$distancia',	temps='$tiempo'
					  WHERE data='$fecha' AND ruta='$ruta'";
		$resultado2 = mysql_query($consulta2,$link);
	}else{
		$consulta3 = "INSERT INTO rutes_informacio(data,ruta,comandes,linies,distancia,temps) 
						VALUES ('$fecha','$ruta','$ncomandes','$nlinies','$distancia','$tiempo')";
		$resultado3 = mysql_query($consulta3,$link);
	}			
//	echo(1);
	mysql_free_result($resultado1);
	mysql_free_result($resultado2);
	mysql_free_result($resultado3);
	exit();
?>