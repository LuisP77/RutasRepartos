<?php
//---------------------------------------------------------------------------------------------------------------
//                        Furgonetas Alquiladas
//---------------------------------------------------------------------------------------------------------------
function furgonetas_alquiladas($link,$fecha_inicio,$fecha_fin){
	$sql = <<<SQL
	SELECT count(rutes_informacio.id)
	FROM rutes_informacio
	LEFT JOIN furgonetes ON rutes_informacio.furgoneta = furgonetes.id
	WHERE rutes_informacio.data BETWEEN '$fecha_inicio' AND '$fecha_fin' AND furgonetes.lloguer = true
SQL;
	$result = mysql_query($sql, $link);
	$n_furgonetas_alquiladas = mysql_result($result,0);
	mysql_free_result($result);
	return $n_furgonetas_alquiladas;
}

//---------------------------------------------------------------------------------------------------------------
//                        Distancia recorrida de repartidor
//---------------------------------------------------------------------------------------------------------------
function distancia_recorrida_furgoneta($link,$id_furgoneta,$fecha_inicio,$fecha_fin){
	$sql = <<<SQL
	SELECT sum(distancia)
	FROM rutes_informacio
	WHERE furgoneta = '$id_furgoneta' AND data BETWEEN '$fecha_inicio' AND '$fecha_fin'
SQL;
	$result = mysql_query($sql, $link);
	$distancia = mysql_result($result,0);
	mysql_free_result($result);
	return number_format($distancia,1);
}

//---------------------------------------------------------------------------------------------------------------
//                        Estadísticas de repartidor
//---------------------------------------------------------------------------------------------------------------
function estadisticas_repartidor($link,$id_repartidor,$fecha_inicio,$fecha_fin){
	$sql = <<<SQL
	SELECT sum(comandes), sum(linies), sum(distancia), sum(temps)
	FROM rutes_informacio
	WHERE lliurador = '$id_repartidor' AND data BETWEEN '$fecha_inicio' AND '$fecha_fin'
SQL;
	$result = mysql_query($sql, $link);
	while($row=mysql_fetch_row($result)){
		$comandes = $row[0];
		$linies = $row[1];
		$distancia = number_format($row[2],1);
		$temps = number_format($row[3]/60,1);
	}
	return array($comandes,$linies,$distancia,$temps);
	mysql_free_result($result);
}

//---------------------------------------------------------------------------------------------------------------
//                        Distancia recorrida de repartidor
//---------------------------------------------------------------------------------------------------------------
function distancia_recorrida_repartidor($link,$id_repartidor,$fecha_inicio,$fecha_fin){
	$sql = <<<SQL
	SELECT sum(distancia)
	FROM rutes_informacio
	WHERE lliurador = '$id_repartidor' AND data BETWEEN '$fecha_inicio' AND '$fecha_fin'
SQL;
	$result = mysql_query($sql, $link);
	$distancia = mysql_result($result,0);
	mysql_free_result($result);
	return number_format($distancia,1);
}

//---------------------------------------------------------------------------------------------------------------
//                        Tiempo conduciendo de repartidor
//---------------------------------------------------------------------------------------------------------------
function tiempo_conduciendo_repartidor($link,$id_repartidor,$fecha_inicio,$fecha_fin){
	$sql = <<<SQL
	SELECT sum(temps)
	FROM rutes_informacio
	WHERE lliurador = '$id_repartidor' AND data BETWEEN '$fecha_inicio' AND '$fecha_fin'
SQL;
	$result = mysql_query($sql, $link);
	$tiempo = mysql_result($result,0);
	mysql_free_result($result);
	return number_format($tiempo/60,1);
}

//---------------------------------------------------------------------------------------------------------------
//                        Comandes de repartidor
//---------------------------------------------------------------------------------------------------------------
function comandes_repartidor($link,$id_repartidor,$fecha_inicio,$fecha_fin){
	$sql = <<<SQL
	SELECT sum(comandes)
	FROM rutes_informacio
	WHERE lliurador = '$id_repartidor' AND data BETWEEN '$fecha_inicio' AND '$fecha_fin'
SQL;
	$result = mysql_query($sql, $link);
	$comandes = mysql_result($result,0);
	mysql_free_result($result);
	return $comandes;
}

//---------------------------------------------------------------------------------------------------------------
//                        Linies de repartidor
//---------------------------------------------------------------------------------------------------------------
function linies_repartidor($link,$id_repartidor,$fecha_inicio,$fecha_fin){
	$sql = <<<SQL
	SELECT sum(linies)
	FROM rutes_informacio
	WHERE lliurador = '$id_repartidor' AND data BETWEEN '$fecha_inicio' AND '$fecha_fin'
SQL;
	$result = mysql_query($sql, $link);
	$linies = mysql_result($result,0);
	mysql_free_result($result);
	return $linies;
}

//---------------------------------------------------------------------------------------------------------------
//                               Agregar días transcurridos
//---------------------------------------------------------------------------------------------------------------
function agrega_dias_transcurridos($fecha,$dias_transcurridos){
	if ($fecha == ' - '){
		$salida = $fecha;
	}else{
		$salida = $fecha.' ('.$dias_transcurridos.')';
	}	
	return $salida;
}

//---------------------------------------------------------------------------------------------------------------
//                               Formato simple fecha
//---------------------------------------------------------------------------------------------------------------
function formato_simple_fecha($fecha)
{
	if ($fecha == '0000-00-00 00:00:00'){
		$fecha_formato_simple = ' - ';
	}else{	
		$fecha_formato_simple = date('Y-m-d', strtotime($fecha));
	}
	return $fecha_formato_simple;
}

//---------------------------------------------------------------------------------------------------------------
//                               Días entre dos fechas
//---------------------------------------------------------------------------------------------------------------
function dias_transcurridos($fecha_i,$fecha_f)
{
	if(($fecha_i == '0000-00-00 00:00:00')OR($fecha_f == '0000-00-00 00:00:00')){
		$dias = '-';
	}else{
		$dias	= (strtotime($fecha_i)-strtotime($fecha_f))/86400;
		$dias 	= abs($dias); $dias = floor($dias);		
	}
	return $dias;
}
