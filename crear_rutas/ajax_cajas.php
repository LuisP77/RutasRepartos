<?php
 include_once "../includes/conexion.php";
//---------------------------------------------------------------------------------------------------------------
//                                GUARDAR CAJAS SECOS
//---------------------------------------------------------------------------------------------------------------
if ($_POST['categ']=="secas")
{
	if ((!isset($_POST['id_comanda']))OR(!isset($_POST['secas'])))
	{
		echo -1; 
		exit(-1);
	}
	$id_comanda = $_POST['id_comanda'];
	$secas = $_POST['secas'];
	
	$consulta1="SELECT * FROM comandes_caixes WHERE id_comanda='$id_comanda'";
	$resultado1=mysql_query($consulta1) or die (mysql_error());
	
	if (mysql_num_rows($resultado1)>0){
		$consulta2 = "UPDATE comandes_caixes SET 
					   sec='$secas'
					  WHERE id_comanda='$id_comanda'";
		$resultado2 = mysql_query($consulta2);
	}else{
		$consulta3 = "INSERT INTO comandes_caixes(id_comanda,sec) 
					  VALUES ('$id_comanda','$secas')";
		$resultado3 = mysql_query($consulta3);
		
	}
	mysql_free_result($resultado1);
	mysql_free_result($resultado2);
	mysql_free_result($resultado3);
	echo(1);
	exit();
}

//---------------------------------------------------------------------------------------------------------------
//                                GUARDAR CAJAS REFRIGERADOS
//---------------------------------------------------------------------------------------------------------------
if ($_POST['categ']=="refrigeradas")
{
	if ((!isset($_POST['id_comanda']))OR(!isset($_POST['refrigeradas'])))
	{
		echo -1; 
		exit(-1);
	}
	$id_comanda = $_POST['id_comanda'];
	$refrigeradas = $_POST['refrigeradas'];
	
	$consulta1 = "SELECT * FROM comandes_caixes WHERE id_comanda='$id_comanda'";
	$resultado1 = mysql_query($consulta1) or die (mysql_error());
	
	if (mysql_num_rows($resultado1)>0){
		$consulta2 = "UPDATE comandes_caixes SET 
					   ref='$refrigeradas'
					  WHERE id_comanda='$id_comanda'";
		$resultado2 = mysql_query($consulta2);
	}else{
		$consulta3 = "INSERT INTO comandes_caixes(id_comanda,ref) 
					  VALUES ('$id_comanda','$refrigeradas')";
		$resultado3 = mysql_query($consulta3);
		
	}
	mysql_free_result($resultado1);
	mysql_free_result($resultado2);
	mysql_free_result($resultado3);

	echo(1);
	exit();
}

//---------------------------------------------------------------------------------------------------------------
//                                GUARDAR CAJAS FRUTAS/VERDURAS
//---------------------------------------------------------------------------------------------------------------
if ($_POST['categ']=="frutas_verduras")
{
	if ((!isset($_POST['id_comanda']))OR(!isset($_POST['frutas_verduras'])))
	{
		echo -1; 
		exit(-1);
	}
	$id_comanda = $_POST['id_comanda'];
	$frutas_verduras = $_POST['frutas_verduras'];
	
	$consulta1 = "SELECT * FROM comandes_caixes WHERE id_comanda='$id_comanda'";
	$resultado1 = mysql_query($consulta1) or die (mysql_error());
	
	if (mysql_num_rows($resultado1)>0){
		$consulta2 = "UPDATE comandes_caixes SET 
					   fruit_verd='$frutas_verduras'
					  WHERE id_comanda='$id_comanda'";
		$resultado2 = mysql_query($consulta2);
	}else{
		$consulta3 = "INSERT INTO comandes_caixes(id_comanda,fruit_verd) 
					  VALUES ('$id_comanda','$frutas_verduras')";
		$resultado3 = mysql_query($consulta3);
		
	}
	mysql_free_result($resultado1);
	mysql_free_result($resultado2);
	mysql_free_result($resultado3);

	echo(1);
	exit();
}
?>