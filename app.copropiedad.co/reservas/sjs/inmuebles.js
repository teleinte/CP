$(document).ready(function(){
	$(document).renderme('re');
	var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})      
	var arr = { token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp')}};
	var datos = traerDatosSync("reservas/reservas/inmuebles/lista/", arr, sessionStorage.getItem('cp'));
	checkRemoteUserFlow(traerDireccion());

	$('#inmuebles').DataTable({
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
	    exclude: [ 0, 1 ],
	    exclude: [ 0, 6 ]
	  },
    "drawCallback": function( settings ) {
            $(".btneditainmueble").click(function(){
            	var elem = 
            	{
            		mongoid:$(this).attr('mongoid'),
            		name:$(this).attr('name'),
            		tiempo:$(this).attr('tiempo'),
            		inicio:$(this).attr('inicio'),
            		fin:$(this).attr('fin'),
            		dias:$(this).attr('dias')
            	}
            	sessionStorage.setItem('curelem',JSON.stringify(elem));
            	window.location = "editar-inmueble-reservable.php";
            });

            $(".btnborrainmueble").click(function(){
            	$("#dialog_eliminar").dialog("open");
            	$("#elmongoid").val($(this).attr('mongoid'));
            });
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

	popularTabla(datos);

	$("div.toolbar").html('<a href="crear-inmueble-reservable.php" class="btn ttip positivo" id ="open-crearsolicitud" style="margin-right:5px;" teid="re:html:7, re:title:117"></a>');

	$("#dialog_eliminar").dialog({
	  resizable: false,
	  autoOpen: false,
	  width: 400,
	  modal: true,
	  title: "Advertencia",
	  buttons:{
	    "Cancelar" : function(){
	      $(this).dialog("close");
	    },
	    "Aceptar" : function(){
	      $(this).dialog("close");
	      	var arr = {token:sessionStorage.getItem('token'),body:{id:$("#elmongoid").val()}}
			var url = "reservas/reserva/inmueble/";
			var response = envioFormularioSync(url,arr,'DELETE');
			if(response)
			{
			  setTimeout(refreshWindow('inmuebles-reservables.php'),1000);
			}
			else
			{
			  $("#alertas").html('<div class="alert alert-dismissable alert-error" teid="ale:html:21"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:1"></strong></div>');
			  $(document).renderme('en');
			}
	    }
	  }
	});

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