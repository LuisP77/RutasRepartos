<?php
 include_once "../includes/conexion.php";
//---------------------------------------------------------------------------------------------------------------
//                                CAMBIO DE DIRECCIÓN
//---------------------------------------------------------------------------------------------------------------

if ($_POST['accio']=="cambio_direccion")
{
	
	if ((!isset($_POST['id_comanda']))OR(!isset($_POST['direccion']))OR(!isset($_POST['direccion_ant'])))
	{
		echo -1; 
		exit(-1);
	}
	
	$id_comanda = $_POST['id_comanda'];
	$direccion = $_POST['direccion'];
	$direccion_ant = $_POST['direccion_ant'];
	
	$consulta = "SELECT id_usuari, nom, cognoms FROM comandes JOIN usuaris ON comandes.id_usuari = usuaris.id WHERE comandes.id='$id_comanda'";
	$resultado = mysql_query($consulta) or die (mysql_error());
	$resultado_fetched = mysql_fetch_row($resultado);
	$id_usuari = $resultado_fetched[0];
	$nom_usuari = $resultado_fetched[1];
	$cognoms_usuari = $resultado_fetched[2];
	
	$asunto = "Canvi adreça usuari id = " . $id_usuari;
	$msg = "L'adreça del usuari id = ".$id_usuari." (".$nom_usuari." ".$cognoms_usuari.") dona error al google maps i necessitem fer un canvi perquè la reconegui."."\n";
	$msg .= "Adreça anterior: ".$direccion_ant."\n";
	$msg .= "Adreça nova: ".$direccion."\n"."\n";
	$msg .= "Moltes gràcies,"."\n"."\n";
	$msg .= "Departament de rutes";
	
	$asunto=utf8_decode($asunto);
	$msg=utf8_decode($msg);
	
	if (mail($email_cambio_direccion,$asunto,$msg)){
		echo ("Petició enviada correctament");
	}else{
		echo ("Error : No s'ha pogut enviar la petició");	
	}
	
	mysql_free_result($resultado);
	
	exit();
}
?>