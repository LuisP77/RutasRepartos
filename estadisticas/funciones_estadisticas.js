/* ******************************************************************************************* */
	function updateFecha(fecha){
		window.location.href='estadisticas.php?fecha='+fecha;
	}  


/* ******************************************************************************************* */
/*                       DATA TABLES
/* ******************************************************************************************* */
	function dataTables(){
 	  
	  var tabla_principal_repartidores = $('#principal_repartidores').DataTable(
      {
        responsive: true,
		paging: true,
		searching: true,
		"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
		"iDisplayLength": -1,
 	    "aaSorting": [],		
		"columnDefs": [{ "orderable": false, "targets": 0}
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
	  
	// Añadir input para filtro en cada footer REPARTIDORES
    $('#principal_repartidores tfoot th').each( function (i) {
        var title = $('#principal_repartidores thead th').eq( $(this).index() ).text();
		if(title=='ID'){
			$(this).html( '<input type="text" size="1" placeholder="'+title+'" data-index="'+i+'" />' );
		}else if(title=='Nom'){
			$(this).html( '<input type="text" size="15" placeholder="'+title+'" data-index="'+i+'" />' );
		}else if(title=='Comandes'){
			$(this).html( '<input type="text" size="7" placeholder="'+title+'" data-index="'+i+'" />' );
		}else if(title=='Línies'){
			$(this).html( '<input type="text" size="7" placeholder="'+title+'" data-index="'+i+'" />' );
		}else if(title=='Dist (km)'){
			$(this).html( '<input type="text" size="7" placeholder="'+title+'" data-index="'+i+'" />' );
		}else if(title=='Temps (h)'){
			$(this).html( '<input type="text" size="7" placeholder="'+title+'" data-index="'+i+'" />' );
		}	
		
    } );

	// Evento para manejar Filtro de Columnas REPARTIDORES
    $( tabla_principal_repartidores.table().container() ).on( 'keyup', 'tfoot input', function () {
		tabla_principal_repartidores
            .column( $(this).data('index') )
            .search( this.value )
            .draw();
    } );
//------------------------------------------------------------------------------------------------------------------------	  
//------------------------------------------------------------------------------------------------------------------------	  
	  var tabla_principal_furgonetas = $('#principal_furgonetas').DataTable(
      {
        responsive: true,
		paging: true,
		searching: true,
		"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
		"iDisplayLength": -1,
 	    "aaSorting": [],		
		"columnDefs": [{ "orderable": false, "targets": 0}
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

    // Añadir input para filtro en cada footer FURGONETAS
    $('#principal_furgonetas tfoot th').each( function (i) {
        var title = $('#principal_furgonetas thead th').eq( $(this).index() ).text();
		if(title=='ID'){
			$(this).html( '<input type="text" size="1" placeholder="'+title+'" data-index="'+i+'" />' );
		}else if(title=='Nom'){
			$(this).html( '<input type="text" size="15" placeholder="'+title+'" data-index="'+i+'" />' );
		}else if(title=='Matrícula'){
			$(this).html( '<input type="text" size="7" placeholder="'+title+'" data-index="'+i+'" />' );
		}else if(title=='Dist (km)'){
			$(this).html( '<input type="text" size="7" placeholder="'+title+'" data-index="'+i+'" />' );
		}	
		
    } );

    // Evento para manejar Filtro de Columnas FURGONETAS
    $( tabla_principal_furgonetas.table().container() ).on( 'keyup', 'tfoot input', function () {
		tabla_principal_furgonetas
            .column( $(this).data('index') )
            .search( this.value )
            .draw();
    } );	
	
	
	};

/* ******************************************************************************************* */
/*                       GRAFICA REPARTIDORES
/* ******************************************************************************************* */
function GraficaRepartidores(){
	
		var nombre = new Array;
		var comandes = new Array;
		var linies = new Array;
		var dist = new Array;
		var temps = new Array;
		
		tabla_repartidores = document.getElementById("principal_repartidores");
		var N = tabla_repartidores.rows.length;
		for(i=1;i<N-1;i++){
			valor_nombre = jQuery("<p>" + tabla_repartidores.rows[i].cells[1].innerText + "</p>").text();
			valor_linies = jQuery("<p>" + tabla_repartidores.rows[i].cells[3].innerText + "</p>").text();
			valor_dist = jQuery("<p>" + tabla_repartidores.rows[i].cells[4].innerText + "</p>").text();
			valor_dist = valor_dist.replace(",","");
			
			nombre[i] = valor_nombre;
			linies[i] = parseFloat(valor_linies);
			dist[i] = parseFloat(valor_dist);
			
		}

      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Lliuradors');
        data.addColumn('number', 'Línies');
		data.addColumn('number', 'Distància (km)');
        
		data.addRows(N);
		for(i=1;i<N-1;i++){
			data.setCell(i, 0, nombre[i]);
			data.setCell(i, 1, linies[i]);
			data.setCell(i, 2, dist[i]);
		}
		
        var options = {//'title':'LLIURADORS',
					   //'legend': 'none',
                       'width':1200,
                       'height':400};

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_repartidores'));
        chart.draw(data, options);
      }
}

/* ******************************************************************************************* */
/*                       GRAFICA FURGONETAS
/* ******************************************************************************************* */
function GraficaFurgonetas(){
	
		var nombre = new Array;
		var comandes = new Array;
		var linies = new Array;
		var dist = new Array;
		var temps = new Array;
		
		tabla_furgonetas = document.getElementById("principal_furgonetas");
		var N = tabla_furgonetas.rows.length;
		for(i=1;i<N-1;i++){
			valor_nombre = jQuery("<p>" + tabla_furgonetas.rows[i].cells[1].innerText + "</p>").text();
			valor_dist = jQuery("<p>" + tabla_furgonetas.rows[i].cells[3].innerText + "</p>").text();
			valor_dist = valor_dist.replace(",","");
			
			nombre[i] = valor_nombre;
			dist[i] = parseFloat(valor_dist);
		}

      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Furgonetes');
		data.addColumn('number', 'Distància (km)');
        
		data.addRows(N);
		for(i=1;i<N-1;i++){
			data.setCell(i, 0, nombre[i]);
			data.setCell(i, 1, dist[i]);
		}
		
        var options = {//'title':'FURGONETES',
					   //'legend': 'none',
                       'width':1200,
                       'height':400};

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_furgonetas'));
        chart.draw(data, options);
      }
}