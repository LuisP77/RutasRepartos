<?php  
/********************************************************************************************************************/
/*                                FUNCIÓN LISTAR ESTADÍSTICAS REPARTIDORES                                          */
/********************************************************************************************************************/
function Llistar_Estadisticas_Repartidores($link,$fecha_inicio,$today){
	  
	$query="SELECT id,nom FROM `lliuradors`"; 	
	
    $result_set = mysql_query($query,$link);
	
    if (!$result_set) {
		return 'No s’ha pogut executar la consulta: ' . mysql_error();
    }
	
$html = <<<HTML
	  <table id="principal_repartidores" class="cell-border display compact table-responsive" style="font-size:16px">
      <thead style="background-color:rgb(150,150,255); font-size:80%">
		<tr>
			<th>ID</th>
			<th>Nom</th>
			<th>Comandes</th>
			<th>Línies</th>
			<th>Dist (km)</th>
			<th>Temps (h)</th>      
		</tr>	
    </thead>
	<tfoot style="font-size:12px">
		<tr>
			<th>ID</th>
			<th>Nom</th>
			<th>Comandes</th>
			<th>Línies</th>
			<th>Dist (km)</th>
			<th>Temps (h)</th>      
		</tr>	
    </tfoot>
   <tbody>
HTML;
	
	while($row=mysql_fetch_row($result_set))
    {
		$id = $row[0];
		$nom = $row[1];
		
		list($comandes,$lineas,$dist,$temps) = estadisticas_repartidor($link,$id,$fecha_inicio,$today);
		//$comandes = comandes_repartidor($link,$id,'2000-01-01',$today);
		//$lineas = linies_repartidor($link,$id,'2000-01-01',$today);
		//$dist = distancia_recorrida_repartidor($link,$id,'2000-01-01',$today);
		//$temps = tiempo_conduciendo_repartidor($link,$id,'2000-01-01',$today);
	
		$html = $html . <<<HTML
		<tr>
        <td style="font-size:100%">$id</td>
        <td>$nom</td>
		<td>$comandes</td>
		<td>$lineas</td>
		<td>$dist</td>
		<td>$temps</td>
		</tr>	
HTML;
	}	
	$html = $html . <<<HTML
		</tbody>
    </table>
HTML;
	return $html;
}


/********************************************************************************************************************/
/*                                FUNCIÓN LISTAR ESTADÍSTICAS FURGONETAS                                          */
/********************************************************************************************************************/
function Llistar_Estadisticas_Furgonetas($link,$fecha_inicio,$today){
	  
	$query="SELECT id,nom,matricula FROM `furgonetes` ORDER BY nom"; 	
	
    $result_set = mysql_query($query,$link);
	
    if (!$result_set) {
		return 'No s’ha pogut executar la consulta: ' . mysql_error();
    }
	
$html = <<<HTML
	  <table id="principal_furgonetas" class="cell-border display compact table-responsive" style="font-size:16px">
      <thead style="background-color:rgb(150,150,255); font-size:80%">
		<tr>
			<th>ID</th>
			<th>Nom</th>
			<th>Matrícula</th>
			<th>Dist (km)</th>      
		</tr>	
    </thead>
	<tfoot style="font-size:12px">
		<tr>
			<th>ID</th>
			<th>Nom</th>
			<th>Matrícula</th>
			<th>Dist (km)</th>      
		</tr>	
    </tfoot>
   <tbody>
HTML;
	
	while($row=mysql_fetch_row($result_set))
    {
		$id = $row[0];
		$nom = $row[1];
		$matricula = $row[2];
		
		$dist = distancia_recorrida_furgoneta($link,$id,$fecha_inicio,$today);
	
		$html = $html . <<<HTML
		<tr>
        <td style="font-size:100%">$id</td>
        <td>$nom</td>
		<td>$matricula</td>
		<td>$dist</td>
		</tr>	
HTML;
	}	
	$html = $html . <<<HTML
		</tbody>
    </table>
HTML;
	return $html;
}

/********************************************************************************************************************/
/*                                       INICIO PHP                                                                 */
/********************************************************************************************************************/
  
  $sec = "estadisticas"; $pagact = "estadisticas_anys.php"; 
  
  $today = date("Y-m-d");
  $year = date("Y");
  $fecha_inicio = $year.'-01-01';

//  $today = strtotime(date("Y-m-d", strtotime($today)) . " +1 day");
//  $today = date("Y-m-d",$today);
  
//  $today = "2016-06-28";
  
	include_once "../includes/conexion.php";
	include_once "modul_estadisticas.php";
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
  	$html_Llistar_Estadisticas_Repartidores = Llistar_Estadisticas_Repartidores($link, $fecha_inicio, $today);
	$html_Llistar_Estadisticas_Furgonetas = Llistar_Estadisticas_Furgonetas($link, $fecha_inicio, $today);
	$html_Furgonetas_Alquiladas = furgonetas_alquiladas($link, $fecha_inicio, $today);
	
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
		
  <script type="text/javascript" src="funciones_estadisticas.js"></script>
		
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/flick/jquery-ui.css">		
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
  
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    
<script type="text/javascript"> 

//-----------------------------------------------------------------------------------------------------
//                          Document READY
//-----------------------------------------------------------------------------------------------------

	jQuery(document).ready(function() {		

		dataTables();
		GraficaRepartidores();
		GraficaFurgonetas();
		
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
<!--
 <div class="container-fluid" style="margin-top: -5px; display:none;">
   <?php //include "../includes/tabla_sup.php"; ?>
 </div>
-->   
 
  <div class="container-fluid" style="display:none">
		
		<div class="row">
			<div class="col-md-6 col-sm-6"> 
				<?php include "../includes/nav_pills.php"; ?>
			</div>	
			<div  style="padding-top: 50px;"></div>
		</div>

		<ul class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#menu_repartidores">Lliuradors</a>
			<li><a data-toggle="tab" href="#menu_furgonetas">Furgonetes</a>
		</ul>
		
		<div class="tab-content">
		
			<div id="menu_repartidores" class="tab-pane fade in active">
			
					<div class="row">
						<br/>
					</div>
					<div class="row">
						<div class="col-md-6 col-sm-6"> 	
							<!-- <td><h4><strong>&nbsp;ESTADÍSTIQUES LLIURADORS</strong></h4></td> -->
							<?php echo $html_Llistar_Estadisticas_Repartidores; ?>
						</div>
					</div>
					<div class="row">
						<div id="chart_repartidores"></div>
					</div>
			
			</div>
			
			<div id="menu_furgonetas" class="tab-pane fade">
							
					<div class="row">
						<br/>
					</div>
					<div class="row">
						<div class="col-md-6 col-sm-6"> 	
							<!-- <td><h4><strong>&nbsp;ESTADÍSTIQUES FURGONETES</strong></h4></td> -->
							<?php echo $html_Llistar_Estadisticas_Furgonetas; ?>
						</div>
						<div class="col-md-1 col-sm-1">
						</div>
						<div class="col-md-4 col-sm-4"> 	
							<h4><strong>&nbsp;Total d'furgonetes llogades:&nbsp;<?php echo $html_Furgonetas_Alquiladas; ?></strong></h4>
						</div>
					</div>
					<div class="row">
						<div id="chart_furgonetas"></div>
					</div>
	
			</div>
		
		</div>
  </div>
 
	
</body>
</html>