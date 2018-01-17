<?php
 include_once "../includes/conexion.php";
//---------------------------------------------------------------------------------------------------------------
//                          Guardar posición despues de cambiar Ruta
//---------------------------------------------------------------------------------------------------------------
if ($_POST['accio']=="cambio_ruta")
{
	if ((!isset($_POST['pos']))OR(!isset($_POST['id'])))
	{
		echo -1; 
		exit(-1);
	}
	$pos = $_POST['pos'];
	$id = $_POST['id'];
	
	$consulta = "UPDATE comandes_rutes SET posicio='$pos' WHERE id_comanda='$id'";
	$result_set = mysql_query($consulta,$link);
	
	mysql_free_result($result_set);	
	echo(1);
	exit();

}
//---------------------------------------------------------------------------------------------------------------
//               Guardar posición despues de intercambiar Ruta presionando flechas
//---------------------------------------------------------------------------------------------------------------
if ($_POST['accio']=="cambio_flecha")
{
	if ((!isset($_POST['idA']))OR(!isset($_POST['valorA']))OR(!isset($_POST['idB']))OR(!isset($_POST['valorB'])))
	{
		echo -1; 
		exit(-1);
	}
	
	$idA = $_POST['idA'];
	$valorA = $_POST['valorA'];
	$idB = $_POST['idB'];
	$valorB = $_POST['valorB'];
	
	$consulta1 = "UPDATE comandes_rutes SET posicio='$valorB' WHERE id_comanda='$idA'";
	$result_set_1 = mysql_query($consulta1,$link);
	
	$consulta2 = "UPDATE comandes_rutes SET posicio='$valorA' WHERE id_comanda='$idB'";
	$result_set_2 = mysql_query($consulta2);

	mysql_free_result($result_set_1);	
	mysql_free_result($result_set_2);	

	echo(1);
	exit();
}
?>