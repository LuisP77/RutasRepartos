<?php
 include_once "../includes/conexion.php";
if($_GET['id'] and $_GET['ruta'])
{
	$id = $_GET['id'];
	$ruta = $_GET['ruta'];
	
	if (($ruta>=0)AND($ruta<=10)){
		
		$consulta1 = "SELECT * FROM comandes_rutes WHERE id_comanda='$id'";
		$resultado1 = mysql_query($consulta1,$link) or die (mysql_error());
	
		if (mysql_num_rows($resultado1)>0){
			$consulta2 = "UPDATE comandes_rutes SET 
							ruta='$ruta'
						  WHERE id_comanda='$id'";
			$resultado2 = mysql_query($consulta2);
		}else{
			$consulta3 = "INSERT INTO comandes_rutes(id_comanda,ruta) 
							VALUES ('$id','$ruta')";
			$resultado3 = mysql_query($consulta3);
		}			
	}
	mysql_free_result($resultado1);
	mysql_free_result($resultado2);
	mysql_free_result($resultado3);
}
?>