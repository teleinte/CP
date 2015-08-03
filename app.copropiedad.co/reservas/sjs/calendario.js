$(document).ready(function() {
	obtenerInmuebles();
	$(document).renderme('re');
	$("#fecha-reserva").removeAttr('min');
	//console.warn(d.split("T")[0]);
	var dt = new Date();
		dt.setMonth(dt.getMonth() + 11);
	$("#fecha-reserva-fin").val(dt.toISOString().split("T")[0]);
	if(sessionStorage.getItem("reservaFechaRequerida") === null)
	{
		sessionStorage.setItem("reservaFechaRequerida",d);
	}
	if(sessionStorage.getItem("reservaInmueble_id") === null)
	{
		$("#calendar-visibility").hide();
		var d = $.fullCalendar.moment().format().split('T')[0];
		$("#fecha-reserva").val(d);
	}
	else
	{
		var horainicio = "";
		var horafin = "";
		var diasreserva  = new Array();
		var reservaspan = "";
		var inmueble = "";
		var restriccion_inicio = "00";
		var restriccion_fin = "23";
		$.each(JSON.parse(sessionStorage.getItem("inmueblesReservables")), function(x , y) 
		{
			if(y["_id"]["$id"] == sessionStorage.getItem("reservaInmueble_id"))
			{
				horainicio	= y["hora_inicio_reserva"];
				horafin = y["hora_fin_reserva"];
				reservaspan = y["tiempo_reserva"];
				diasreserva	 = y["dias_reserva"].split(",");
				ocultadias = calcularDias(diasreserva);
				//console.log([horainicio,horafin,reservaspan,diasreserva,ocultadias]);
				renderizaCalendario(ocultadias, horainicio, horafin, reservaspan, sessionStorage.getItem("reservaInmueble_id"), sessionStorage.getItem("reservaFechaRequerida"), diasreserva);
				$("#reserva-title").html("<h2><span teid=re:html:72></span> " + sessionStorage.getItem("reservaInmueble_text") + "</h2>");
			}
		});
		$("#calendar-visibility").show();
		$("#fecha-reserva").val(new Date(sessionStorage.getItem("reservaFechaRequerida")).toISOString().split("T")[0]);
	}

	var title = $('#eventTitle');
	var start = $('#eventStart');
	var end = $('#eventEnd');

	$("#btndisponibilidad").click(function(){
		var d = new Date($("#fecha-reserva").val());
		//console.log(d.toISOString());
		//console.log($("#fecha-reserva").val());
		//d = d.addDays(7);
		//var to = d.setTime(d.getTime() - (d.getDay() ? d.getDay() : 7) * 24 * 60 * 60 * 1000);
		//var from = d.setTime(d.getTime() - 6 * 24 * 60 * 60 * 1000);
		var from = $.fullCalendar.moment($("#fecha-reserva").val()).startOf('week').format();
		var to = $.fullCalendar.moment($("#fecha-reserva").val()).endOf('week').format();
		//console.warn($("#fecha-reserva").val());
		sessionStorage.setItem("reservaInmueble_id",$("#ddrecursos").val());
		sessionStorage.setItem("reservaFechaRequerida",d);
		sessionStorage.setItem("reservaFechaRequeridaInicio",new Date(to).addDays(-1).toISOString());
		sessionStorage.setItem("reservaFechaRequeridaFin",new Date(from).addDays(-1).toISOString());
		sessionStorage.setItem("reservaInmueble_text",$("#ddrecursos option:selected").text());
		location.reload();
	});

	$("#btndisponibilidadanterior").click(function(){
		//var d = new Date($("#fecha-reserva").val());
		var fechanueva = $.fullCalendar.moment($("#fecha-reserva").val()).subtract(7,'days').format();
		var from = $.fullCalendar.moment(fechanueva).startOf('week').format();
		var to = $.fullCalendar.moment(fechanueva).endOf('week').format();
		//console.warn(from, to);
		//d = d.addDays(0);
		//var to = d.setTime(d.getTime() - (d.getDay() ? d.getDay() : 7) * 24 * 60 * 60 * 1000);
		//var to = d.setTime(d.getTime() - (d.getDay() ? d.getDay() : 7) * 24 * 60 * 60 * 1000);
		//var from = d.setTime(d.getTime() - 6 * 24 * 60 * 60 * 1000);
		//var from = d.setTime(d.getTime() - 6 * 24 * 60 * 60 * 1000);
		sessionStorage.setItem("reservaInmueble_id",$("#ddrecursos").val());
		sessionStorage.setItem("reservaFechaRequerida",fechanueva);
		sessionStorage.setItem("reservaFechaRequeridaInicio",new Date(to).toISOString());
		sessionStorage.setItem("reservaFechaRequeridaFin",new Date(from).toISOString());
		sessionStorage.setItem("reservaInmueble_text",$("#ddrecursos option:selected").text());
		location.reload();
	});

	$("#btndisponibilidadsiguiente").click(function(){
		//var d = new Date($("#fecha-reserva").val());
		//d = d.addDays(14);
		/*var to = d.setTime(d.getTime() - (d.getDay() ? d.getDay() : 7) * 24 * 60 * 60 * 1000);
		var from = d.setTime(d.getTime() - 6 * 24 * 60 * 60 * 1000);
		console.warn("-----------");
		console.warn($.fullCalendar.moment(d).weekday(7).format(), $.fullCalendar.moment(d).weekday(-7).format());
		console.warn("-----------");
		console.warn($.fullCalendar.moment(from).weekday(7).format(), $.fullCalendar.moment(to).weekday(-7).format());*/
		var fechanueva = $.fullCalendar.moment($("#fecha-reserva").val()).add(7,'days').format();
		var from = $.fullCalendar.moment(fechanueva).startOf('week').format();
		var to = $.fullCalendar.moment(fechanueva).endOf('week').format();
		sessionStorage.setItem("reservaInmueble_id",$("#ddrecursos").val());
		sessionStorage.setItem("reservaFechaRequerida",fechanueva);
		sessionStorage.setItem("reservaFechaRequeridaInicio",new Date(to).addDays(-1).toISOString());
		sessionStorage.setItem("reservaFechaRequeridaFin",new Date(from).addDays(-1).toISOString());
		sessionStorage.setItem("reservaInmueble_text",$("#ddrecursos option:selected").text());
		location.reload();
	});

	$('#calEventDialog').dialog({
		resizable: false,
		autoOpen: false,
		width: 500,
		title: obtenerTerminoLenguage('re','28')
	});

	$(".btnborrareserva").click(function(){
		sessionStorage.setItem("borrar",1);
	});

	$("#reserva_form").submit(function(event){
		event.preventDefault();
		$('input[type=submit').attr('disabled',true);
		var arr = 
		{
		  token:sessionStorage.getItem('token'),
		  body:
		  {
		    fecha_creacion:fecha(),
		    id_copropiedad : $("#crea_id_copropiedad").val(),
		    id_inmueble: $("#crea_id_inmueble").val(),
		    fecha_inicio:$("#crea_fecha_inicio").val(),
		    fecha_fin:$("#crea_fecha_fin").val(),
		    usuario:$("#crea_usuario").val(),
		    estado:$("#crea_estado").val(),
		    comentario:$('#crea_comentario').val()                      
		  }
		}; 
		var url = "reservas/reserva/";
		var response = envioFormularioSync(url,arr,'POST');
		if(response)
		{
			$(document).renderme('ma');
			var body = '<h4 style="color:#666 !important;">' + obtenerTerminoLenguage('ma','13') + sessionStorage.getItem('reservaInmueble_text') + obtenerTerminoLenguage('ma','32') + sessionStorage.getItem('ncp') + obtenerTerminoLenguage('ma','72') +'</h4><h4>'+ obtenerTerminoLenguage('ma','73') +'</h4><ul><li><h4 style="color:#666 !important;">'+ obtenerTerminoLenguage('ma','16') + $("#crea_fecha_inicio").val().replace("T"," ").replace(":00+00:00","") + '</h4></li><li><h4 style="color:#666 !important;">'+ obtenerTerminoLenguage('ma','18') + $("#crea_fecha_fin").val().replace("T"," ").replace(":00+00:00","") + '</h4></li></ul>';
			$(document).renderme('ma');
			var to = $("#crea_usuario").val().split('|')[0].replace('cp-','');
			//console.warn(to);
			var responsee = enviocorreoSync(to, obtenerTerminoLenguage('ma','74'), body);
			//console.warn(responsee);
		  if(responsee)
		  	setTimeout(refreshWindow('calendario-de-reservas.php'),1000);
		}
		else
		{
		  $("#crearsolicitud").dialog("close");
		  $("#alertas").html('<div class="alert alert-dismissable alert-error" teid="ale:html:21"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:1"></strong></div>');
		  $(document).renderme('re');
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