<html>
<ul class="nav nav-pills">
<!-- *** REPARTIDORES *** -->
<?php if ($sec=="repartidores"){?> 
    
	<li <?php if($pagact=="/gestio/lliuradors/repartidores/repartidores.php")
	            {echo 'class="active"';}?>>
	 <a <?php if($pagact=="/gestio/lliuradors/repartidores/repartidores.php")
	            {echo 'href="#"';}
              else
		        {echo 'href="/gestio/lliuradors/repartidores/repartidores.php"';}?>>Tots</a></li>
    
	<li <?php if($pagact=="/gestio/lliuradors/repartidores/repartidores_act.php")
	            {echo 'class="active"';}?>>
	 <a <?php if($pagact=="/gestio/lliuradors/repartidores/repartidores_act.php")
	            {echo 'href="#"';}
              else
		        {echo 'href="/gestio/lliuradors/repartidores/repartidores_act.php"';}?>>Disponibles</a></li>
	
	<li <?php if($pagact=="/gestio/lliuradors/repartidores/repartidores_vac.php")
	            {echo 'class="active"';}?>>
	 <a <?php if($pagact=="/gestio/lliuradors/repartidores/repartidores_vac.php")
	            {echo 'href="#"';}
              else
		        {echo 'href="/gestio/lliuradors/repartidores/repartidores_vac.php"';}?>>Vacances</a></li>
    
	<li <?php if($pagact=="/gestio/lliuradors/repartidores/repartidores_baj.php")
	            {echo 'class="active"';}?>>
	 <a <?php if($pagact=="/gestio/lliuradors/repartidores/repartidores_baj.php")
	            {echo 'href="#"';}
              else
		        {echo 'href="/gestio/lliuradors/repartidores/repartidores_baj.php"';}?>>Baixa Laboral</a></li>
    
	<li <?php if($pagact=="/gestio/lliuradors/repartidores/repartidores_noact.php")
	            {echo 'class="active"';}?>>
	 <a <?php if($pagact=="/gestio/lliuradors/repartidores/repartidores_noact.php")
	            {echo 'href="#"';}
              else
		        {echo 'href="/gestio/lliuradors/repartidores/repartidores_noact.php"';}?>>No Actius</a></li>
	
<?php };?>  

<!-- *** FURGONETAS *** -->

<?php if ($sec=="furgonetas"){?>
    
	<li <?php if($pagact=="/gestio/lliuradors/furgonetas/furgonetas.php")
	            {echo 'class="active"';}?>>
	 <a <?php if($pagact=="/gestio/lliuradors/furgonetas/furgonetas.php")
	            {echo 'href="#"';}
              else
		        {echo 'href="/gestio/lliuradors/furgonetas/furgonetas.php"';}?>>Totes</a></li>
    
	<li <?php if($pagact=="/gestio/lliuradors/furgonetas/furgonetas_act.php")
	            {echo 'class="active"';}?>>
	 <a <?php if($pagact=="/gestio/lliuradors/furgonetas/furgonetas_act.php")
	            {echo 'href="#"';}
              else
		        {echo 'href="/gestio/lliuradors/furgonetas/furgonetas_act.php"';}?>>Disponibles</a></li>
	
	<li <?php if($pagact=="/gestio/lliuradors/furgonetas/furgonetas_tall.php")
	            {echo 'class="active"';}?>>
	 <a <?php if($pagact=="/gestio/lliuradors/furgonetas/furgonetas_tall.php")
	            {echo 'href="#"';}
              else
		        {echo 'href="/gestio/lliuradors/furgonetas/furgonetas_tall.php"';}?>>Taller</a></li>    
    
	<li <?php if($pagact=="/gestio/lliuradors/furgonetas/furgonetas_noact.php")
	            {echo 'class="active"';}?>>
	 <a <?php if($pagact=="/gestio/lliuradors/furgonetas/furgonetas_noact.php")
	            {echo 'href="#"';}
              else
		        {echo 'href="/gestio/lliuradors/furgonetas/furgonetas_noact.php"';}?>>No Actives</a></li>
	
<?php };?>  

<!-- *** CREAR RUTAS *** -->

<?php if ($sec=="crear_rutas"){?>
    
	<li <?php if($pagact=="crear_rutas.php")
	            {echo 'class="active"';}?>>
	 <a <?php if($pagact=="crear_rutas.php")
	            {echo 'href="#"';}
              else
		        {echo 'href="crear_rutas.php"';}?>>Pedidos</a></li>
    
	<li <?php if($pagact=="crear_rutas_lista.php")
	            {echo 'class="active"';}
			  if($pagact=="crear_rutas.php")
	            {echo 'class="disabled"';}?>>
	 <a <?php if($pagact=="crear_rutas_lista.php")
	            {echo 'href="#"';}
              else
		        {echo 'href="crear_rutas_lista.php"';}?>>Rutas</a></li>
	
	<li <?php if($pagact=="tsp.php")
	            {echo 'class="active"';}
			  if($pagact=="crear_rutas.php")
	            {echo 'class="disabled"';}?>>
	 <a <?php if($pagact=="tsp.php")
	            {echo 'href="#"';}
              else
		        {echo 'href="tsp.php"';}?>>X</a></li>
<?php };?>

<!-- *** ESTADÍSTICAS *** -->

<?php if ($sec=="estadisticas"){?>
    
	<li <?php if($pagact=="estadisticas.php")
	            {echo 'class="active"';}?>>
	 <a <?php if($pagact=="estadisticas.php")
	            {echo 'href="#"';}
              else
		        {echo 'href="estadisticas.php"';}?>>Total</a></li>
    
	<li <?php if($pagact=="estadisticas_anys.php")
	            {echo 'class="active"';}?>>
	 <a <?php if($pagact=="estadisticas_anys.php")
	            {echo 'href="#"';}
              else
		        {echo 'href="estadisticas_anys.php"';}?>>Any</a></li>
	
	<li <?php if($pagact=="estadisticas_mesos.php")
	            {echo 'class="active"';}?>>
	 <a <?php if($pagact=="estadisticas_mesos.php")
	            {echo 'href="#"';}
              else
		        {echo 'href="estadisticas_mesos.php"';}?>>Mes</a></li>
			
		<li <?php if($pagact=="estadisticas_setmanes.php")
	            {echo 'class="active"';}?>>
	 <a <?php if($pagact=="estadisticas_setmanes.php")
	            {echo 'href="#"';}
              else
		        {echo 'href="estadisticas_setmanes.php"';}?>>Setmana</a></li>
		
<?php };?>


</ul>
</html>