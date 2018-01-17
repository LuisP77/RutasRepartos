<html>
<!-- *** REPARTIDORES *** -->
  <?php if ($sec=="repartidores"){?> 
    <table width="100%">
      <tr>
        <td><h4><strong>&nbsp;LLIURADORS</strong></h4></td> 
        <td align="right"><a href="repartidores_add.php" class="btn btn-large btn-primary"><i class="glyphicon glyphicon-plus"></i> &nbsp; Afegir Lliurador</a></td>
      </tr>
    </table>
  <?php ;}?>

<!-- *** FURGONETAS *** -->
  <?php if ($sec=="furgonetas"){?> 
    <table width="100%">
       <tr>
         <td><h4><strong>&nbsp;FURGONETES</strong></h4></td> 
         <td align="right"><a href="furgonetas_add.php" class="btn btn-large btn-primary"><i class="glyphicon glyphicon-plus"></i> &nbsp; Afegir Furgoneta</a></td>
       </tr>
     </table>
  <?php };?>

<!-- *** CREAR RUTAS *** -->
  <?php if ($sec=="crear_rutas"){?> 
    <table width="100%">
		<tr>
			<td><h4><strong>&nbsp;CREAR RUTES</strong></h4></td>
		</tr>
    </table>
  <?php ;}?>

<!-- *** HISTÓRICO *** -->
  <?php if ($sec=="historic"){?> 
    <table width="100%">
		<tr>
			<td><h4><strong>&nbsp;HISTÒRIC</strong></h4></td>
		</tr>
    </table>
  <?php ;}?>
  
 <!-- *** ESTADÍSTICAS *** -->
  <?php if ($sec=="estadisticas"){?> 
    <table width="100%">
		<tr>
			<td><h4><strong>&nbsp;ESTADÍSTIQUES</strong></h4></td>
		</tr>
    </table>
  <?php ;}?>
 
</html>