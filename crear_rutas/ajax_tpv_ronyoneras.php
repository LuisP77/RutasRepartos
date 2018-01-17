<?php
 include_once "../includes/conexion.php";
//---------------------------------------------------------------------------------------------------------------
//                                      GUARDAR TPV
//---------------------------------------------------------------------------------------------------------------
if ($_POST['accio']=="guardar_tpv")
{
	if ((!isset($_POST['ruta']))OR(!isset($_POST['tpv']))OR(!isset($_POST['fecha'])))
	{
		echo -1; 
		exit(-1);
	}
	$ruta = $_POST['ruta'];
	$tpv = $_POST['tpv'];
	$fecha = $_POST['fecha'];
	
	$consulta1="SELECT * FROM rutes_informacio WHERE data='$fecha' AND ruta='$ruta'";
	$resultado1=mysql_query($consulta1,$link) or die (mysql_error());
	
	if (mysql_num_rows($resultado1)>0){
		$consulta2 = "UPDATE rutes_informacio SET 
							   tpv='$tpv'
						WHERE data='$fecha' AND ruta='$ruta'";
		$resultado2 = mysql_query($consulta2,$link);
	}else{
		$consulta3 = "INSERT INTO rutes_informacio(data,ruta,tpv) 
						VALUES ('$fecha','$ruta','$tpv')";
		$resultado3 = mysql_query($consulta3,$link);
		
	}
	mysql_free_result($resultado1);
	mysql_free_result($resultado2);
	mysql_free_result($resultado3);
	echo(1);
	exit();
}

//---------------------------------------------------------------------------------------------------------------
//                                      GUARDAR KOALA
//---------------------------------------------------------------------------------------------------------------
if ($_POST['accio']=="guardar_ronyonera")
{
	if ((!isset($_POST['ruta']))OR(!isset($_POST['ronyonera']))OR(!isset($_POST['fecha'])))
	{
		echo -1; 
		exit(-1);
	}
	$ruta = $_POST['ruta'];
	$ronyonera = $_POST['ronyonera'];
	$fecha = $_POST['fecha'];
	
	$consulta1="SELECT * FROM rutes_informacio WHERE data='$fecha' AND ruta='$ruta'";
	$resultado1=mysql_query($consulta1,$link) or die (mysql_error());
	
	if (mysql_num_rows($resultado1)>0){
		$consulta2 = "UPDATE rutes_informacio SET 
							   ronyonera='$ronyonera'
						WHERE data='$fecha' AND ruta='$ruta'";
		$resultado2 = mysql_query($consulta2,$link);
	}else{
		$consulta3 = "INSERT INTO rutes_informacio(data,ruta,ronyonera) 
						VALUES ('$fecha','$ruta','$ronyonera')";
		$resultado3 = mysql_query($consulta3,$link);
		
	}
	mysql_free_result($resultado1);
	mysql_free_result($resultado2);
	mysql_free_result($resultado3);
	echo(1);
	exit();
}


?>