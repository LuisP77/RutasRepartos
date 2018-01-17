<?php 
function Llistar_Repartidores($link)
{  
  $query="SELECT id, nom, tlf, actiu, vacances, baixa_laboral FROM lliuradors WHERE actiu = true AND vacances = false AND baixa_laboral = false";
  	  
  $result_set=mysql_query($query,$link);	
  if (!$result_set) {
     return 'No s’ha pogut executar la consulta: ' . mysql_error();
    } 

	$html = <<<HTML
	  <table id="principal" class="cell-border display compact" style="font-size:14px">
      <thead style="background-color:rgb(180,180,255)">
	  <th>ID</th>
      <th>Nom</th>
	  <th>Teléfon</th>
      <th>Actiu</th>
      <th>Vacances</th>
	  <th>Baixa Laboral</th>      <th style="text-align:center" style="text-align:center">Editar</th>
	  <th style="text-align:center">Eliminar</th>
    </thead>
   <tbody>
HTML;
    
	while($row=mysql_fetch_row($result_set))
    {
       $id = $row[0];
	   $nombre = $row[1];
	   $tlf = $row[2];
	   $activo = $row[3];
	   $vacaciones = $row[4];
	   $baja_laboral = $row[5];
	   
	   if ($activo){
		   $texto_activo = '<a><span class="glyphicon glyphicon-ok">si</span></a>';
	   }else{
		   $texto_activo = '<a><span class="glyphicon glyphicon-remove">no</span></a>';
	   }   
	   if ($vacaciones){
		   $texto_vacaciones = '<a><span class="glyphicon glyphicon-ok">si</span></a>';
	   }else{
		   $texto_vacaciones = '<a><span class="glyphicon glyphicon-remove">no</span></a>';
	   }
	   if ($baja_laboral){
		   $texto_baja_laboral = '<a><span class="glyphicon glyphicon-ok">si</span></a>';
	   }else{
		   $texto_baja_laboral = '<a><span class="glyphicon glyphicon-remove">no</span></a>';
	   }
	   
	    $html = $html . <<<HTML
        <tr>
        <td>$id</td>
        <td>$nombre</td>
        <td>$tlf</td>
		<td>$texto_activo</td>		
		<td>$texto_vacaciones</td>
		<td>$texto_baja_laboral</td>
		<td align="center"><a href="javascript:edit_id('$id')"><span class="glyphicon glyphicon-edit"></span></a></td>
        <td align="center"><a href="javascript:delete_id('$id')"><span class="glyphicon glyphicon-remove"></span></a></td>
        </tr>
HTML;

    }
	
	$html = $html . <<<HTML
         </tbody>
    </table>
HTML;

	mysql_free_result($result_set);

	return $html;
}

$sec = "repartidores"; $pagact = "/gestio/lliuradors/repartidores/repartidores_act.php";
include_once "../includes/conexion.php";
include_once "../includes/funciones_crud.php";
 // Eliminar registro
    if(isset($_GET['delete_id']))
    {
      $sql_query="DELETE FROM lliuradors WHERE id =".$_GET['delete_id'];
      mysql_query($sql_query);
      header("Location: ".$pagact);//$_SERVER[PHP_SELF]");
      exit(1);
	}
    // Fin eliminar registro

  $html= Llistar_Repartidores($link);

  mysql_close($link);
  
  ///FINAL DEL PHP
 ///////////////////////////////////////////////////////////////////////////////////////////// 
 ///////////////////////////////////////////////////////////////////////////////////////////// 
 /////////////////////////////////////////////////////////////////////////////////////////////
  //Inicio del HTML
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

<script type="text/javascript">  
  //DataTables
  $(function(){
    $('#principal').DataTable(
      {  
        responsive: true,
		paging: false,
        scrollY: 390,
 	    "columnDefs": [{ "orderable": false, "targets": 6},{ "orderable": false, "targets": 7}],		
		"oLanguage": {
            "sProcessing":     "Processant...",
            "sLengthMenu":     "Mostrar _MENU_ registres",
            "sZeroRecords":    "No s’han trobat resultats",
            "sEmptyTable":     "No hi ha dades disponibles en aquesta taula",
            "sInfo":           "Mostrant registres del _START_ al _END_ d’un total de _TOTAL_ registres",
            "sInfoEmpty":      "Mostrant registres del 0 al 0 d’un total de 0 registres",
            "sInfoFiltered":   "(Filtratge d’un total de _MAX_ registres)",
            "sInfoPostFix":    "",
            "sSearch":         "Cercar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Carregant…",
            "oPaginate": {
            "sFirst":    "Primer",
            "sLast":     "Últim",
            "sNext":     "Següent",
            "sPrevious": "Anterior"
            },
          "fnInfoCallback": null,
        }

		
      });	  
  });
</script>  
  
</head>

<body>
 
 <div class="container-fluid" style="margin-top: -5px;">
   <?php include "../includes/tabla_sup.php"; ?>
 </div>
 
 <div class="clearfix" style="margin-bottom:2px;"></div>
  <div class="container-fluid">
   <div class="row">
    <div class="col-md-12 col-sm-12"> 
     <?php include "../includes/nav_pills.php"; ?>
	 <?php echo $html; ?>	
   </div>
  </div>
 </div>
</div>
  
   
</body> 
</html>