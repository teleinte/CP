$(document).ready(function(){
	obtenerInmuebles();
	$(document).renderme('re');
	$('#startfecha').attr('title', obtenerTerminoLenguage('val','11'));
	$('#endfecha').attr('title', obtenerTerminoLenguage('val','11'))

	var horainicio = "";
	var horafin = "";
	var diasreserva  = new Array();
	var reservaspan = "";
	var grupo = "";
	var inmueble = "";

	var d = new Date();
	var d2 = new Date();
	var d3 = new Date(d2.setFullYear(d2.getFullYear() + 1));
	var inicio = d.toISOString();
	var fin = d3.toISOString();

	sessionStorage.setItem("reservaFechaRequerida",d);
	sessionStorage.setItem("reservaFechaRequeridaInicio",inicio);
	sessionStorage.setItem("reservaFechaRequeridaFin",fin);

	if(sessionStorage.getItem("reservaInmueble_id") !== null)
	$.each(JSON.parse(sessionStorage.getItem("inmueblesReservables")), function(x , y) 
	{
		if(y["id_inmueble"] == sessionStorage.getItem("reservaInmueble_id"))
		{
			$("#reserva-title").html("<h2><span teid=re:html:72></span> " + sessionStorage.getItem("reservaInmueble_text") + "</h2>");
			$("#fechareservainicio").val(inicio);
			$("#fechareservafin").val(fin);
		}
		else if(sessionStorage.getItem("reservaInmueble_id").indexOf("Zonas ") == 0)
		{
			$("#reserva-title").html("<h2><span teid=re:html:72></span> " + sessionStorage.getItem("reservaInmueble_text") + "</h2>");
			$("#fechareservainicio").val(inicio);
			$("#fechareservafin").val(fin);
		}
	});

	var title = $('#eventTitle');
	var start = $('#eventStart');
	var end = $('#eventEnd');

	$("#btndisponibilidad").click(function(){
		sessionStorage.setItem("reservaInmueble_id",$("#ddrecursos").val());
		sessionStorage.setItem("reservaInmueble_text",$("#ddrecursos option:selected").text());
		location.reload();
	});

	$('#listareservas').DataTable({
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
	    exclude: [ 0, 1 ],
	    exclude: [ 0, 5 ]
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

	$('#btncalendario').click(function(){
		if(sessionStorage.getItem("reservaInmueble_id") !== null)
			sessionStorage.removeItem("reservaInmueble_id");
		if(sessionStorage.getItem("reservaInmueble_text") !== null)
			sessionStorage.removeItem("reservaInmueble_text");
		location.replace("index.php");
	});

	$('#reservaEdit').dialog({
		resizable: false,
		autoOpen: false,
		width:550,
		title: obtenerTerminoLenguage('re','40'),
		open: function(){
            $("#startfecha").datepicker({
                minDate: 0,
                dateFormat: 'yy-mm-dd'
            });
            $("#endfecha").datepicker({
                minDate: 0,
                dateFormat: 'yy-mm-dd'
            });
            $("#ui-datepicker-div").css("z-index", "99999 !important");
        }
	});

	$('#reservaBorrar').dialog({
		resizable: false,
		autoOpen: false,
		title: obtenerTerminoLenguage('re','73')
	});

	$('#reservaEditar').submit(function(event){
		event.preventDefault();
		$('input[type=submit]').attr('disabled',true);
		var start = new Date($("#startfecha").val()  + "T" + $("#starthora").val() + ":00+00:00");
		var end = new Date($("#endfecha").val()  + "T" + $("#endhora").val() + ":00+00:00");
		if(start < end)
		{
			var arr = 
			{
			  token:sessionStorage.getItem('token'),
			  body:
			  {
			    id:$("#mongoid").val(),
			    fecha_creacion:$("#creacion").val(),
			    usuario:$("#user").val(),
			    comentario:$("#comentario").val(),
			    id_copropiedad:$("#idcopropiedad").val(),
			    id_inmueble:$("#idinmueble").val(),
			    estado:$("#estado").val(),
			    fecha_inicio:$("#startfecha").val() + "COT" + $("#starthora").val() + ":00+00:00",
			    fecha_fin:$("#endfecha").val()  + "COT" + $("#endhora").val() + ":00+00:00"
			  }
			}; 
			var url = "reservas/reserva/";
			var response = envioFormularioSync(url,arr,'PUT');
			if(response)
			{	
				$(document).renderme('ma');
				var body = '<h4 style="color:#666 !important;">'+ obtenerTerminoLenguage('ma','13') + sessionStorage.getItem('reservaInmueble_text') + obtenerTerminoLenguage('ma','32') + sessionStorage.getItem('ncp') + obtenerTerminoLenguage('ma','14')+'</h4><h4>'+ obtenerTerminoLenguage('ma','15') +'</h4><ul><li><h4 style="color:#666 !important;">'+ obtenerTerminoLenguage('ma','16') + $("#startfecha").val() + obtenerTerminoLenguage('ma','17')+ $("#starthora").val() + '</h4></li><li><h4 style="color:#666 !important;">'+ obtenerTerminoLenguage('ma','18') + $("#endfecha").val() + obtenerTerminoLenguage('ma','17') + $("#endhora").val() + '</h4></li></ul>';
				$(document).renderme('ma');
				var to = $("#user").val().split('|')[0].replace('cp-','');
				//console.warn(to);
				enviocorreoSync(to, obtenerTerminoLenguage('ma','20'), body);
			  	setTimeout(refreshWindow('administrador-de-reservas.php'),1000);
			}
			else
			{
			  $("#crearsolicitud").dialog("close");
			  $("#alertas").html('<div class="alert alert-dismissable alert-error" teid="ale:html:21"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:1"></strong></div>');
			  $(document).renderme('re');
			}
		}
		else
		{
			$("#startfecha").css('border','1px solid red');
			$("#starthora").css('border','1px solid red');
			$("#endfecha").css('border','1px solid red');
			$("#endhora").css('border','1px solid red');
			$('input[type=submit]').attr('disabled',false);
		}
	});

	$('#reservaBorrar').submit(function(event){
		event.preventDefault();
		$('input[type=submit]').attr('disabled',true);
		var arr = 
        {
          token:sessionStorage.getItem('token'),
          body:
          {
            id:$("#mongoid").val()
          }
        }; 
        var url = "reservas/reserva/";
		var response = envioFormularioSync(url,arr,'DELETE');
		if(response)
		{
			$(document).renderme('ma');
			var body = '<h4 style="color:#666 !important;">'+ obtenerTerminoLenguage('ma','13') + sessionStorage.getItem('reservaInmueble_text') + obtenerTerminoLenguage('ma','32') + sessionStorage.getItem('ncp') + obtenerTerminoLenguage('ma','21') +'</h4>';
			$(document).renderme('ma');
			var to = $("#userborrado").val().split('|')[0].replace('cp-','');
			//console.warn(to);
			enviocorreoSync(to, obtenerTerminoLenguage('ma','23'), body);
		  setTimeout(refreshWindow('administrador-de-reservas.php'),1000);
		}
		else
		{
		  $("#crearsolicitud").dialog("close");
		  $("#alertas").html('<div class="alert alert-dismissable alert-error" teid="ale:html:21"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:1"></strong></div>');
		  $(document).renderme('re');
		}
	});

	popularReservas();

	$("#alertas").html('<div class="alert alert-dismissable alert-info" teid="ale:html:35"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong teid="ale:html:28"></strong> </div>');

	$("input[type=date]").removeAttr('min');

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