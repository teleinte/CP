$(document).ready(function(){
	$(document).renderme('co');
	//$("#selcopropiedades").prop('disabled', true);
	$('.selector-copropiedad').html("<span class=titulo-cop><strong>"+ sessionStorage.getItem('ncp') +"</strong></span>");
	// Proceso para traer los datos de los inmuebles creados
	/*var arr = {token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp')}};
	var datos = traerDatosSync("unidad/unidad/copropiedad/", arr);
	popularSelect(datos);*/

	var arr2 = { token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp')}};
	var datos2 = traerDatosSync("contabilidad/obtener/cargos", arr2);
	popularCargos(datos2);
	
	$('#cargos').DataTable({
	  columnDefs: [{
	          className: 'control',
	          orderable: false,
	          targets:   0
	      }],
	  responsive: {
	    details: {
	              type: 'column'
	    }
	  },
	  order: [ 1, 'asc' ],
	  "dom": '<"toolbar">lfCrtip',
	  "colVis": {
	    "buttonText": obtenerTerminoLenguage('ta','20'),
	    exclude: [ 0, 1 ]
	  },
	  "language": {
	    "sProcessing":     obtenerTerminoLenguage('ta','2'),
	    "sLengthMenu":     obtenerTerminoLenguage('ta','3'),
	    "sZeroRecords":    obtenerTerminoLenguage('ta','4'),
	    "sEmptyTable":     obtenerTerminoLenguage('ta','5'),
	    "sInfo":           obtenerTerminoLenguage('ta','6'),
	    "sInfoEmpty":      obtenerTerminoLenguage('ta','7'),
	    "sInfoFiltered":   obtenerTerminoLenguage('ta','8'),
	    "sInfoPostFix":    obtenerTerminoLenguage('ta','9'),
	    "sSearch":         obtenerTerminoLenguage('ta','10'),
	    "sUrl":            obtenerTerminoLenguage('ta','11'),
	    "sInfoThousands":  obtenerTerminoLenguage('ta','12'),
	    "sLoadingRecords": obtenerTerminoLenguage('ta','13'),
	    "oPaginate": {
	      "sFirst":    obtenerTerminoLenguage('ta','14'),
	      "sLast":     obtenerTerminoLenguage('ta','15'),
	      "sNext":     obtenerTerminoLenguage('ta','16'),
	      "sPrevious": obtenerTerminoLenguage('ta','17')
	    },
	    "oAria": {
	      "sSortAscending":  obtenerTerminoLenguage('ta','18'),
	      "sSortDescending": obtenerTerminoLenguage('ta','19')
	    }
	      }
	});

	var arr3 = { token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp')}};
	var datos3 = traerDatosSync("cartera/obtener/inmuebles", arr2);
	popularFacturables(datos3);

	$('#alertas').html('<div class="alert alert-dismissable alert-info" > <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong teid="ale:html:28"></strong> <br/><span teid="ale:html:31"></span><br/><span teid="ale:html:32"></span></div>'); 

	$("#cancelar").click(function(){
		location.href="generar.php";
	});

	$("#generar").click(function(){
		var arr = JSON.parse(sessionStorage.getItem('ccrecurrentes'));
		var url = "cartera/generar/cc";
		var response = envioFormularioMessageBodySync(url,arr,'POST'); 
		sessionStorage.setItem('recibos',JSON.stringify(response));
		location.href = "imprimir.php";
	});
	$(document).renderme('co');
});