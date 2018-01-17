<?php  
/********************************************************************************************************************/
/*                                       FUNCIÓN LISTAR PEDIDOS                                                     */
/********************************************************************************************************************/
  function Llistar_Pedidos($link,$today){
	  
	$query="SELECT comandes.id,		                
				   concat_ws(' ', usuaris.nom, usuaris.cognoms),
	               concat_ws(' ', carrer, numero),
				   concat_ws(' ', pis, porta,ascensor),
				   usuaris_adreces.poblacio,
				   provincia,
				   usuaris_adreces.comentaris,
				   comandes.comentaris,
				   franja,
				   zona,
				   usuaris_adreces.CP,
				   comandes_rutes.ruta,
				   comandes_rutes.posicio,
				   ascensor,
				   comandes_caixes.sec,
				   comandes_caixes.ref,
				   comandes_caixes.fruit_verd,
				   comandes.id_usuari,
				   usuaris_adreces.tlf
			FROM `comandes` 
			JOIN comandes_entrega ON comandes.id = comandes_entrega.id_comanda AND comandes_entrega.dia = '".$today."'
			JOIN usuaris_adreces ON comandes.id_adresa = usuaris_adreces.id
			JOIN usuaris ON comandes.id_usuari = usuaris.id
			JOIN zones_repartiment ON usuaris_adreces.CP = zones_repartiment.CP 
			LEFT JOIN comandes_rutes ON comandes.id = comandes_rutes.id_comanda
			LEFT JOIN comandes_caixes ON comandes.id = comandes_caixes.id_comanda
			WHERE comandes.estat =1
			GROUP BY comandes.id
			ORDER BY zona, franja, usuaris_adreces.CP";
	
	
    $result_set = mysql_query($query,$link);
	
    if (!$result_set) {
		return 'No s’ha pogut executar la consulta: ' . mysql_error();
    }
	
//-------------------------------   Preparar comandes_rutes   -----------------------------------------------------------------------
	$refrescar = false;
	while($row=mysql_fetch_row($result_set)){
	
		$id = $row[0];
	
		$consulta_aux="SELECT id_comanda FROM comandes_rutes WHERE id_comanda='$id'";
		$resultado_aux=mysql_query($consulta_aux) or die (mysql_error());
		
		if (mysql_num_rows($resultado_aux)==0){
			$consulta2_aux = "INSERT INTO comandes_rutes(id_comanda,ruta,posicio) 
							  VALUES ('$id','0','0')";
			mysql_query($consulta2_aux,$link);
			//$rows_consulta2_aux = mysql_num_rows($consulta2_aux);
			$refrescar = true;
			//if ($rows_consulta2_aux>0){
			//	mysql_free_result($consulta2_aux);
			//}
		}
		
	}	
	if ($row>0){
		mysql_free_result($resultado_aux);
	}
	if ($refrescar){
		header("Refresh:0");
		die();
	}
//-------------------------------------------------------------------------------------------------------------------------------------		


$html = <<<HTML
	  <table id="principal" style="display:none">
      <thead>
		<tr>
			<th>ID</th>
			<th>Nom</th>
			<th>Adreça</th>
			<th>P/P/A</th>
			<th>Població</th>
			<th>Província</th>      
			<th>Comentaris adreça</th>
			<th>Comentaris comanda</th>
			<th>Franja</th>
			<th>Zona</th>
			<th>CP</th>
			<th>RUTA</th>
			<th>posición</th>
			<th>ascensor</th>
			<th>SEC</th>
			<th>REF</th>
			<th>F/V</th>
			<th>id_usuari</th>
			<th>tlf</th>
			<th>líneas</th>
			<th>NC</th>
			<th>importPagat</th>
			<th>totalPagat</th>
			<th>metPagament</th>
			<th>comentaris</th>
		</tr>	
    </thead>
	<tfoot style="font-size:12px">
        <tr>
            <th>ID</th>
			<th>Nom</th>
			<th>Adreça</th>
			<th>P/P/A</th>
			<th>Població</th>
			<th>Província</th>      
			<th>Comentaris adreça</th>
			<th>Comentaris comanda</th>
			<th>Franja</th>
			<th>Zona</th>
			<th>CP</th>
			<th>RUTA</th>
			<th>posición</th>
			<th>ascensor</th>
			<th>SEC</th>
			<th>REF</th>
			<th>F/V</th>
			<th>id_usuari</th>
			<th>tlf</th>
			<th>líneas</th>
			<th>NC</th>
			<th>importPagat</th>
			<th>totalPagat</th>
			<th>metPagament</th>
			<th>comentaris</th>
        </tr>
    </tfoot>
   <tbody>
HTML;

	if (mysql_num_rows($result_set)>0){
		mysql_data_seek($result_set, 0);
	}
	
	while($row=mysql_fetch_row($result_set))
    {
		$id = $row[0];
		$nombre = $row[1];
		$direccion = $row[2];
		$puerta_piso_ascensor = $row[3];
		$poblacion = $row[4];
		$provincia = $row[5];
		$com_cliente = $row[6];
		$com_envio = $row[7];
		$franja = $row[8];
		$zona = $row[9];
		$cp = $row[10];
		$ruta = $row[11];
		$posicion = $row[12];
		$ascensor = $row[13];
		$sec = $row[14];
		$ref = $row[15];
		$fruta_verdura = $row[16];
        $id_usuari = $row[17];		
		$tlf = $row[18];
		
		//list($np,$npt,$total,$total_proximitat) = Get_Info_Commanda_Carret($link,$id);
		$lineas = 1;//$np;
		$nc = 1;//Usuari_Num_Comandes($link,$id_usuari);
		$importPagat = 1;
		$totalPagat = 1;
		$metPagament = 1;
		$comentaris = 1;
	
		$html = $html . <<<HTML
		<tr>
        <td style="font-size:60%">$id</td>
        <td style="font-size:60%">$nombre</td>
        <td style="font-size:60%">$direccion</td>
		<td style="font-size:60%">$puerta_piso_ascensor</td>
		<td style="font-size:60%">$poblacion</td>
		<td style="font-size:60%">$provincia</td>
		<td style="font-size:60%">$com_cliente</td>
		<td style="font-size:60%">$com_envio</td>
		<td>$franja</td>
		<td>$zona</td>
		<td>$cp</td>        
		<td bgcolor="whitesmoke"><span class= "xedit" id="$id">$ruta</span></td>
		<td style="display:none">$posicion</td>
		<td style="display:none">$ascensor</td>
		<td style="display:none">$sec</td>
		<td style="display:none">$ref</td>
		<td style="display:none">$fruta_verdura</td>
		<td style="display:none">$id_usuari</td>
		<td style="display:none">$tlf</td>
		<td style="display:none">$lineas</td>
		<td style="display:none">$nc</td>
		<td style="display:none">$importPagat</td>
		<td style="display:none">$totalPagat</td>
		<td style="display:none">$metPagament</td>
		<td style="display:none">$comentaris</td>
		
		</tr>	
HTML;
	}	
	$html = $html . <<<HTML
		</tbody>
    </table>
HTML;

//  -----------------------------   Tabla AUXILIAR   --------------------------------------------------------------------------------

	$html = $html . <<<HTML
	  <table id="principal_aux" style="display:none">
      <thead>
		<tr>
			<th>ID</th>
			<th>Nom</th>
			<th>Adreça</th>
			<th>P/P/A</th>
			<th>Població</th>
			<th>Província</th>      
			<th>Comentaris adreça</th>
			<th>Comentaris comanda</th>
			<th>Franja</th>
			<th>Zona</th>
			<th>CP</th>
			<th>RUTA</th>
			<th>posición</th>
			<th>ascensor</th>
			<th>SEC</th>
			<th>REF</th>
			<th>F/V</th>
			<th>id_usuari</th>
			<th>tlf</th>
			<th>líneas</th>
			<th>NC</th>
			<th style="display:none">importPagat</th>
			<th style="display:none">totalPagat</th>
			<th style="display:none">metPagament</th>
			<th style="display:none">comentaris</th>
		</tr>	
    </thead>
   <tbody>
HTML;
	
	if (mysql_num_rows($result_set)>0){
		mysql_data_seek($result_set, 0);
	}
	while($row=mysql_fetch_row($result_set))
    {
		$id = $row[0];
		$nombre = $row[1];
		$direccion = $row[2];
		$puerta_piso_ascensor = $row[3];
		$poblacion = $row[4];
		$provincia = $row[5];
		$com_cliente = $row[6];
		$com_envio = $row[7];
		$franja = $row[8];
		$zona = $row[9];
		$cp = $row[10];
		$ruta = $row[11];
		$posicion = $row[12];
		$ascensor = $row[13];
		$sec = $row[14];
		$ref = $row[15];
		$fruta_verdura = $row[16];
		$id_usuari = $row[17];
		$tlf = $row[18];
		
		list($lineas,$x1,$x2,$x3,$x4,$x5,$x6) = Get_Info_Commanda_Carret($link,$id);
		$nc = Usuari_Num_Comandes($link,$id_usuari);
		
		$total_pagat = 0;
		$info=Get_Info_Commanda($link,$id);
		if ($info['pagat']>0)
		{
			$total_pagat = $info['total'] / 100;
		}
		if ($total_pagat == 0){
			$importPagat = "NO";
		}else{
			$importPagat = $total_pagat;
		}
		
		$total_comanda = 0;
		
		$fact = Facturacio_Comanda_Array_CrearRutas($link,$id);
		$total_comanda = $fact['total'];
		$totalPagat = $total_comanda;
		
		$info=Get_Info_Commanda($link,$id);
		$metode_pagament = $info['metode_pagament'];
		$metPagament = $metode_pagament;
		
		if ($total_pagat==$total_comanda){
			$comentaris = "";
		}else{	
			if ($total_pagat>$total_comanda){
				$retornar = $total_pagat-$total_comanda;
				$comentaris = "Retornar ".$retornar." €";
			}else{
				$falta = $total_comanda-$total_pagat;
				$comentaris = "Falta pagar ".$falta." €";
			}	
		}
		
	$html = $html . <<<HTML
		<tr>
        <td>$id</td>
        <td>$nombre</td>
        <td>$direccion</td>
		<td>$puerta_piso_ascensor</td>
		<td>$poblacion</td>
		<td>$provincia</td>
		<td>$com_cliente</td>
		<td>$com_envio</td>
		<td>$franja</td>
		<td>$zona</td>
		<td>$cp</td>        
		<td>$ruta</td>
		<td>$posicion</td>
		<td>$ascensor</td>
		<td>$sec</td>
		<td>$ref</td>
		<td>$fruta_verdura</td>
		<td>$id_usuari</td>
		<td>$tlf</td>
		<td>$lineas</td>
		<td>$nc</td>
		<td style="display:none">$importPagat</td>
		<td style="display:none">$totalPagat</td>
		<td style="display:none">$metPagament</td>
		<td style="display:none">$comentaris</td>

		</tr>	
HTML;
	}	
	
	$html = $html . <<<HTML
		</tbody>
    </table>
HTML;

//  -----------------------------   FIN Tabla AUXILIAR   --------------------------------------------------------------------------------

	mysql_free_result($result_set);
	return $html;
  }

/********************************************************************************************************************/
/*                                       FUNCIÓN LISTAR RUTAS                                                       */
/********************************************************************************************************************/
  function Llistar_Rutas($max_rutas, $today){
	$html = '';  
	for($n_ruta=1;$n_ruta<=$max_rutas;$n_ruta++){

//	---------------------  Determinar repatidor, furgoneta, TPV y ronyonera para los inputs  ----------------------------
		$consulta= "SELECT nom FROM lliuradors 
					JOIN rutes_informacio ON lliuradors.id = rutes_informacio.lliurador
					WHERE rutes_informacio.data='$today' AND rutes_informacio.ruta='$n_ruta'";
		$resultado=mysql_query($consulta) or die (mysql_error());
				
		$row=mysql_fetch_row($resultado);
		
		if (mysql_num_rows($resultado)>0){
			$nombre_repartidor = $row[0];
		}else{
			$nombre_repartidor = "";
		};
		mysql_free_result($resultado);
		
		$consulta= "SELECT nom FROM furgonetes 
					JOIN rutes_informacio ON furgonetes.id = rutes_informacio.furgoneta
					WHERE rutes_informacio.data='$today' AND rutes_informacio.ruta='$n_ruta'";
		$resultado=mysql_query($consulta) or die (mysql_error());
				
		$row=mysql_fetch_row($resultado);
		
		if (mysql_num_rows($resultado)>0){
			$nombre_furgoneta = $row[0];
		}else{
			$nombre_furgoneta = "";
		};
		mysql_free_result($resultado);
		
		$consulta= "SELECT tpv FROM rutes_informacio 
					WHERE rutes_informacio.data='$today' AND rutes_informacio.ruta='$n_ruta'";
		$resultado=mysql_query($consulta) or die (mysql_error());
				
		$row=mysql_fetch_row($resultado);
		
		if (mysql_num_rows($resultado)>0){
			$tpv = $row[0];
		}else{
			$tpv = "";
		};
		mysql_free_result($resultado);
		
		$consulta= "SELECT ronyonera FROM rutes_informacio 
					WHERE rutes_informacio.data='$today' AND rutes_informacio.ruta='$n_ruta'";
		$resultado=mysql_query($consulta) or die (mysql_error());
				
		$row=mysql_fetch_row($resultado);
		
		if (mysql_num_rows($resultado)>0){
			$ronyonera = $row[0];
		}else{
			$ronyonera = "";
		};
		mysql_free_result($resultado);
//	------------------------------------------------------------------------------------------------

		$tiempo_almacen_primero = "";
		$tiempo_primero_ultimo = "";
		$tiempo_ultimo_almacen = "";
		
			
		$html = $html . <<<HTML
		<br/><br/>
	<div class="panel panel-primary" id="panel_ruta_$n_ruta">
		
		<div class="panel-heading" style="padding-bottom:0px">
			
			<div class="row">
				<div class="col-xs-1" style="font-size:20px">
					<strong>RUTA $n_ruta</strong>
				</div>
				
				<div class="form-group col-xs-2">
					<input type="text" class="form-control" id="repartidor_$n_ruta" value="$nombre_repartidor" readonly>
				</div>			
				<div class="col-xs-1">
					<button type="button" class="btn btn-warning" onclick="abrir_dialogo_repartidores($n_ruta)" style="position:absolute; left:-10px;" disabled>
					<span class="glyphicon glyphicon-user"></span> Lliurador</button>
				</div>
				
				<div class="form-group col-xs-2">
					<input type="text" class="form-control" id="furgoneta_$n_ruta"  value="$nombre_furgoneta" readonly>
				</div>
				<div class="col-xs-1">
					<button type="button" class="btn btn-warning" onclick="abrir_dialogo_furgonetas($n_ruta)" style="position:absolute; left:-10px;" disabled>
					<span class="glyphicon glyphicon-bed"></span> Furgoneta</button>
				</div>
				
				<div class="col-xs-1" style="font-size:14px; width:40px; top:6px">
					<strong>TPV:</strong>
				</div>
				<div class="form-group col-xs-1" style="width: 100px">
					<div class="tpv_editable form-control" id="tpv_$n_ruta" ruta="$n_ruta" style="border-bottom:none" readonly>$tpv</div>
				</div>
				
				<div class="col-xs-1" style="font-size:14px; width:85px; top:6px">
					<strong>Ronyonera:</strong>
				</div>
				<div class="form-group col-xs-1" style="width: 100px">
					<div class="ronyonera_editable form-control" id="ronyonera_$n_ruta" ruta="$n_ruta" style="border-bottom:none" readonly>$ronyonera</div>
				</div>
				
				<div class="col-xs-1"></div>
				<div id="orden_carga_$n_ruta" class="col-xs-2" style="font-size:14px">
					<strong>ORD.CÀRREGA: N/A</strong>
				</div>
				
			</div>	
		
		</div>
		
			<div class="panel-body">

				<table class="table condensed" id="tabla_ruta_$n_ruta" style="font-size:14px">
					<thead style="font-size:80%;"> <!-- rgb(66,139,202) -->
						<th></th>
						<th style="display:none"></th>
						<th style="display:none"></th>
						<th>ID</th>
						<th>NC</th>
						<th>L</th>
						<th>Nom</th>
						<th>Telèfon</th>
						<th>Adreça</th>
						<th>Ascensor</th>
						<th>Comentaris adreça</th>
						<th>Comentaris comanda</th>
						<th>Franja</th>
						<th>Zona</th>
						<th>Distància</th>
						<th>Temps</th>
						<th style="display:none">Posició</th>
						<th>SEC</th>
						<th>REF</th>
						<th>F/V</th>
						<th style="display:none">id_usuari</th>
					</thead>
				
					<tbody id="body_ruta_$n_ruta" class="ordenable" style="font-size:80%;" ruta="$n_ruta">
				
					</tbody>

				</table>		  
				<BR>
				
				<div class="row">
					<div class="col-xs-1">
						<button type="button" id="boton_calcular_$n_ruta" class="btn btn-danger" onclick="calcular_tiempos_ruta($n_ruta)"><span class="glyphicon glyphicon-random"></span> Calcular</button>
					</div>
				
					<div class="form-group col-xs-3">
						<table class="table condensed" id="tabla_tiempo_distancia_ruta_$n_ruta" style="font-size:10px">
							<thead>
								<th></th>
								<th>Temps</th>
								<th>Distància</th>
							</thead>
							<tbody>
								<tr>
									<td>Magatzem – 1r Lliurament</td>
									<td>-</td>
									<td>-</td>
								</tr>
								<tr>
									<td>1r Lliurament – Últim Lliurament</td>
									<td>-</td>
									<td>-</td>
								</tr>
								<tr>
									<td>Últim Lliurament – Magatzem</td>
									<td>-</td>
									<td>-</td>
								</tr>
							</tbody>
						</table>
					</div>
					
					<div class="col-xs-1">
					</div>
					
					<div class="col-xs-2">
						<button type="button" id="ver_mapa_$n_ruta" class="btn btn-warning" onclick="ver_mapa($n_ruta)"><span class="glyphicon glyphicon-road"></span> Veure mapa</button>
					</div>
				
					<div class="col-xs-1">
					</div>
					
					<div class="col-xs-2">
						<button type="button" id="imprimir_rebuts_ruta_$n_ruta" class="btn btn-warning" style="position:absolute; bottom:-120px; left:75px;" onclick="imprimir_rebuts_ruta($n_ruta)"><span class="glyphicon glyphicon-print"></span> Imprimir Rebuts</button>
					</div>
					
					<div class="col-xs-2">
						<button type="button" id="imprimir_ruta_$n_ruta" class="btn btn-warning" style="position:absolute; bottom:-120px" onclick="imprimir_ruta($n_ruta)"><span class="glyphicon glyphicon-print"></span> Imprimir Ruta</button>
					</div>
				
				</div>
				
			</div>	
	</div>	
HTML;

	}
	
	return $html;
  }

/********************************************************************************************************************/
/*                                       INICIO PHP                                                                 */
/********************************************************************************************************************/
  
  $sec = "historic"; $pagact = "historic.php"; 
  
  $hoy = date("Y-m-d");
  $ayer = date( "Y-m-d", strtotime( "-1 day", strtotime( $hoy ) ) );  

  $today = $ayer;
  
//  $today = "2016-06-28";
  
	include_once "modul_crear_rutas.php";
	include_once "../includes/conexion.php";
	include_once "../../../funcions.php";
    include_once "../../../modul.categories.php";	
	include_once "../../../modul.productes.php";
	include_once "../../../modul.buscar.php";
	include_once "../../../modul.carret.php";
	include_once "../../../modul.comandes.php";
	include_once "../../../modul.adresa.php";
	include_once "../../../modul.usuari.php";
	include_once "../../../modul.mgm.php";
	include_once "../../../modul.promos.php";
	include_once "../../modul.facturacio.php";
	include_once "../../modul.estoc.php";

  
  if(isset($_GET['fecha'])){
	$today = $_GET['fecha'];  
  }
	$max_rutas = 10;
  	$html_Llistar_Pedidos = Llistar_Pedidos($link, $today);
	$html_Llistar_Rutas = Llistar_Rutas($max_rutas, $today);
	
/********************************************************************************************************************/
/*                                       FIN PHP                                                                    */
/********************************************************************************************************************/
/********************************************************************************************************************/
/********************************************************************************************************************/
/********************************************************************************************************************/
/*                                      INICIO HTML                                                                 */
/********************************************************************************************************************/

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php include_once "../includes/titulo_pag.php"; ?></title>
  <?php include_once "../includes/header.php"; ?>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

  <link href="https://cdn.datatables.net/1.10.8/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
  <script src = "https://cdn.datatables.net/1.10.8/js/jquery.dataTables.min.js" type="text/javascript"></script>
  <script src = "https://cdn.datatables.net/fixedcolumns/3.2.2/js/dataTables.fixedColumns.min.js"></script>
  
  <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
  <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>  
		
  <script type="text/javascript" src="funciones_crear_rutas.js"></script>
		
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/flick/jquery-ui.css">		
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
  
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGBoTpHTdwXADwfjC9h8Y0oD43pNW4G_o&signed_in=true"
          async defer></script>

<script type="text/javascript"> 

//-----------------------------------------------------------------------------------------------------
//                          Document READY
//-----------------------------------------------------------------------------------------------------

	jQuery(document).ready(function() {		
	
		pag_editable = false;
		//pag_editable = fecha_editable();

		llenar_resumen();
		llenar_tablas_ruta(true);
		if (pag_editable){
			presionar_flechas();
			inicializar_dialogo_repartidores();
			inicializar_dialogo_furgonetas();
			x_editable();
		}
		inicializar_dialogo_mapas();
		dataTables();
		
	});	

	$(window).load(function () {
		$(".loading").hide(); // loading DIV hide
		$(".container-fluid").fadeIn("slow"); // content DIV fades in
	});
	
</script>
  
  
</head>

<body>
<!-- -----------------------------  Loading  --------------------------------------------- --> 
	<div class="loading">
		<p align="center" style="margin: 100px;"><img src="../img/page-loader.gif" alt="Cargando..."/></p> 
	</div>
<!-- -----------------------------  Loading  --------------------------------------------- --> 
	
 <div class="container-fluid" style="margin-top: -5px; display:none;">
   <?php include "../includes/tabla_sup.php"; ?>
 </div>
   
  <div class="container-fluid" style="display:none">
   <div class="row">
    <div class="col-md-12 col-sm-12"> 

	<!-- -------------------------------------------------------------------------------------------------------- -->
	<!--                        Tabla Resumen de Rutas + Fecha                                                           -->
	<!-- -------------------------------------------------------------------------------------------------------- -->
	  <div class="row">
		
		<div class="col-sm-2 col-xs-2"></div>
		
		<div id="resumen_rutas" class="col-sm-7 col-xs-7" align="center">
			<table id="Tabla_Resumen_Rutas" class="table table-condensed table-striped table-responsive" style="font-size:10px">
				<thead>
					<th>
						<button type="button" class="btn btn-warning btn-xs"
								onclick="presionar_todos_los_botones_calcular()"
								style="font-size:10px">Calcular
						</button>
					</th>
					<th>N/A</th>
					<th><font color='#d9534f'>Ruta 1</font></th>
					<th><font color='#d9534f'>Ruta 2</font></th>
					<th><font color='#d9534f'>Ruta 3</font></th>
					<th><font color='#d9534f'>Ruta 4</font></th>
					<th><font color='#d9534f'>Ruta 5</font></th>
					<th><font color='#d9534f'>Ruta 6</font></th>
					<th><font color='#d9534f'>Ruta 7</font></th>
					<th><font color='#d9534f'>Ruta 8</font></th>
					<th><font color='#d9534f'>Ruta 9</font></th>
					<th><font color='#d9534f'>Ruta 10</font></th>
				</thead>
				<tbody>
				<tr>
					<td>Quantitat</td>
					<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
				</tr>
				<tr>
					<td>Distància</td>
					<td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td>
				</tr>
				<tr>
					<td>Temps</td>
					<td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td>
				</tr>				
				</tbody>
			</table>
		</div>
		
		<div style="display:table-cell; font-size:16px" align="right" class="col-sm-3 col-xs-3">
			<br><br>
			<strong>Data:</strong>  
			<input id="fecha" onchange= "updateFecha(this.value)" type="date" required="required" min="2000-01-01" max="<?php echo $ayer?>" 
				   name="fecha" style="font-weight:bold; background-color:rgb(220,220,255)" value="<?php echo $today?>"></input>	   
		</div>
		
	  </div>
	<!-- -------------------------------------------------------------------------------------------------------- -->
	<!--                        Fin Tabla Resumen de Rutas + Fecha                                                            -->
	<!-- -------------------------------------------------------------------------------------------------------- -->
		
		
		<div  style="padding-top: 2px;"></div>
		
		<?php echo $html_Llistar_Pedidos; ?>
		
   </div>
  </div>
 </div>
 
 
 
 <div class="container-fluid" style="display:none">
   <div class="row">
    <div class="col-md-12 col-sm-12"> 
		<!--<BR><BR><BR><h4><strong><u>LLISTA DE RUTES</u></h4></strong> -->
		<?php echo $html_Llistar_Rutas; ?>
	</div>
  </div>
 </div>

 
<!-- -----------------------------  Diálogo Seleccionar Repartidor  --------------------------------------------- --> 
	<div id="dialogo_repartidores" title = "Asignar Repartidor a Ruta" style="display:none">
		<input id="ruta_actual_repartidores" type="hidden"></input>
		<div id="dialogo_repartidores_contenido">cargando...</div>
	</div>
<!-- -----------------------------  Diálogo Seleccionar Furgoneta  --------------------------------------------- --> 
	<div id="dialogo_furgonetas" title = "Asignar Furgoneta a Ruta" style="display:none"> 
		<input id="ruta_actual_furgonetas" type="hidden"></input>
		<div id="dialogo_furgonetas_contenido">cargando...</div>
	</div>
		
<!-- -----------------------------  Diálogo Mostrar Mapa  ------------------------------------------------------ --> 
	<div class= "dialogo_mapa" id="dialogo_mapa" style="display:none">cargando...</div>
	
</body>
</html>