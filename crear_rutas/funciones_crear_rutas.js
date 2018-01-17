	var band_cambio_ruta = false;
	var n_max_rutas_permitidas = 10;
	var n_columnas_tabla_principal = 24;
//----- columnas tablas de rutas -------------
	var n_columnas_tabla_rutas = 25;
	
	var columna_id_comanda = 3;
	var columna_lineas_tabla_ruta = 5;
	var columna_direccion_tabla_ruta = 8;
	var columna_distancia_tabla_ruta = 14;
	var columna_tiempo_tabla_ruta = 15;
	var columna_posicion_tabla_ruta = 16;
	var columna_sec_tabla_ruta = 17;
	var columna_ref_tabla_ruta = 18;
	var columna_fv_tabla_ruta = 19;
	var columna_id_usuari_tabla_ruta = 20;
	var columna_importPagat = 21;
	var columna_totalPagat = 22;
	var columna_metPagament = 23;
	var columna_comentaris = 24;
	
/* ******************************************************************************************* */
	function updateFecha(fecha){
		window.location.href='crear_rutas.php?fecha='+fecha;
	}  
/* ******************************************************************************************* */
	function fecha_editable(){
		var today = new Date();
		var yyyy = today.getFullYear();
		var mm = today.getMonth()+1;
		mm = ('0' + mm).slice(-2);
		var dd = today.getDate();
		dd = ('0' + dd).slice(-2);
		today = yyyy+'-'+mm+'-'+dd;
		var fecha = document.getElementById("fecha").value;
		
		if (today<=fecha){
			var pag_editable=true;
		}else{
			var pag_editable = false;
		}
		return pag_editable;
	}
/* ******************************************************************************************* */
/*                    UPDATE POSICIÓN después de cambiar ruta                                  */
/* ******************************************************************************************* */
	
	function updatePosicionRuta(id,ruta){
		
		Panel = document.getElementById("panel_ruta_"+ruta);			
		Panel.style.display = "block";
			
		tabla_ruta = document.getElementById("tabla_ruta_"+ruta);
		pos = tabla_ruta.rows.length;
		
		tabla_principal = document.getElementById("principal");
		N = tabla_principal.rows.length;
		
		if (pos==1){
			for (i = 0; i < N; i++) {
				if(tabla_principal.rows[i].cells[0].innerText == id){
					tabla_principal.rows[i].cells[12].innerText = pos;
				}
			}
		}else{
			aux_pos = tabla_ruta.rows[pos-1].cells[columna_posicion_tabla_ruta].innerText;
			pos = parseInt(aux_pos) + 1;
			for (i = 0; i < N; i++) {
				if(tabla_principal.rows[i].cells[0].innerText == id){
					tabla_principal.rows[i].cells[12].innerText = pos;
				}
			}	
		}
		
	// Update Tabla Principal Auxiliar
		tabla_principal_aux = document.getElementById("principal_aux");
		N = tabla_principal_aux.rows.length;
		for(i=1; i<N; i++){
			if (tabla_principal_aux.rows[i].cells[0].innerText == id){
				tabla_principal_aux.rows[i].cells[11].innerText = ruta;
				tabla_principal_aux.rows[i].cells[12].innerText = pos;
			} 
		}

	//// AJAX
		var request = $.ajax({
						url: "ajax_posicion.php",
						type: "POST",
						data: { accio: "cambio_ruta", 
								pos: pos,
							    id: id
							  },
						dataType: "html"
					});	
					request.done(function(msg)
					{
						if (parseInt(msg)==-1)
						{
							alert('ERROR!!!');
						}
						else
						{
						}	
					});

	}
	
	
/* ******************************************************************************************* */
/*                    Función PRESIONAR FLECHAS                                                */
/* ******************************************************************************************* */
	
	function presionar_flechas(){
	
		$(".up,.down").click(function () {
               
			var $element = this;
			var row = $($element).parents("tr:first");
			var row_index = row.index();
			
			var msgId = $( this ).closest( 'table' ).attr( 'id' );
			var tabla = document.getElementById(msgId);
			var N = tabla.rows.length;

			
			if($(this).is('.up')){

				if (row_index != 1){
					
					idA = tabla.rows[row_index].cells[columna_id_comanda].innerText;
					valorA = tabla.rows[row_index].cells[columna_posicion_tabla_ruta].innerText;
					idB = tabla.rows[row_index-1].cells[columna_id_comanda].innerText;
					valorB = tabla.rows[row_index-1].cells[columna_posicion_tabla_ruta].innerText;
					tabla.rows[row_index].cells[columna_posicion_tabla_ruta].innerText = valorB;
					tabla.rows[row_index-1].cells[columna_posicion_tabla_ruta].innerText = valorA;
					
					row.insertBefore(row.prev());
					
					updatePosicionFlecha(idA, valorA, idB, valorB);
				}
			
			}
         
			else{
				
				if (row_index != N-1){
					
					idA = tabla.rows[row_index].cells[columna_id_comanda].innerText;
					valorA = tabla.rows[row_index].cells[columna_posicion_tabla_ruta].innerText;
					idB = tabla.rows[row_index+1].cells[columna_id_comanda].innerText;
					valorB = tabla.rows[row_index+1].cells[columna_posicion_tabla_ruta].innerText;
					tabla.rows[row_index].cells[columna_posicion_tabla_ruta].innerText = valorB;
					tabla.rows[row_index+1].cells[columna_posicion_tabla_ruta].innerText = valorA;
					
					row.insertAfter(row.next());
					
					updatePosicionFlecha(idA, valorA, idB, valorB);
				}
				
			}
			
		});
	};	
/* ******************************************************************************************* */
/*                    UPDATE POSICIÓN después de presionar flechas                             */
/* ******************************************************************************************* */
	function updatePosicionFlecha(idA, valorA, idB, valorB){

		var tabla_principal = document.getElementById("principal");
		var N = tabla_principal.rows.length;

		for(i=1; i<N; i++){
			if (tabla_principal.rows[i].cells[0].innerText == idA){
				tabla_principal.rows[i].cells[12].innerText = valorB;
			}
			if (tabla_principal.rows[i].cells[0].innerText == idB){
				tabla_principal.rows[i].cells[12].innerText = valorA;
			}
		}	

		//// AJAX
		var request = $.ajax({
						url: "ajax_posicion.php",
						type: "POST",
						data: { accio: "cambio_flecha", 
								idA: idA,
							    valorA: valorA,
								idB: idB,
							    valorB: valorB,
							  },
						dataType: "html"
					});	
					request.done(function(msg)
					{
						if (parseInt(msg)==-1)
						{
							alert('ERROR!!!');
						}
						else
						{
						}	
					});		

		//// aux

		var tabla_principal_aux = document.getElementById("principal_aux");
		var N = tabla_principal_aux.rows.length;

		for(i=1; i<N; i++){
			if (tabla_principal_aux.rows[i].cells[0].innerText == idA){
				tabla_principal_aux.rows[i].cells[12].innerText = valorB;
			}
			if (tabla_principal_aux.rows[i].cells[0].innerText == idB){
				tabla_principal_aux.rows[i].cells[12].innerText = valorA;
				ruta = tabla_principal_aux.rows[i].cells[11].innerText;
			}
		}			

//--------------------- Botón y tabla resumen a no calculado -------------------------------------------------		
		$( "#boton_calcular_"+ruta ).removeClass( "btn-success" ).addClass( "btn-danger" );
		
		tabla_resumen = document.getElementById("Tabla_Resumen_Rutas");
		tabla_resumen.rows[0].cells[parseInt(ruta)+1].innerHTML = "<font color='#d9534f'>Ruta "+ruta+"</font>";
	
	}
/* ******************************************************************************************* */
/*                                   TABLA RESUMEN                                             */
/* ******************************************************************************************* */
	function llenar_resumen(){

		var pedidos_en_ruta = new Array(50).fill(0);

		table = document.getElementById("principal_aux");
		for (i = 1; i<table.rows.length; i++) {
			index = jQuery("<p>" + table.rows[i].cells[11].innerText + "</p>").text();
			pedidos_en_ruta[index]++;
		}	

		table = document.getElementById("Tabla_Resumen_Rutas");
		for (i=0; i<=n_max_rutas_permitidas; i++){
			table.rows[1].cells[i+1].innerText = pedidos_en_ruta[i];
		} 
		
		
		for (i=1;i<=n_max_rutas_permitidas;i++){
			
			asignados = jQuery("<p>"+table.rows[1].cells[i+1].innerText+"</p>").text();
			
			if (asignados == "0"){
			
				Panel = document.getElementById("panel_ruta_"+i);			
				
				if (Panel.style.display != "none"){
				
					table.rows[0].cells[i+1].style.display = "none";
					table.rows[1].cells[i+1].style.display = "none";
					table.rows[2].cells[i+1].style.display = "none";
					table.rows[3].cells[i+1].style.display = "none";
					
					$("#repartidor_"+i).val("");
			
				//llamar ajax para eliminar información de ruta
					
					var request = $.ajax({
						url: "ajax_rutas.php",
						type: "POST",
						data: {accio: "elimRutaInfo", 
							    fecha: $("#fecha").val(),
								ruta: i
							  },
						dataType: "html"
					});	
					request.done(function(msg)
					{
						if (parseInt(msg)==-1)
						{
							alert('ERROR!!!');
						}
						else
						{
						//$("#dialogo_repartidores_contenido").html(msg);
						}	
					});
				
				//fin llamar ajax para eliminar información de ruta	
					
					
				}	
			
			}else{
			
				table.rows[0].cells[i+1].style.display = "table-cell";
				table.rows[1].cells[i+1].style.display = "table-cell";
				table.rows[2].cells[i+1].style.display = "table-cell";
				table.rows[3].cells[i+1].style.display = "table-cell";
			
			}	

		}
	}	
	
/* ******************************************************************************************* */
/*            Llenar Columnas Letras correspondientes a Google Maps en Tabla Ruta              */	
/* ******************************************************************************************* */
	
	function Llenar_Letras_GoogleMaps(ruta){		
			Table_Rutas = document.getElementById("tabla_ruta_"+ruta);
			N = Table_Rutas.rows.length;
			if (N>1){
				for (i=1;i<N;i++){
					Table_Rutas.rows[i].cells[0].innerHTML = String.fromCharCode(i+64);
				}
			}
	}
	
/* ******************************************************************************************* */
/*                                     TABLAS RUTAS                                            */	
/* ******************************************************************************************* */
	function llenar_tablas_ruta(presionar_botones_calcular){	

		table = document.getElementById("principal_aux");
		N = table.rows.length;
		
	// Llenar matriz auxiliar	
		var A = new Array(50);
		for (i = 0; i < 50; i++){
			A[i]=new Array(50);
		}
		
		for (i = 0; i < N; i++) {
			for (j = 0; j <= n_columnas_tabla_principal; j++){
				valor = jQuery("<p>" + table.rows[i].cells[j].innerText + "</p>").text();
				A[i][j] = valor;
			}
		}
				
	// Limpiar Tablas de Rutas
		for (i=1;i<=n_max_rutas_permitidas;i++){
				Table_Rutas = document.getElementById("body_ruta_"+i);
				
				while(Table_Rutas.rows.length > 0) {
					Table_Rutas.deleteRow(0);
				}	
		}

	// Escribir Tablas Rutas	
		for (i = 1; i < N; i++) {        // i --> 0 el title y N el footer!!
					
			valor = A[i][11];
			
			if((valor!="0")&&(valor!=null)){
				ruta = document.getElementById("body_ruta_"+A[i][11]);
				rowCount = ruta.rows.length;
				
				row = ruta.insertRow(rowCount);
			
				row.insertCell(0).innerHTML = "";//String.fromCharCode(rowCount+64); //Letra en Google Maps
			
				var celda_flecha_arriba = row.insertCell(1);
				celda_flecha_arriba.style.paddingLeft = "0px";
				celda_flecha_arriba.style.paddingRight = "0px";
				celda_flecha_arriba.innerHTML = "<a class='up'><span class='glyphicon glyphicon-arrow-up'></span></a>";
				
				var celda_flecha_abajo = row.insertCell(2);				
				celda_flecha_abajo.style.paddingLeft = "0px";
				celda_flecha_abajo.style.paddingRight = "0px";
				celda_flecha_abajo.innerHTML = "<a class='down'><span class='glyphicon glyphicon-arrow-down'></span></a>";
				
				
				row.insertCell(3).innerHTML = A[i][0]; //id_comanda
				row.insertCell(4).innerHTML = A[i][20]; //NC
				row.insertCell(5).innerHTML = A[i][19]; //líneas
				row.insertCell(6).innerHTML = A[i][1]; //nombre
				row.insertCell(7).innerHTML = A[i][18]; //tlf
				row.insertCell(8).innerHTML = "<div class='direccion_editable' style='border-bottom:none' id='"+A[i][0]+"' id_ruta='"+valor+"'>"+A[i][2]+", "+A[i][4]+", "+A[i][5]+"</div>";
				row.insertCell(9).innerHTML = A[i][13]; //ascensor
				row.insertCell(10).innerHTML = "<div class='comentarios_editable' style='border-bottom:none' id='"+A[i][0]+"'>"+A[i][6]+"</div>";
				row.insertCell(11).innerHTML = "<div class='comentarios_editable' style='border-bottom:none' id='"+A[i][0]+"'>"+A[i][7]+"</div>";
				row.insertCell(12).innerHTML = A[i][8]; //franja
				row.insertCell(13).innerHTML = A[i][9]; //zona
				row.insertCell(14).innerHTML = "-";  //distancia
				row.insertCell(15).innerHTML = "-";  // tiempo

				var celdaPosicion = row.insertCell(16);
				celdaPosicion.innerHTML = A[i][12]; //posición
				celdaPosicion.style.display = 'none';
				
				row.insertCell(17).innerHTML = "<div class='sec_editable' id='"+A[i][0]+"'>"+A[i][14]+"</div>"; //sec
				row.insertCell(18).innerHTML = "<div class='ref_editable' id='"+A[i][0]+"'>"+A[i][15]+"</div>";  //ref
				row.insertCell(19).innerHTML = "<div class='fv_editable' id='"+A[i][0]+"'>"+A[i][16]+"</div>";  //fv
				
				var celdaPosicion = row.insertCell(20);
				celdaPosicion.innerHTML = A[i][17]; //id_usuari
				celdaPosicion.style.display = 'none';

				var celdaPosicion = row.insertCell(21);
				celdaPosicion.innerHTML = A[i][21]; //importPagat
				celdaPosicion.style.display = 'none';
				
				var celdaPosicion = row.insertCell(22);
				celdaPosicion.innerHTML = A[i][22]; //totalPagat
				celdaPosicion.style.display = 'none';
				
				var celdaPosicion = row.insertCell(23);
				celdaPosicion.innerHTML = A[i][23]; //metPagament
				celdaPosicion.style.display = 'none';
				
				var celdaPosicion = row.insertCell(24);
				celdaPosicion.innerHTML = A[i][24]; //comentaris
				celdaPosicion.style.display = 'none';
				
				
			}	
		
		}
	
	// OCULTAR PANELES de rutas no utilizadas en la Lista de Rutas
		for (i=1;i<=n_max_rutas_permitidas;i++){

			Table_Rutas = document.getElementById("tabla_ruta_"+i);
			N = Table_Rutas.rows.length;
			rows = Table_Rutas.rows;
			Panel = document.getElementById("panel_ruta_"+i);			
			
			if (N > 1){

			//---------------------- ORDENAR según posición en ruta -----------------------------		
				do{
					band = true;	
					for(j=1;j<N-1;j++){
						for(k=j+1;k<N;k++){
							if (parseInt(Table_Rutas.rows[j].cells[columna_posicion_tabla_ruta].innerText)>parseInt(Table_Rutas.rows[k].cells[columna_posicion_tabla_ruta].innerText)){
								band = false;
								var parent = rows[j].parentNode;
								parent.insertBefore(rows[k],rows[j]);
							}			
						}
					}
				}while(band==false);
				
				Panel.style.display = "block";
		//-----------------------------------------------------------------------------------------	
			}else{
				Panel.style.display = "none";
			}

		}	
		
		for (j=1;j<=n_max_rutas_permitidas;j++){
			Llenar_Letras_GoogleMaps(j);
		}
		
//------------------------- PRESIONAR BOTONES de calcular ruta -------------------------------------//
		if(presionar_botones_calcular){
			presionar_todos_los_botones_calcular();
		}
		
	}
	
/* ******************************************************************************************* */
/*                        PRESIONAR BOTÓN CALCULAR                                             */ 
/* ******************************************************************************************* */
function presiona_boton_calcular(i,tiempo){
	setTimeout(function(){
			boton = document.getElementById("boton_calcular_"+i);
			boton.click()
		},  tiempo);
}
/* ******************************************************************************************* */
/*                        PRESIONAR TODOS LOS BOTONES CALCULAR                                 */ 
/* ******************************************************************************************* */
	function presionar_todos_los_botones_calcular(){	
		delay = 1500;
		tiempo = 2000;
		for(i=1;i<=n_max_rutas_permitidas;i++){
			panel = document.getElementById("panel_ruta_"+i);
			boton = document.getElementById("boton_calcular_"+i);
			if ((panel.style.display == "block")&&($(boton).attr('class')=="btn btn-danger")){
				boton = document.getElementById("boton_calcular_"+i);
				presiona_boton_calcular(i,tiempo);
				tiempo += delay;
			}	
		}
	}	
/* ******************************************************************************************* */
/*                                     REPARTIDORES                                            */ 
/* ******************************************************************************************* */
function abrir_dialogo_repartidores(nruta){
	// cargando
	$("#dialogo_repartidores_contenido").html("Carregant...");
	$('#dialogo_repartidores').dialog('option', 'title', 'Assignar lliurador a ruta núm. '+ nruta);
	$('#ruta_actual_repartidores').val(nruta);
	//llamar ajax para cargar información al diálogo
	var request = $.ajax({
						url: "ajax_repartidores.php",
						type: "POST",
						data: {accio: "listar", 
							    fecha: $("#fecha").val()
							  },
						dataType: "html"
					});	
					$("#dialog-editar").dialog("close");
					request.done(function(msg)
					{
						if (parseInt(msg)==-1)
						{
							alert('ERROR!!!');
						}
						else
						{
						$("#dialogo_repartidores_contenido").html(msg);
						}	
					});
	
	//abrir dialogo
	$("#dialogo_repartidores").dialog("open");	
}
/* ******************************************************************************************* */
function guardar_repartidor(id,nombre){
		nruta = $("#ruta_actual_repartidores").val();
		fecha = $("#fecha").val();
		$("#repartidor_"+nruta).val(nombre);
//llamar ajax
	var request = $.ajax({
						url: "ajax_repartidores.php",
						type: "POST",
						data: { accio: "guardar", 
								ruta:  nruta,
							    id: id,
								fecha: fecha
							  },
						dataType: "html"
					});	
					$("#dialogo_repartidores").dialog("close");
					request.done(function(msg)
					{
						if (parseInt(msg)==-1)
						{
							alert('ERROR!!!');
						}
						else
						{
						//alert(msg);
						//$("#dialogo_repartidores_contenido").html(msg);
						}	
					});
		
}
/* ******************************************************************************************* */
function limpiar_repartidor(){
	nruta = $("#ruta_actual_repartidores").val();
	fecha = $("#fecha").val();
	$("#repartidor_"+nruta).val("");	
	//llamar ajax
	var request = $.ajax({
						url: "ajax_repartidores.php",
						type: "POST",
						data: { accio: "limpiar", 
								ruta:  nruta,
								fecha: fecha
							  },
						dataType: "html"
					});	
					$("#dialogo_repartidores").dialog("close");
					request.done(function(msg)
					{
						if (parseInt(msg)==-1)
						{
							alert('ERROR!!!');
						}
						else
						{
						//alert(msg);
						}	
					});

}

/* ******************************************************************************************* */
/*                                     FURGONETAS                                              */
/* ******************************************************************************************* */
function abrir_dialogo_furgonetas(nruta){
	// cargando
	$("#dialogo_furgonetas_contenido").html("Carregant...");
	$('#dialogo_furgonetas').dialog('option', 'title', 'Assignar furgoneta a ruta núm. '+ nruta);
	$('#ruta_actual_furgonetas').val(nruta);

	//llamar ajax para cargar información al diálogo
	var request = $.ajax({
						url: "ajax_furgonetas.php",
						type: "POST",
						data: {accio: "listar", 
							    fecha: $("#fecha").val()
							  },
						dataType: "html"
					});	
					$("#dialog-editar").dialog("close");
					request.done(function(msg)
					{
						if (parseInt(msg)==-1)
						{
							alert('ERROR!!!');
						}
						else
						{
						$("#dialogo_furgonetas_contenido").html(msg);
						}	
					});
	
	//abrir dialogo
	$("#dialogo_furgonetas").dialog("open");	
}
/* ******************************************************************************************* */
function guardar_furgoneta(id,nombre){
		nruta = $("#ruta_actual_furgonetas").val();
		fecha = $("#fecha").val();
		$("#furgoneta_"+nruta).val(nombre);
//llamar ajax
	var request = $.ajax({
						url: "ajax_furgonetas.php",
						type: "POST",
						data: { accio: "guardar", 
								ruta:  nruta,
							    id: id,
								fecha: fecha
							  },
						dataType: "html"
					});	
					$("#dialogo_furgonetas").dialog("close");
					request.done(function(msg)
					{
						if (parseInt(msg)==-1)
						{
							alert('ERROR!!!');
						}
						else
						{
						//alert(msg);
						//$("#dialogo_furgonetass_contenido").html(msg);
						}	
					});
		
}
/* ******************************************************************************************* */
function limpiar_furgoneta(){
	nruta = $("#ruta_actual_furgonetas").val();
	fecha = $("#fecha").val();
	$("#furgoneta_"+nruta).val("");	
	//llamar ajax
	var request = $.ajax({
						url: "ajax_furgonetas.php",
						type: "POST",
						data: { accio: "limpiar", 
								ruta:  nruta,
								fecha: fecha
							  },
						dataType: "html"
					});	
					$("#dialogo_furgonetas").dialog("close");
					request.done(function(msg)
					{
						if (parseInt(msg)==-1)
						{
							alert('ERROR!!!');
						}
						else
						{
						//alert(msg);
						}	
					});

}

/* ******************************************************************************************* */
/*                        CALCULAR DISTANCIAS Y TIEMPOS DE RUTA                                */
/* ******************************************************************************************* */
function calcular_tiempos_ruta(n_ruta){
	
	dir_almacen = "Carretera Constanti, Km 3, 43204, Reus, Tarragona";
	calculoExitoso = true;
	
	tabla_ruta = document.getElementById("tabla_ruta_"+n_ruta);
	N = tabla_ruta.rows.length;
//--------------   N° Comandes y N° Líneas   ------------------------------------------------------------------
	NComandes = N-1;
	NLinies = 0;
	for (i = 1; i < N; i++) {
		valor = parseInt(jQuery("<p>" + tabla_ruta.rows[i].cells[columna_lineas_tabla_ruta].innerText + "</p>").text());
		NLinies = NLinies + valor;
	}	
//--------------   Llenar matriz auxiliar	----------------------------------------------------------------
	var A = new Array(50);
	var idComanda = new Array(50);
		
	for (i = 0; i < N; i++) {
			valor = jQuery("<p>" + tabla_ruta.rows[i].cells[columna_direccion_tabla_ruta].innerText + "</p>").text();
			A[i] = valor;
			
			valor = jQuery("<p>" + tabla_ruta.rows[i].cells[columna_id_comanda].innerText + "</p>").text();
			idComanda[i] = valor;
	}
	
// ---------------    API GOOGLE MAPS     -----------------------------------------------------------------
	var directionsService = new google.maps.DirectionsService;
	
//------------------  Almacén -> Primera Entrega -----------------------------------------------------------
	dir_primera = jQuery("<p>" + A[1] + "</p>").text();
	
	directionsService.route({
		origin: dir_almacen,
		destination: dir_primera,
		language: "es",
		region: "es",
		travelMode: "DRIVING"
	}, function(response, status) {
		if (status === "OK") {				
			tiempo_almacen_primero = response.routes[0].legs[0].duration.value;
			distancia_almacen_primero = response.routes[0].legs[0].distance.value;
			
			distancia_almacen_primero = (distancia_almacen_primero / 1000).toFixed(1);
			tiempo_almacen_primero = (tiempo_almacen_primero / 60).toFixed(0);
			horas = parseInt(tiempo_almacen_primero / 60);
			minutos = tiempo_almacen_primero - 60*horas;
			
			tabla_distancia_tiempo = document.getElementById("tabla_tiempo_distancia_ruta_"+n_ruta);
			if (horas==0){
				tabla_distancia_tiempo.rows[1].cells[1].innerHTML = minutos+' min';
			}else{
				tabla_distancia_tiempo.rows[1].cells[1].innerHTML = horas+'h '+minutos+' min';
			}
			tabla_distancia_tiempo.rows[1].cells[2].innerHTML = distancia_almacen_primero + ' km';
						
		} else {
			window.alert('Error 1: ' + status +' @ Ruta ' + n_ruta);
			calculoExitoso = false;
		}
	});
	
//--------------- Primera Entrega -> Última Entrega -------------------------------------------------------------------			
		
	dir_primera = jQuery("<p>" + A[1] + "</p>").text();
	dir_ultima = jQuery("<p>" + A[N-1] + "</p>").text();
	var waypts = [];
	for(i=2;i<N-1;i++){
		nuevo_waypoint = jQuery("<p>" + A[i] + "</p>").text();
		waypts.push({
					location: nuevo_waypoint,
					stopover: true
					});
	}	
	
	directionsService.route({
		origin: dir_primera,
		destination: dir_ultima,
		language: "es",
		region: "es",
		waypoints: waypts,
		optimizeWaypoints: false,
		travelMode: "DRIVING"
	}, function(response, status) {
		if (status === "OK") {				
	
			distancia_primero_ultimo = 0;
			tiempo_primero_ultimo = 0;
			Nrutas = N - 1;

			for (i = 0; i < Nrutas-1; i++) {

				dist = response.routes[0].legs[i].distance.text;
				tiempo = response.routes[0].legs[i].duration.text;
				tabla_ruta.rows[i+1].cells[columna_distancia_tabla_ruta].innerHTML = dist;
				tabla_ruta.rows[i+1].cells[columna_tiempo_tabla_ruta].innerHTML = tiempo;
			
				distancia_primero_ultimo += response.routes[0].legs[i].distance.value;
				tiempo_primero_ultimo += response.routes[0].legs[i].duration.value;
			}
			
			tabla_ruta.rows[i+1].cells[columna_distancia_tabla_ruta].innerHTML = '-';
			tabla_ruta.rows[i+1].cells[columna_tiempo_tabla_ruta].innerHTML = '-';
			
			distancia_primero_ultimo = (distancia_primero_ultimo / 1000).toFixed(1);
			tiempo_primero_ultimo = (tiempo_primero_ultimo / 60).toFixed(0);
			horas = parseInt(tiempo_primero_ultimo / 60);
			minutos = tiempo_primero_ultimo - 60*horas;		
			
			tabla_distancia_tiempo = document.getElementById("tabla_tiempo_distancia_ruta_"+n_ruta);
			if (horas==0){
				tabla_distancia_tiempo.rows[2].cells[1].innerHTML = minutos+' min';
			}else{
				tabla_distancia_tiempo.rows[2].cells[1].innerHTML = horas+'h '+minutos+' min';
			}
			tabla_distancia_tiempo.rows[2].cells[2].innerHTML = distancia_primero_ultimo + ' km';

		} else {
			window.alert('Error 2: ' + status +' @ Ruta ' + n_ruta);
			calculoExitoso = false;

			if ((status == "ZERO_RESULTS") || (status == "NOT_FOUND") || (status == "UNKNOWN_ERROR")) {
				for(j=1;j<N;j++){
					revisa_direccion(A[j],idComanda[j]);
				}
			}
		}	
	});
		
		
//---------------  Última Entrega -> Almacén ---------------------------------------------------------------------------
	dir_ultima = jQuery("<p>" + A[N-1] + "</p>").text();
	directionsService.route({
		origin: dir_ultima,
		destination: dir_almacen,
		language: "es",
		region: "es",
		travelMode: "DRIVING"
	}, function(response, status) {
		if (status === "OK") {				
			
			tiempo_ultimo_almacen = response.routes[0].legs[0].duration.value;
			distancia_ultimo_almacen = response.routes[0].legs[0].distance.value;
			
			distancia_ultimo_almacen = (distancia_ultimo_almacen / 1000).toFixed(1);
			tiempo_ultimo_almacen = (tiempo_ultimo_almacen / 60).toFixed(0);
			horas = parseInt(tiempo_ultimo_almacen / 60);
			minutos = tiempo_ultimo_almacen - 60*horas;
			
			tabla_distancia_tiempo = document.getElementById("tabla_tiempo_distancia_ruta_"+n_ruta);
			if (horas==0){
				tabla_distancia_tiempo.rows[3].cells[1].innerHTML = minutos+' min';
			}else{
				tabla_distancia_tiempo.rows[3].cells[1].innerHTML = horas+'h '+minutos+' min';
			}
			tabla_distancia_tiempo.rows[3].cells[2].innerHTML = distancia_ultimo_almacen + ' km';

			
		} else {
			window.alert('Error 3: ' + status +' @ Ruta ' + n_ruta);
			calculoExitoso = false;
		}
		

//---------------------	Escribir distancia/tiempo de 1ra a última entrega en la Tabla de Resumen de Rutas ------------------
		setTimeout(function(){
			tabla_resumen = document.getElementById("Tabla_Resumen_Rutas");
			tabla_resumen.rows[2].cells[n_ruta+1].innerHTML = tabla_distancia_tiempo.rows[2].cells[2].innerHTML;
			tabla_resumen.rows[3].cells[n_ruta+1].innerHTML = tabla_distancia_tiempo.rows[2].cells[1].innerHTML;
		},800);

//--------------------- ajax guardar tiempo y distancia total de ruta en BD -------------------------------------------------
		TotalDistancia = parseFloat(distancia_almacen_primero) + parseFloat(distancia_primero_ultimo) + parseFloat(distancia_ultimo_almacen);
		TotalTiempo = parseFloat(tiempo_almacen_primero) + parseFloat(tiempo_primero_ultimo) + parseFloat(tiempo_ultimo_almacen);
	
		var request = $.ajax({
						url: "ajax_tiempo_distancia_ruta.php",
						type: "POST",
						data: { ruta: n_ruta, 
							    fecha: $("#fecha").val(),
								ncomandes: NComandes,
								nlinies: NLinies,
								distancia: TotalDistancia,
								tiempo: TotalTiempo
							  },
						dataType: "html"
					});	
					request.done(function(msg){
						if (parseInt(msg)==-1)
						{
							alert('ERROR!!!');
						}
						else
						{
						}	
					});

//--------------------- Calcular ORDEN DE CARGA -------------------------------------------------
		orden_de_carga();

//--------------------- Cálculo exitoso -------------------------------------------------		
		if (calculoExitoso){
			setTimeout(function(){	
				$("#boton_calcular_"+n_ruta).removeClass("btn-danger").addClass("btn-success");
				tabla_resumen = document.getElementById("Tabla_Resumen_Rutas");
				tabla_resumen.rows[0].cells[n_ruta+1].innerHTML = "<font color='#5cb85c'>Ruta "+n_ruta+"</font>";
			},500);	

			Llenar_Letras_GoogleMaps(n_ruta);

		}
	});

};
	
/* ******************************************************************************************* */
/*                        CALCULAR ORDEN DE CARGA                                              */
/* ******************************************************************************************* */
	function orden_de_carga(){
		
		var distancia = new Array();
		var posicion = new Array();
		var n = 0;
		
		for(i=1; i<=n_max_rutas_permitidas; i++){
			panel = document.getElementById("panel_ruta_"+i);
			if (panel.style.display == "block"){
				tabla = document.getElementById("tabla_tiempo_distancia_ruta_"+i);
				dist = parseFloat(tabla.rows[1].cells[2].innerText);				
				if (isNaN(dist) == false){
					n++; 
					distancia[n] = dist;
					posicion[n] = i;
				}
				
			}	
		}
		
		for (i=1; i<=n-1; i++){
			for (j=i+1; j<=n; j++){
				if (distancia[i]<distancia[j]){
					aux1 = distancia[i]; distancia[i]=distancia[j]; distancia[j]= aux1;
					aux2 = posicion[i];  posicion[i]=posicion[j];   posicion[j]= aux2;
				}
			}
		}
		
		for (i=1;i<=n;i++){
			
			orden_carga = document.getElementById("orden_carga_"+posicion[i]);
			orden_carga.innerHTML = "<strong>ORDRE DE CÀRREGA: "+i+"</strong>";
			
		}
	
	}
/* ******************************************************************************************* */
/*                       VER MAPA
/* ******************************************************************************************* */
	function ver_mapa(nruta){
	
//--------------   Llenar vector auxiliar	----------------------------------------------------------------
		
		tabla_ruta = document.getElementById("tabla_ruta_"+nruta);
		N = tabla_ruta.rows.length;

		var A = new Array(50);
		var idComanda = new Array(50);
		
		for (i = 0; i < N; i++) {
				valor = jQuery("<p>" + tabla_ruta.rows[i].cells[columna_direccion_tabla_ruta].innerText + "</p>").text();
				A[i] = valor;
				
				valor = jQuery("<p>" + tabla_ruta.rows[i].cells[columna_id_comanda].innerText + "</p>").text();
				idComanda[i] = valor;
		}

// ------------- Inicializar Dialogo    ----------------------------------------------------------	
		
		$('#dialogo_mapa').dialog('option', 'title', 'Mapa de Ruta Núm. '+ nruta);
		$("#dialogo_mapa").dialog("open");	
	
// ----------- inicializar mapa    --------------------------------------------------------------
		var directionsService = new google.maps.DirectionsService;
		var directionsDisplay = new google.maps.DirectionsRenderer;
		
		var map = new google.maps.Map(document.getElementById('dialogo_mapa'), {});
		directionsDisplay.setMap(map);

// ----------  calcular y mostrar ruta   ------------------------------------------------------

		dir_primera = jQuery("<p>" + A[1] + "</p>").text();
		dir_ultima = jQuery("<p>" + A[N-1] + "</p>").text();
	
		var waypts = [];
		for(i=2;i<N-1;i++){//for(i=1;i<N;i++){ *** tomando en cuenta almacén
			nuevo_waypoint = jQuery("<p>" + A[i] + "</p>").text();
			waypts.push({
					location: nuevo_waypoint,
					stopover: true
					});
		}
		directionsService.route({
			origin: dir_primera,
			destination: dir_ultima,
			language: "es",
			region: "es",
			waypoints: waypts,
			optimizeWaypoints: false,
			travelMode: "DRIVING"
		}, function(response, status) {
			
			if (status === google.maps.DirectionsStatus.OK) {
				directionsDisplay.setDirections(response);
			}else{
				window.alert('Google Maps Directions error degut a ' + status);
				if ((status == "ZERO_RESULTS") || (status == "NOT_FOUND") || (status == "UNKNOWN_ERROR")){
					for(j=1;j<N;j++){
						revisa_direccion(A[j],idComanda[j]);
					}
				}
			}
		});
		
		Llenar_Letras_GoogleMaps(nruta);
		
	}	
/* ******************************************************************************************* */
/*                       IMPRIMIR UNA RUTA
/* ******************************************************************************************* */		
	function imprimir_ruta(nruta){
		
		var repartidor = document.getElementById("repartidor_"+nruta).value;
		var furgoneta = document.getElementById("furgoneta_"+nruta).value;
		var orden_de_carga = document.getElementById("orden_carga_"+nruta).innerText;
		var tabla_ruta = document.getElementById("tabla_ruta_"+nruta);
		var tabla_tiempo_distancia_ruta = document.getElementById("tabla_tiempo_distancia_ruta_"+nruta);
	
//-----------------------  Totales L, SEC, REF, FV  -------------------------------------------				
		N = tabla_ruta.rows.length;
		var lineas = 0; var sec = 0; var ref = 0; var fv = 0;
		for (i=1; i<N; i++){
			lineas += parseInt(jQuery("<p>" + tabla_ruta.rows[i].cells[columna_lineas_tabla_ruta].innerText + "</p>").text());
			sec += parseInt(jQuery("<p>" + tabla_ruta.rows[i].cells[columna_sec_tabla_ruta].innerText + "</p>").text());
			ref += parseInt(jQuery("<p>" + tabla_ruta.rows[i].cells[columna_ref_tabla_ruta].innerText + "</p>").text());
			fv += parseInt(jQuery("<p>" + tabla_ruta.rows[i].cells[columna_fv_tabla_ruta].innerText + "</p>").text());
		}

//---------------------------------------------------------------------------------------------		
	
		$html = "";
		
		var $html = '' +
					'<style type="text/css">' +
					'table th, table td {' +
					'padding:5px;' +
					'text-align:left;' +
					'border-bottom: 1px solid #ddd;' +
					'}' +
					'table th {}' +
					'</style>';
					
//		$html += "<p style='page-break-before: always'></p>"; // Salto de página
		
		$html += "<strong>RUTA NÚM. "+nruta+"</strong>"+"</BR>";
		$html += "LLIURADOR: "+repartidor+", ";
		$html += "FURGONETA: "+furgoneta+", ";
		$html += orden_de_carga+"</BR>";
		$html += "Totales: ";
		$html += "L: "+lineas+", ";
		$html += "SEC: "+sec+", ";
		$html += "REF: "+ref+", ";
		$html += "F/V: "+fv+"</BR>";
		
		newWin= window.open("");
		
		newWin.document.write($html);
		
		//	$('td:nth-child(1),th:nth-child(1)').hide();
		$('td:nth-child(2),th:nth-child(2)').hide();
		$('td:nth-child(3),th:nth-child(3)').hide();

		newWin.document.write("<br>");
		newWin.document.write(tabla_ruta.outerHTML);
		newWin.document.write("<br>");
		
		//	$('td:nth-child(1),th:nth-child(1)').show();
		$('td:nth-child(2),th:nth-child(2)').show();
		$('td:nth-child(3),th:nth-child(3)').show();
		
		newWin.document.write(tabla_tiempo_distancia_ruta.outerHTML);
		
//---------------------------------------------------------------------------------------------		
		newWin.print();
		newWin.close();
	}

/* ******************************************************************************************* */
/*                       X-EDITABLE
/* ******************************************************************************************* */
	function x_editable(){  
  
 //---------------------- X-Editable RUTA --------------------------------------------
 
		$.fn.editable.defaults.mode = 'popup';
		$.fn.editable.defaults.placement = 'left';
		
		$('.xedit').editable({
			emptytext: '0',
		    type: 'text',
			success: function(response, newValue) {
						var x = $(this).closest('td').children('span').attr('id');
						var y = $('.input-sm').val();
						var z = $(this).closest('td').children('span');
								
						$.ajax({
							url: "ajax_get_ruta.php?id="+x+"&ruta="+y,
							type: "GET",

							success: function(s){
								if(s == 'status'){
									$(z).html(y);
								}
								if(s == 'error') {
									alert('Error!');}	
								},
							error: function(e){
								alert('Error!!');
							}	
						});
						
					}
		});
		
		$('.xedit').editable('option','validate', function (valor_ruta) {
            if (($.trim(valor_ruta) < 1)||($.trim(valor_ruta) > n_max_rutas_permitidas)||($.trim(valor_ruta) == '')) { 
				return "D'introduir una ruta al rang 1-"+n_max_rutas_permitidas; 
			};
			if ($.isNumeric(valor_ruta) == '') {
				return 'Només es permeten valors numèrics';
			}
        });
		
		$('.xedit').on('save', function(e, editable) {
			setTimeout(function(){
				band_cambio_ruta = true;
				llenar_resumen();
				llenar_tablas_ruta(false);
			},500);	
		});

		$('.xedit').on('save', function(e, params) {
			var x = $(this).closest('td').children('span').attr('id');
			var y = params.newValue;
			updatePosicionRuta(x,y);
			
			var z = $(this).text();
			$( "#boton_calcular_"+y ).removeClass( "btn-success" ).addClass( "btn-danger" );
			$( "#boton_calcular_"+z ).removeClass( "btn-success" ).addClass( "btn-danger" );
			tabla_resumen = document.getElementById("Tabla_Resumen_Rutas");
			tabla_resumen.rows[0].cells[parseInt(y)+1].innerHTML = "<font color='#d9534f'>Ruta "+y+"</font>";
			if(z!=0){
				tabla_resumen.rows[0].cells[parseInt(z)+1].innerHTML = "<font color='#d9534f'>Ruta "+z+"</font>";
			}	
		});
		
 //---------------------- X-Editable SECOS --------------------------------------------
		
		$('.sec_editable').editable({
			emptytext: '0',
		    type: 'text',
			validate: function(value) {
				if ($.isNumeric(value) == '') {
					return 'Només es permeten valors numèrics';
				}
			},
			success: function(response, newValue) {
						var id_comanda = $(this).attr('id');
						var request = $.ajax({
							url: "ajax_cajas.php",
							type: "POST",
							data: { categ: "secas", 
									id_comanda: id_comanda,
									secas: newValue
								  },
							dataType: "html"
						});	
						request.done(function(msg){
							if (parseInt(msg)==-1){
								alert('ERROR!!!');
							}	
						});
						
					}
		});
		
//---------------------- X-Editable REFRIGERADOS --------------------------------------------		
		$('.ref_editable').editable({
			emptytext: '0',
		    type: 'text',
			validate: function(value) {
				if ($.isNumeric(value) == '') {
					return 'Només es permeten valors numèrics';
				}
			},
			success: function(response, newValue) {
						var id_comanda = $(this).attr('id');
						var request = $.ajax({
							url: "ajax_cajas.php",
							type: "POST",
							data: { categ: "refrigeradas", 
									id_comanda: id_comanda,
									refrigeradas: newValue
								  },
							dataType: "html"
						});	
						request.done(function(msg){
							if (parseInt(msg)==-1){
								alert('ERROR!!!');
							}	
						});
					}
			
			
		});
		
		
//---------------------- X-Editable FRUTAS/VERDURAS --------------------------------------------		
		$('.fv_editable').editable({
			emptytext: '0',
		    type: 'text',
			validate: function(value) {
				if ($.isNumeric(value) == '') {
					return 'Només es permeten valors numèrics';
				}
			},
			success: function(response, newValue) {
						var id_comanda = $(this).attr('id');
						var request = $.ajax({
							url: "ajax_cajas.php",
							type: "POST",
							data: { categ: "frutas_verduras", 
									id_comanda: id_comanda,
									frutas_verduras: newValue
								  },
							dataType: "html"
						});	
						request.done(function(msg){
							if (parseInt(msg)==-1){
								alert('ERROR!!!');
							}	
						});
						
					}
			
			
		});
		
//---------------------- X-Editable DIRECCIÓN --------------------------------------------		
		$('.direccion_editable').editable({
			placement:'right',
			emptytext: '0',
		    type: 'textarea',
			success: function(response, newValue) {
				
						var id_ruta = $(this).attr('id_ruta');
						$( "#boton_calcular_"+id_ruta ).removeClass( "btn-success" ).addClass( "btn-danger" );
						tabla_resumen = document.getElementById("Tabla_Resumen_Rutas");
						tabla_resumen.rows[0].cells[parseInt(id_ruta)+1].innerHTML = "<font color='#d9534f'>Ruta "+id_ruta+"</font>";	
	
						if(confirm("¿Enviar petició d'actualització de direcció a l'Administrador?")) {
							
							var id_comanda = $(this).attr('id');
							
							var request = $.ajax({
								url: "ajax_mail.php",
								type: "POST",
								data: { accio: "cambio_direccion",
										id_comanda: id_comanda,
										direccion: newValue,
										direccion_ant: $(this).text()
									  },
								dataType: "html"
							});	
							request.done(function(msg){
								if (parseInt(msg)==-1){
									alert('ERROR!!!');
								}else{
									alert(msg);
								}

							});
							
						}			
			}
	});

//---------------------- X-Editable COMENTARIOS --------------------------------------------				
		$('.comentarios_editable').editable({
			placement:'right',
			emptytext: ' ',
		    type: 'textarea'
		});

//---------------------- X-Editable TPV --------------------------------------------				
		$('.tpv_editable').editable({
			placement:'left',
			emptytext: ' ',
		    type: 'text',
			success: function(response, newValue) {
					var tpv = newValue;
					var nruta = $(this).attr("ruta");
					var fecha = $("#fecha").val();

					var request = $.ajax({
							url: "ajax_tpv_ronyoneras.php",
							type: "POST",
							data: { accio: "guardar_tpv", 
									ruta: nruta,
									tpv: tpv,
									fecha: fecha
								  },
							dataType: "html"
						});	
						request.done(function(msg){
							if (parseInt(msg)==-1){
								alert('ERROR!!!');
							}	
						});
					}
		});
//---------------------- X-Editable RIÑONERA --------------------------------------------				
		$('.ronyonera_editable').editable({
			placement:'left',
			emptytext: ' ',
		    type: 'text',
			success: function(response, newValue) {
					var ronyonera = newValue;
					var nruta = $(this).attr("ruta");
					var fecha = $("#fecha").val();

					var request = $.ajax({
							url: "ajax_tpv_ronyoneras.php",
							type: "POST",
							data: { accio: "guardar_ronyonera", 
									ruta: nruta,
									ronyonera: ronyonera,
									fecha: fecha
								  },
							dataType: "html"
						});	
						request.done(function(msg){
							if (parseInt(msg)==-1){
								alert('ERROR!!!');
							}	
						});
					}
		});
	
//---------------------------- ORDENABLE ---------------------------------------
		tabla_ruta_ordenable();
//------------------------------------------------------------------------------		
		
	};

	
/* ******************************************************************************************* */
/*                       TABLA RUTA ORDENABLE
/* ******************************************************************************************* */
	function tabla_ruta_ordenable(){
		
		$( ".ordenable" ).sortable({		
			placeholder:'table-bordered active',
			update: function( event, ui ) {
				var ruta = $(this).attr('ruta');
				var tabla_ordenable = document.getElementById("body_ruta_"+ruta);
				var N = tabla_ordenable.rows.length;
				//alert('cambio en ruta '+ruta+' ('+N+')');
				var A = new Array(50);
				for (i = 0; i < N; i++) {
					valor = jQuery("<p>" + tabla_ordenable.rows[i].cells[columna_id_comanda].innerText + "</p>").text();
					A[i] = valor;
				}
				for (i = 0; i < N; i++){
					//// AJAX
					var request = $.ajax({
									url: "ajax_posicion.php",
									type: "POST",
									data: { accio: "cambio_ruta", 
											pos: i,
											id: A[i]
										  },
									dataType: "html"
								});	
								request.done(function(msg)
								{
									if (parseInt(msg)==-1)
									{
										alert('ERROR!!!');
									}
									else
									{
									}	
								});
				}
			//--------------------- Botón y tabla resumen a no calculado -------------------------------------------------		
				$( "#boton_calcular_"+ruta ).removeClass( "btn-success" ).addClass( "btn-danger" );			
				tabla_resumen = document.getElementById("Tabla_Resumen_Rutas");
				tabla_resumen.rows[0].cells[parseInt(ruta)+1].innerHTML = "<font color='#d9534f'>Ruta "+ruta+"</font>";
			}
		});		
	}

	
/* ******************************************************************************************* */
/*                       DATA TABLES
/* ******************************************************************************************* */
	function dataTables(){
	  
	  var tabla_principal = $('#principal').DataTable(
      {
        responsive: true,
		paging: true,
		searching: true,
		//"sDom": '<"top"l>rt<"bottom"ip><"clear">',	
		"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
		"iDisplayLength": 25,
 	    "aaSorting": [],
		//scrollY:        "350px",
		//scrollX:        true,
        //scrollCollapse: true,
        //paging:         false,
        //fixedColumns:   true,
		
		"columnDefs": [{ "orderable": false, "targets": 0},
					   { "orderable": false, "targets": 1},
					   { "orderable": false, "targets": 2},
					   { "orderable": false, "targets": 3},
					   { "orderable": false, "targets": 4},
					   { "orderable": false, "targets": 5},
					   { "orderable": false, "targets": 6},
					   { "orderable": false, "targets": 7},
				//	   { "visible": false, "targets": 12},
					  ],
		
			
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
	  
	// Añadir input para filtro en cada footer
    $('#principal tfoot th').each( function (i) {
        var title = $('#principal thead th').eq( $(this).index() ).text();
		if((title=='ID')||(title=='P/P/A')||(title=='Zona')||(title=='CP')||(title=='RUTA')){
			$(this).html( '<input type="text" size="1" placeholder="'+title+'" data-index="'+i+'" />' );
		}else if((title=='Franja')||(title=='Nom')){
			$(this).html( '<input type="text" size="2" placeholder="'+title+'" data-index="'+i+'" />' );
		}else if((title=='Comentaris adreça')||(title=='Comentaris comanda')){
			$(this).html( '<input type="text" size="15" placeholder="'+title+'" data-index="'+i+'" />' );
		}else{
			$(this).html( '<input type="text" size="4" placeholder="'+title+'" data-index="'+i+'" />' );
		}	
		
    } );
  
    
    // Evento para manejar Filtro de Columnas
    $( tabla_principal.table().container() ).on( 'keyup', 'tfoot input', function () {
		tabla_principal
            .column( $(this).data('index') )
            .search( this.value )
            .draw();
    } );
		
	};

/* ******************************************************************************************* */
/*                       Inicializar Diálogo Repartidores
/* ******************************************************************************************* */
function inicializar_dialogo_repartidores(){
	$("#dialogo_repartidores").dialog({
			modal: true,
			autoOpen: false,
			width: 800,
			open: function() {
				
				$('.ui-dialog :button').blur();
				
				$(this).keyup(function(e)
				{					
					if (e.keyCode == 13)
					{
						$('.ui-dialog').find('button:first').trigger('click');
					}
				});
			},
			buttons:
			{
				"Netejar": function()
				{
					limpiar_repartidor();
				},
				
				"Cancelar": function()
				{
					$( this ).dialog( "close" );
				}
			}
	});
}

/* ******************************************************************************************* */
/*                       Inicializar Diálogo Furgonetas
/* ******************************************************************************************* */
function inicializar_dialogo_furgonetas(){
	$("#dialogo_furgonetas").dialog({
			modal: true,
			autoOpen: false,
			width: 800,
			open: function() {
				
				$('.ui-dialog :button').blur();
				
				$(this).keyup(function(e)
				{					
					if (e.keyCode == 13)
					{
						$('.ui-dialog').find('button:first').trigger('click');
					}
				});
			},
			buttons:
			{
				"Netejar": function()
				{
					limpiar_furgoneta();
				},
				
				"Cancelar": function()
				{
					$( this ).dialog( "close" );
				}
			}
	});	
}


/* ******************************************************************************************* */
/*                       Inicializar Diálogo Mapas
/* ******************************************************************************************* */
function inicializar_dialogo_mapas(){
	$("#dialogo_mapa").dialog({
		modal: true,
		autoOpen: false,
		width: $(window).width(),
		height: $(window).height(),
		left: "0px",
		top: "0px",
		open: function() {
			$('.ui-dialog :button').blur();
			$(this).keyup(function(e)
			{
				if (e.keyCode == 13)
				{
					$('.ui-dialog').find('button:first').trigger('click');
				}
			});			
		},
		buttons:
		{
			"Imprimir": function(){
				printMapa();
				$( this ).dialog( "close" );
			},
			
			"Tancar": function(){
				$( this ).dialog( "close" );
			}
		}
	});	
	
}

/* ******************************************************************************************* */
/*                       Function printMapa
/* ******************************************************************************************* */

	function printMapa() {
	
//		$ruta = $( ".dialogo_mapa" ).dialog( "option", "title" );
	
		var body               = $('body');
		var mapContainer       = $('.dialogo_mapa');
		var mapContainerParent = mapContainer.parent();
		var printContainer     = $('<div>');

		printContainer
			.addClass('print-container')
			.css('position', 'relative')
			.height(mapContainer.height())
			.append(mapContainer)
			.prependTo(body);

		var content = body
			.children()
			.not('script')
			.not(printContainer)
			.detach();
			
		// Patch for some Bootstrap 3.3.x `@media print` styles. :|
		var patchedStyle = $('<style>')
			.attr('media', 'print')
			.text('img { max-width: none !important; }' +
				  'a[href]:after { content: ""; }')
			.appendTo('head');
			
		window.print();

		body.prepend(content);
		mapContainerParent.prepend(mapContainer);

		printContainer.remove();
		patchedStyle.remove();
    }
	
/* ******************************************************************************************* */
/*                       Function refrescar flechas y X editable
/* ******************************************************************************************* */
function recarga_flechas_xeditable(){
	if (band_cambio_ruta){
		llenar_tablas_ruta(false);
		presionar_flechas();
		x_editable();
		band_cambio_ruta = false;
	}
}


/* ******************************************************************************************* */
/*                       Function revisar direcciones
/* ******************************************************************************************* */
	function revisa_direccion(direccion, id_comanda){
		setTimeout(function(){
			dir_almacen = "Carretera Constanti, Km 3, 43204, Reus, Tarragona";
			var directionsService = new google.maps.DirectionsService;
			directionsService.route({
				origin: dir_almacen,
				destination: direccion,
				language: "es",
				region: "es",
				waypoints: [],
				optimizeWaypoints: false,
				travelMode: "DRIVING"
			}, function(response, status) {
				if ((status == "ZERO_RESULTS") || (status == "NOT_FOUND") || (status == "UNKNOWN_ERROR")) {
					//cod = jQuery("<p>" + A[i][2] + "</p>").text();
					//nombre = jQuery("<p>" + A[i][5] + "</p>").text();
					alert('Google Maps va poder no haver reconegut la direcció: '+direccion+' @ ID Comanda: '+id_comanda);
				}
			}); 
		}
		, 500+i*500);
	}
	
/* ******************************************************************************************* */
/*                       IMPRIMIR RECIBOS DE UNA RUTA
/* ******************************************************************************************* */		
	function imprimir_rebuts_ruta(nruta){
		
		var fecha = document.getElementById("fecha").value;
		var repartidor = document.getElementById("repartidor_"+nruta).value;
		var furgoneta = document.getElementById("furgoneta_"+nruta).value;
		var tabla_ruta = document.getElementById("tabla_ruta_"+nruta);
		var tpv = document.getElementById("tpv_"+nruta).innerText;
		var ronyonera = document.getElementById("ronyonera_"+nruta).innerText;
	
//-----------------------  Totales L, SEC, REF, FV  -------------------------------------------				
		N = tabla_ruta.rows.length;
		var idComanda = new Array(); 
		var importPagat = new Array();
		var totalPagat = new Array();
		var metPagament = new Array();
		var comentaris = new Array();
		for (i=0;i<30;i++){
			idComanda[i] = '';
			importPagat[i] = '';
			totalPagat[i] = '';
			metPagament[i] = '';
			comentaris[i] = '';
		}
		
	
		for (i=1; i<N; i++){
			idComanda[i] = parseInt(jQuery("<p>" + tabla_ruta.rows[i].cells[columna_id_comanda].innerText + "</p>").text());
			importPagat[i] = jQuery("<p>" + tabla_ruta.rows[i].cells[columna_importPagat].innerText + "</p>").text();
			totalPagat[i] = jQuery("<p>" + tabla_ruta.rows[i].cells[columna_totalPagat].innerText + "</p>").text();
			metPagament[i] = jQuery("<p>" + tabla_ruta.rows[i].cells[columna_metPagament].innerText + "</p>").text();
			comentaris[i] = jQuery("<p>" + tabla_ruta.rows[i].cells[columna_comentaris].innerText + "</p>").text();
		}
			
//---------------------------------------------------------------------------------------------		
	
		$html = "";
		
		var $html = '<style type="text/css">' +
						'table {' +
							'border-collapse: collapse;' +
							'font-size:x-small;' +
						'}' +
						'table, th, td {' +
							'padding:5px;' +
						'}' +
					'</style>';
					
		$html += "<table border=0 style='width: 100%;'>";
		$html += 	"<tr>";
		$html += 		"<td style='width: 25%;'><strong>"+fecha+"</strong></td>";
		$html += 		"<td style='width: 25%;'>Hora d'entrada:</td>";
		$html += 		"<td style='width: 25%;'>Hora de sortida:</td>";
		$html += 		"<td style='width: 25%;'></td>";
		$html += 	"</tr>";
		$html += "</table>";
		
		$html += "<table border=1 style='width: 100%;'>";
		$html += 	"<tr>";
		$html += 		"<td style='width: 25%; text-align:center;'><strong>LLIURADOR</strong></td>";
		$html += 		"<td style='width: 25%; text-align:center;'><strong>FURGONETA</strong></td>";
		$html += 		"<td style='width: 25%; text-align:center;'><strong>RONYONERA</strong></td>";
		$html += 		"<td style='width: 25%; text-align:center;'><strong>TPV</strong></td>";
		$html += 	"</tr>";
		$html += 	"<tr style='height: 45px;'>";
		$html += 		"<td style='width: 25%; text-align:center;'>"+repartidor+"</td>";
		$html += 		"<td style='width: 25%; text-align:center;'>"+furgoneta+"</td>";
		$html += 		"<td style='width: 25%; text-align:center;'>"+tpv+"</td>";
		$html += 		"<td style='width: 25%; text-align:center;'>"+ronyonera+"</td>";
		$html += 	"</tr>";
		$html += "</table>";
		
		$html += "<br>";
		
		for (i=1; i<12; i=i+2){
			$html += "<table border=0 style='width: 100%; padding: 0px'>";
			$html += "<tr>";
	//--------------------------------------------------------------------------------------------------		
			$html += "<td style='width: 50%;'>";
			$html += "<table border=1 style='width: 100%;'>";
			$html += 	"<tr>";
			$html += 		"<td style='width: 20%; text-align:right;'>NÚM.COMANDA</td>";
			$html += 		"<td style='width: 20%;'><strong>"+idComanda[i]+"</strong></td>";
			$html += 		"<td style='width: 60%; text-align:center;'>DATA I SIGNATURA</td>";
			$html += 	"</tr>";
			$html += 	"<tr>";
			$html += 		"<td style='text-align:right;'>IMPORT PAGAT</td>";
			$html += 		"<td>"+importPagat[i]+"</td>";
			$html += 		"<td rowspan='4'></td>";
			$html += 	"</tr>";
			$html += 	"<tr>";
			$html += 		"<td style='text-align:right;'><strong>TOTAL</strong></td>";
			$html += 		"<td><strong>"+totalPagat[i]+"</strong></td>";
			$html += 	"</tr>";
			$html += 	"<tr>";
			$html += 		"<td style='text-align:right;'><strong>REAL PAGAT</strong></td>";
			$html += 		"<td></td>";
			$html += 	"</tr>";
			$html += 	"<tr>";
			$html += 		"<td style='text-align:right;'>MET.PAGAMENT</td>";
			$html += 		"<td>"+metPagament[i]+"</td>";
			$html += 	"</tr>";
			$html += 	"<tr>";
			$html += 		"<td style='text-align:right;'>COMENTARIS</td>";
			$html += 		"<td colspan='2'>"+comentaris[i]+"</td>";
			$html += 	"</tr>";
			$html += "</table>";
			$html += "</td>";
		//--------------------------------------------------------------------------------------------------			
			$html += "<td style='width: 50%;'>";
			$html += "<table border=1 style='width: 100%;'>";
			$html += 	"<tr>";
			$html += 		"<td style='width: 20%; text-align:right;'>NÚM.COMANDA</td>";
			$html += 		"<td style='width: 20%;'><strong>"+idComanda[i+1]+"</strong></td>";
			$html += 		"<td style='width: 60%; text-align:center;'>DATA I SIGNATURA</td>";
			$html += 	"</tr>";
			$html += 	"<tr>";
			$html += 		"<td style='text-align:right;'>IMPORT PAGAT</td>";
			$html += 		"<td>"+importPagat[i+1]+"</td>";
			$html += 		"<td rowspan='4'></td>";
			$html += 	"</tr>";
			$html += 	"<tr>";
			$html += 		"<td style='text-align:right;'><strong>TOTAL</strong></td>";
			$html += 		"<td><strong>"+totalPagat[i+1]+"</strong></td>";
			$html += 	"</tr>";
			$html += 	"<tr>";
			$html += 		"<td style='text-align:right;'><strong>REAL PAGAT</strong></td>";
			$html += 		"<td></td>";
			$html += 	"</tr>";
			$html += 	"<tr>";
			$html += 		"<td style='text-align:right;'>MET.PAGAMENT</td>";
			$html += 		"<td>"+metPagament[i+1]+"</td>";
			$html += 	"</tr>";
			$html += 	"<tr>";
			$html += 		"<td style='text-align:right;'>COMENTARIS</td>";
			$html += 		"<td colspan='2'>"+comentaris[i+1]+"</td>";
			$html += 	"</tr>";
			$html += "</table>";
			$html += "</td>";
		//--------------------------------------------------------------------------------------------------			
			$html += "</tr>";
			$html += "</table>";
			
		}
		$html += "<p style='page-break-before: always'></p>"; // Salto de página
		
// PARTE DE ATRÁS		
		
		for (i=1; i<=3; i++){
			$html += "<table border=0 style='width: 100%; padding: 0px'>";
			$html += "<tr>";
	//--------------------------------------------------------------------------------------------------		
			$html += "<td>";
			
			$html += "<table border=1 style='width: 100%;'>";
			$html += 	"<tr>";
			$html += 		"<td style='width: 20%; text-align:right;'>NÚM.COMANDA</td>";
			$html += 		"<td style='width: 80%;'></td>";
			$html += 	"</tr>";
			$html += 	"<tr>";
			$html += 		"<td style='text-align:right;'>CLIENT</td>";
			$html += 		"<td></td>";
			$html += 	"</tr>";
			$html += 	"<tr>";
			$html += 		"<td colspan='2' style='text-align:center;'><strong>OBSERVACIONS</strong></td>";
			$html += 	"</tr>";
			$html += 	"<tr>";
			$html += 		"<td colspan='2' style='height: 250px;'></td>";
			$html += 	"</tr>";
			$html += "</table>";
			
			$html += "</td>";
		//--------------------------------------------------------------------------------------------------			
			$html += "<td>";
			
			$html += "<table border=1 style='width: 100%;'>";
			$html += 	"<tr>";
			$html += 		"<td style='width: 20%; text-align:right;'>NÚM.COMANDA</td>";
			$html += 		"<td style='width: 80%;'></td>";
			$html += 	"</tr>";
			$html += 	"<tr>";
			$html += 		"<td style='text-align:right;'>CLIENT</td>";
			$html += 		"<td></td>";
			$html += 	"</tr>";
			$html += 	"<tr>";
			$html += 		"<td colspan='2' style='text-align:center;'><strong>OBSERVACIONS</strong></td>";
			$html += 	"</tr>";
			$html += 	"<tr>";
			$html += 		"<td colspan='2' style='height: 250px;'></td>";
			$html += 	"</tr>";
			$html += "</table>";
			
			$html += "</td>";
		//--------------------------------------------------------------------------------------------------			
			$html += "</tr>";
			$html += "</table>";
			
		}		
		
// FIN PARTE DE ATRÁS		

		newWin= window.open("");
		newWin.document.write($html);
//---------------------------------------------------------------------------------------------		
		newWin.print();
		newWin.close();

	}
