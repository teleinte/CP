$(document).ready(function(){
	obtenerInmuebles();

	$(document).renderme('re');
	$('#fechainicio').attr('title', obtenerTerminoLenguage('val','11'));
	$('#fechafin').attr('title', obtenerTerminoLenguage('val','11'))

	if(sessionStorage.getItem('reservaInmueble_id') != null || sessionStorage.getItem('reservaInmueble_id') != undefined )
	$("#ddrecursos").val(sessionStorage.getItem('reservaInmueble_id'));
	
	$("#ddrecursos").change(function(){
		sessionStorage.setItem('reservaInmueble_text',$("#ddrecursos option:selected").text());
	});

	$("#btnreportereservas").click(function(){
	    popularReporte($("#ddrecursos").val(),  $("#fechainicio").val(), $("#fechafin").val());
	    sessionStorage.setItem('reservaInmueble_text',$("#ddrecursos option:selected").text());
	});

	$("#fechainicio").val(new Date().toISOString().split("T")[0]);
	var date = new Date();
	date.setDate(date.getDate() + 7);
	$("#fechafin").val(date.toISOString().split("T")[0]);
	$("#fechainicio").removeAttr('min');
	$("#fechafin").removeAttr('min');

	$('#listareporte').DataTable({
	  responsive: {
	    details: {
	              type: 'column'
	          }
	  },
	  columnDefs: [ {
	          className: 'control',
	          orderable: false,
	          targets:   0
	      } ],
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
	
	$("#btnreportereservas").click();

	sessionStorage.setItem('reservaInmueble_text',$("#ddrecursos option:selected").text());
	$("#inmueblenombre").html(sessionStorage.getItem('reservaInmueble_text'));
	$("#nombreinmueble").html(sessionStorage.getItem('reservaInmueble_text'));
	//console.warn(sessionStorage.getItem('reservaInmueble_text'));
	
	$(document).renderme('re');
	$(".ttip").addClass("tooltip-boton");

    $( ".tooltip-boton[title!='']" ).qtip({
      position: {
        my: 'top center',
            at: 'bottom center',
            viewport: $(window), //para correr el tooltip si no cabe en la pantalla
        adjust: {
          method: 'flip invert' //método de ajuste si no cabe en la pantalla
        }
          },
      style: {
            tip: {
                corner: false
            }
        }
    });
});