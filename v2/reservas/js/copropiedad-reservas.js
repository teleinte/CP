$(document).ready(function() {
	obtenerInmuebles();
	var d = new Date().toISOString();
	$("#fecha-reserva").val(d.split("T")[0]);
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
	}
	else
	{
		var horainicio = "";
		var horafin = "";
		var diasreserva  = new Array();
		var reservaspan = "";
		var grupo = "";
		var inmueble = "";
		var porgrupo = false;
		var offset = "00";
		var restriccion_inicio = "00";
		var restriccion_fin = "23";
		$.each(JSON.parse(sessionStorage.getItem("inmueblesReservables")), function(x , y) 
		{
			if(sessionStorage.getItem("reservaInmueble_id").indexOf("Zonas ") != 0)
			{
				if(y["id_inmueble"] == sessionStorage.getItem("reservaInmueble_id"))
				{
					inmueble = y["id_inmueble"];
					grupo = y["grupo"];
					horainicio	= y["hora_inicio_reserva"];
					horafin = y["hora_fin_reserva"];
					reservaspan = y["tiempo_reserva"];
					diasreserva	 = y["dias_reserva"].split(",");
					ocultadias = calcularDias(diasreserva);
					offset = y["offset_inicio"];
					restriccion_inicio = y["hora_inicio_restriccion"];
					restriccion_fin = y["hora_fin_restriccion"];
					renderizaCalendario(ocultadias, horainicio, horafin, reservaspan, grupo, inmueble, sessionStorage.getItem("reservaFechaRequerida"), offset, restriccion_inicio, restriccion_fin, diasreserva);
					$("#reserva-title").html("<h2>Reservas para " + sessionStorage.getItem("reservaInmueble_text") + "</h2>");
				}
			}
			else
			{
				porgrupo = true;
				return false;
			}
		});
		if(porgrupo)
		{
			grupo = sessionStorage.getItem("reservaInmueble_id");
			horainicio	= sessionStorage.getItem("reservaFechaRequeridaInicio");
			horafin = sessionStorage.getItem("reservaFechaRequeridaFin");
			renderizaCalendarioGrupo(horainicio,horafin, grupo, sessionStorage.getItem("reservaFechaRequerida"));
			$("#reserva-title").html("<h2>Reservas para " + sessionStorage.getItem("reservaInmueble_id") + "</h2>");
		}
		$("#calendar-visibility").show();
		$("#fecha-reserva").val(new Date(sessionStorage.getItem("reservaFechaRequerida")).toISOString().split("T")[0]);
	}

	var title = $('#eventTitle');
	var start = $('#eventStart');
	var end = $('#eventEnd');

	$("#btndisponibilidad").click(function(){
		var d = new Date($("#fecha-reserva").val());
		d = d.addDays(7);
		var to = d.setTime(d.getTime() - (d.getDay() ? d.getDay() : 7) * 24 * 60 * 60 * 1000);
		var from = d.setTime(d.getTime() - 6 * 24 * 60 * 60 * 1000);
		sessionStorage.setItem("reservaInmueble_id",$("#ddrecursos").val());
		sessionStorage.setItem("reservaFechaRequerida",d);
		sessionStorage.setItem("reservaFechaRequeridaInicio",new Date(to).addDays(-1).toISOString());
		sessionStorage.setItem("reservaFechaRequeridaFin",new Date(from).addDays(-1).toISOString());
		sessionStorage.setItem("reservaInmueble_text",$("#ddrecursos option:selected").text());
		location.reload();
	});

	$("#btndisponibilidadanterior").click(function(){
		var d = new Date($("#fecha-reserva").val());
		d = d.addDays(0);
		var to = d.setTime(d.getTime() - (d.getDay() ? d.getDay() : 7) * 24 * 60 * 60 * 1000);
		var from = d.setTime(d.getTime() - 6 * 24 * 60 * 60 * 1000);
		sessionStorage.setItem("reservaInmueble_id",$("#ddrecursos").val());
		sessionStorage.setItem("reservaFechaRequerida",d);
		sessionStorage.setItem("reservaFechaRequeridaInicio",new Date(to).addDays(-1).toISOString());
		sessionStorage.setItem("reservaFechaRequeridaFin",new Date(from).addDays(-1).toISOString());
		sessionStorage.setItem("reservaInmueble_text",$("#ddrecursos option:selected").text());
		location.reload();
	});

	$("#btndisponibilidadsiguiente").click(function(){
		var d = new Date($("#fecha-reserva").val());
		d = d.addDays(14);
		var to = d.setTime(d.getTime() - (d.getDay() ? d.getDay() : 7) * 24 * 60 * 60 * 1000);
		var from = d.setTime(d.getTime() - 6 * 24 * 60 * 60 * 1000);
		sessionStorage.setItem("reservaInmueble_id",$("#ddrecursos").val());
		sessionStorage.setItem("reservaFechaRequerida",d);
		sessionStorage.setItem("reservaFechaRequeridaInicio",new Date(to).addDays(-1).toISOString());
		sessionStorage.setItem("reservaFechaRequeridaFin",new Date(from).addDays(-1).toISOString());
		sessionStorage.setItem("reservaInmueble_text",$("#ddrecursos option:selected").text());
		location.reload();
	});

	$('#calEventDialog').dialog({
		resizable: false,
		autoOpen: false,
		width: 500,
		title: 'Reservar recurso'
	});

	$(".btnborrareserva").click(function(){
		sessionStorage.setItem("borrar",1);
		alert('hola');
	});
});

function eventoEdit()
{
	var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})

	if (!sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm') || !sessionStorage.getItem('token'))
	 {  
	    window.location = '../index.html';
	    return false
	 }
	 else
	 {
	 	var cal_cp = "";
	 	if ($('#rev_cal_copropiedad').val() == "SI")
	 	{
	 		cal_cp = true;
	 	}
	 	else
	 	{
	 		cal_cp = false;
	 	}

	    var arr = 
	    {
	      token:sessionStorage.getItem('token'),
	      body:
	      {
	        id:$('#rev_id').val(),
	        id_copropiedad : sessionStorage.getItem('cp'),
	        creador: sessionStorage.getItem('id_crm'),
	        fecha_creacion:$('#rev_fecha_creacion').val(),
	        tipo:"evento",
	        nombre:$('#rev_nombre').val(),
	        estado:"Por Iniciar",
	        fecha_inicio:$('#rev_fecha_inicio').val(),
	        fecha_fin:$('#rev_fecha_fin').val(),
	        compartir_mail:$('#rev_compartir_mail').val(),                    
	        frecuencia:$('#rev_frecuencia').val(),
	        cal_copropiedad:cal_cp,
	        frecordatorio:$('#rev_frecordatorio').val(),
	        recordatorio_mail:$('#rev_recordatorio_mail').val(),
	        recordatorio_cp:$('#rev_recordatorio_cp').val(),
	        notas:$('#rev_notas').val()                       
	      }
	    }; 
	    var url = "eventos/evento/";
	    envioFormulario(arr,url,params,'PUT')
	 }
}

function renderizaCalendario(reservadias, reservastart, reservaend, reservaspan, reservagrupo, reservainmueble, defaultdate, offset_inicio, restriccion_inicio, restriccion_fin, diasreservables)
{
	var dias = reservadias;
	var rstart = reservastart;
	var rend = reservaend;
	var rslot = reservaspan;
	var fecha = defaultdate;
	var fechaRequerida = new Date(defaultdate);
	var miniTime = rstart + ':' + offset_inicio + ":00";
	var maxiTime = rend + ':' + offset_inicio + ":00";
	$('#calendar1').fullCalendar({
		header: {
			left: '',
			center: 'title',
			right: ''
		},
		editable: true,
		slotDuration: '00:30:00',
		//slotDuration: offset,
		height: 545, 
		firstDay:1,
		defaultDate:defaultdate,
		displayEventEnd: true,
		//now: fechaRequerida.addDays(1),
		minTime: miniTime,
		maxTime: maxiTime,
		//minTime: '08:01:00',
		//maxTime: '19:30:00',
		//hiddenDays: dias,
		allDaySlot: false,
		eventLimit: true, // allow "more" link when too many events
		timezone: 'America/Bogota',
		businessHours: {
			start: rstart,
			end: rend,
			dow: [0,1,2,3,4,5,6]
		},
		defaultView: 'agendaWeek',
		eventClick:  function(event, jsEvent, view) {
			//set the values and open the modal
			$("#startTime").html(moment(event.start).format('MMMM D, h:mm A'));
        	$("#endTime").html(moment(event.end).format('MMMM D, h:mm A'));
			$("#eventContent").dialog({ modal: true, width:400 });
		},
		selectable: true,
		selectHelper: true,
		lazyFetching: true,
		loading: function(bool) {
		  if (bool) {
		    $('#preloader').show();}
		  else {
		    $('#preloader').hide();}
		},
		select: function(start, end) {
			$('#calEventDialog #eventStart').val(moment(start).format());
			$('#calEventDialog #eventEnd').val(moment(end).format());
			if ($('#eventStart[value*="T00:00:00"]').length > 0 && $('#eventEnd[value*="T00:00:00"]').length > 0) {
				$('#calEventDialog #eventStart').val(moment(start).format('YYYY-MM-DD'));
				$('#calEventDialog #eventEnd').val(moment(end).format('YYYY-MM-DD'));
			}
			startdate = moment(start).format();
			enddate = moment(end).format();
			var today = new Date().toISOString().split("T")[0];
			if(enddate == null)
				enddate = startdate;
			var horastart = startdate.split("T")[1].replace(":00+00:00","");
			var horaend = enddate.split("T")[1].replace(":00+00:00","");
			var diastart = startdate.split("T")[0].replace(":00+00:00","");
			var diaend = enddate.split("T")[0].replace(":00+00:00","");
			if(horaend == "00:00")
				horaend = "24:00";
			if(!isOverlapping(startdate, enddate))
			{
				if(validarPasado(enddate))
				{
					$("#reservaStatus").html('<h2>La reserva no se puede realizar</h2>');
					$("#reservaData").html("No es posible crear reservas en fecha pasadas");
					$("#reservaConfirmar").html('');
					$("#reservaComment").html('');
				}
				//else if(parseInt(horastart.replace(":00","")) >= parseInt(rstart.replace(":00","")) && parseInt(horaend.replace(":00","")) <= parseInt(rend.replace(":00","")))
				else
				{
					if(validarDias(startdate, enddate))
					{
						$("#reservaStatus").html('<h2>La reserva no se puede realizar</h2>');
						$("#reservaData").html("<p>No es posible crear reservas que superen el tiempo maximo de reserva programado.</p><p>El tiempo maximo de reserva para este recurso son " + parseInt(rslot) + " hora(s).</p><p>La reserva que intenta realizar se extiende por más de un día.</p>");
						$("#reservaConfirmar").html('');
						$("#reservaComment").html('');
					}
					else if(validarHoras(startdate, enddate, rslot, true))
					{
						$("#reservaStatus").html('<h2>La reserva no se puede realizar</h2>');
						$("#reservaData").html("<p>No es posible crear reservas que superen el tiempo maximo de reserva programado.</p><p>El tiempo maximo de reserva para este recurso es " + parseInt(rslot) + " hora(s).</p><p>La reserva que intenta realizar tiene " + validarHoras(startdate, enddate, rslot, false) + "; le sugerimos realizarla en dos o mas reservas.</p>");
						$("#reservaConfirmar").html('');
						$("#reservaComment").html('');
					}
					else
					{
						$("#reservaData").html("Está seguro de realizar la reserva del recurso para el día " + diastart	+ " a las " + horastart	+ " y finalizando a las " + horaend + " el día " + diaend);
						$("#reservaComment").html('<label for="crea_comentario">Agregar un comentario a tu reserva</label><input type="textarea" id="crea_comentario" name="comentario" rows=2 style="width:100%;"/>');
						$("#reservaStatus").html('<h2>Confirmación de reserva</h2>');
						$("#reservaConfirmar").html('<input type="submit" class="btn icono guardar" value="Reservar recurso"/>');
						$("#crea_id_copropiedad").val(sessionStorage.getItem("cp"));
						$("#crea_id_inmueble").val(reservainmueble);
						$("#crea_grupo").val(reservagrupo);
						$("#crea_fecha_inicio").val(startdate);
						$("#crea_fecha_fin").val(enddate);
						$("#crea_usuario").val(sessionStorage.getItem("email") + "|" + sessionStorage.getItem("nombreCompleto"));
					}
				}
				/*else
				{
					$("#reservaStatus").html('<h2>La reserva no se puede realizar</h2>');
					$("#reservaData").html("La reserva del recurso no se puede realizar porque no se encuentra dentro de las horas reservables.");
					$("#reservaConfirmar").html('');
					$("#reservaComment").html('');
				}*/
			}
			else
			{
				$("#reservaStatus").html('<h2>La reserva no se puede realizar</h2>');
				$("#reservaData").html("La reserva del recurso no se puede realizar porque existe un conflicto de reservas.");
				$("#reservaConfirmar").html('');
				$("#reservaComment").html('');
			}
			$("#calEventDialog").dialog({ modal: true });
			$('#calEventDialog').dialog('open');
		},
		eventSources: [
			{
				events: function(start, end, timezone, callback){
					const rutaAplicativo = "http://aws02.sinfo.co/api/reservas/reservas/listar/inmueble/fecha/"; 
					var arr = { token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp'),id_inmueble:sessionStorage.getItem("reservaInmueble_id"),fecha_fin:sessionStorage.getItem("reservaFechaRequeridaInicio").split("T")[0],fecha_inicio:sessionStorage.getItem("reservaFechaRequeridaFin").split("T")[0]}};
					//var data = JSON.stringify(arr);
					//console.log(arr);
					$.post(rutaAplicativo, JSON.stringify(arr))
					        .done(function(msg){
					        	var reservasCalendario = [];
					            var msgDividido = JSON.stringify(msg);
					            var mensaje =  JSON.parse(msgDividido);
					            var msgDivididoDos = JSON.stringify(mensaje.message);
					            var datos = JSON.parse(msgDivididoDos);
					            //console.log(datos);        
					            if (datos=="Token invalido")
					            {
					                $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>')                  
					                window.location = '../index.html';
					            }
					            else
					            {
					            	if(!$.isEmptyObject(datos))
					                $.each(datos, function(x , y) 
					                {
					                    var user = "Reservado - " + y['usuario'].split("|")[1];
					                    reservasCalendario.push({
					                        title: user,
					                        start: (y['fecha_inicio']).replace("COT","T"),
					                        end: y['fecha_fin'].replace("COT","T"),
					                        className: "destacado",
					                        grupo: reservagrupo,
					                        inmueble: reservainmueble,
					                        editable: false,
					                        overlap: false
					                    });
					                })
					            }
					            $("#ddrecursos").val(sessionStorage.getItem("reservaInmueble_id"));
					            callback(reservasCalendario);
					        });
					}
			},
			{
				events: function(start, end, timezone, callback){
							var diasNoReservables = new Array();
							var hoy = new Date(fecha);
				           	if(!$.isEmptyObject(dias))
				           	for(i in dias)
				            {
				            	if(dias[i] == 0)
				            		var fechastart = w2date(hoy.addDays(7), dias[i] - 1);
				            	else
				            		var fechastart = w2date(hoy, dias[i] - 1);
				            	var startdate = fechastart.toISOString().split("T")[0] + "T00:00:00.000Z";
				            	var enddate = fechastart.toISOString().split("T")[0] + "T23:59:00.000Z";
				            	diasNoReservables.push({
				                        title: "No disponible - Administrador",
				                        start: startdate,
				                        end: enddate,
				                        className: "rojo",
				                        grupo: reservagrupo,
				                        inmueble: reservainmueble,
				                        editable: false,
				                        overlap: false
				                    });	
				            }
				            callback(diasNoReservables);
				        }
			},
			{
				events: function(start, end, timezone, callback){
							var horasNoReservables = new Array();
							//var diasSemana = new Array(0,1,2,3,4,5,6);
							var diasSemana = diasreservables;
							var hoy = new Date(fecha);
				           	for(i in diasSemana)
				            {
				            	if(diasSemana[i] == 0)
				            		var fechastart = w2date(hoy.addDays(7), diasSemana[i] - 1);
				            	else
				            		var fechastart = w2date(hoy, diasSemana[i] - 1);
				            	var startdate = fechastart.toISOString().split("T")[0] + "T" + restriccion_inicio + ":00:00.000Z";
				            	var enddate = fechastart.toISOString().split("T")[0] + "T" + restriccion_fin + ":00:00.000Z";
				            	horasNoReservables.push({
				                        title: "No disponible - Administrador",
				                        start: startdate,
				                        end: enddate,
				                        className: "naranja",
				                        grupo: reservagrupo,
				                        inmueble: reservainmueble,
				                        editable: false,
				                        overlap: false
				                    });	
				            }
				            callback(horasNoReservables);
				        }
			}
		]
	});
}

function renderizaCalendarioGrupo(reservastart, reservaend, reservagrupo, defaultdate)
{
	var rstart = reservastart;
	var rend = reservaend;
	var fechaRequerida = new Date(defaultdate);
	$('#calendar1').fullCalendar({
		header: {
			left: '',
			center: 'title',
			right: ''
		},
		editable: false,
		slotDuration: '01:00:00',
		height: 545, 
		firstDay:1,
		defaultDate:defaultdate,
		//now: fechaRequerida.addDays(1),
		allDaySlot: false,
		eventLimit: true, // allow "more" link when too many events
		timezone: 'America/Bogota',
		businessHours: {
			start: rstart,
			end: rend,
			dow: [0,1,2,3,4,5,6]
		},
		defaultView: 'agendaWeek',
		eventClick:  function(event, jsEvent, view) {
			$("#reservaStatus").html('<h2>La reserva no se puede realizar</h2>');
			$("#reservaData").html("Para reservar seleccione el recurso que desea reservar en la lista desplegable superior.");
			$("#reservaConfirmar").html('');
			$("#reservaComment").html('');
			$("#calEventDialog").dialog({ modal: true });
			$('#calEventDialog').dialog('open');
		},
		select: function(start, end) {
			$("#reservaStatus").html('<h2>La reserva no se puede realizar</h2>');
			$("#reservaData").html("Para reservar seleccione el recurso que desea reservar en la lista desplegable superior.");
			$("#reservaConfirmar").html('');
			$("#reservaComment").html('');
			$("#calEventDialog").dialog({ modal: true });
			$('#calEventDialog').dialog('open');
		},
		selectable: true,
		selectHelper: true,
		lazyFetching: true,
		loading: function(bool) {
		  if (bool) {
		    $('#preloader').show();}
		  else {
		    $('#preloader').hide();}
		},
		eventSources: [
			{
				events: function(start, end, timezone, callback){
					const rutaAplicativo = "http://aws02.sinfo.co/api/reservas/reservas/listar/grupo/fecha/"; 
					var arr = { token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp'),grupo:sessionStorage.getItem("reservaInmueble_id"),fecha_inicio:sessionStorage.getItem("reservaFechaRequeridaFin").split("T")[0],fecha_fin:sessionStorage.getItem("reservaFechaRequeridaInicio").split("T")[0]} };
					//var data = JSON.stringify(arr);
					//console.log(arr);
					$.post(rutaAplicativo, JSON.stringify(arr))
					        .done(function(msg){
					        	var reservasCalendario = [];
					            var msgDividido = JSON.stringify(msg);
					            var mensaje =  JSON.parse(msgDividido);
					            var msgDivididoDos = JSON.stringify(mensaje.message);
					            var datos = JSON.parse(msgDivididoDos);  
					            //console.log(datos);
					            if (datos=="Token invalido")
					            {
					                $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>')                  
					                window.location = '../index.html';
					            }
					            else
					            {
					            	$("#leyendarecursos").html("");
					            	var leyenda = new Array();
					            	if(!$.isEmptyObject(datos))
					                $.each(datos, function(x , y) 
					                {
					                	var user = "Reservado - " + y['usuario'].split("|")[1];
					                	var idinm = y['id_inmueble']; 
					                	$.each(JSON.parse(sessionStorage.getItem("inmueblesReservables")), function(z , w) 
					                	{
					                		var data = idinm + "@@" + w["nombre_despliegue"];
					                		if(w["id_inmueble"] == idinm)
					                		{
					                			if(leyenda.indexOf(data) == -1)
					                			{
					                				leyenda.push(data);
					                			}
					                		}
					                	});
					                    reservasCalendario.push({
					                        title: user,
					                        start: (y['fecha_inicio']).replace("COT","T"),
					                        end: y['fecha_fin'].replace("COT","T"),
					                        className: "cn" + y["id_inmueble"],
					                        grupo: reservagrupo,
					                        editable: false,
					                        overlap: false
					                    });
					                });
									$.each(leyenda, function(index) 
				                	{
				                		$("#leyendarecursos").append('<div style="height:15px; width:20px; display:inline-block; position:relative;" class="' + "cn"+leyenda[index].split("@@")[0] + '"></div><span style="display:inline; padding-top:3px; position: absolute;">  ' + leyenda[index].split("@@")[1] + '</span>');
				                	});
					            }
					            $("#ddrecursos").val(sessionStorage.getItem("reservaInmueble_id"));
					            callback(reservasCalendario);
					        });
					}
			}
		]
	});
}

function calcularDias(reservadias)
{
	var dias = new Array(0,1,2,3,4,5,6);
	
	for (i = 0; i <= reservadias.length; i++) 
	{
		var idx = dias.indexOf(parseInt(reservadias[i]));
		if(idx >= 0)
		{
			dias.splice(idx,1);
		}
	}
	return dias;
}

function isOverlapping(start, end)
{
    var array = $("#calendar1").fullCalendar('clientEvents');
    for(i in array){
          if(array[i]._id != event._id){
          		var d1 = new Date(array[i].end).toISOString();
          		var d2 = new Date(end).toISOString();
          		var d3 = new Date(array[i].start).toISOString();
          		var d4 = new Date(start).toISOString();
              if((d2 > d3) && (d4 < d1))
              {
                  return true;
              }
          }
       }
       return false;
}

function w2date(date, dayNb)
{
	var weekno = new Date(date);
	weekno = weekno.getWeek();
	var year = new Date(date);
	year = year.getFullYear();
	var j10 = new Date( year,0,10,12,0,0),
        j4 = new Date( year,0,4,12,0,0),
        mon1 = j4.getTime() - j10.getDay() * 86400000;
    return new Date(mon1 + ((weekno - 1)  * 7  + dayNb) * 86400000);
};

Date.prototype.getWeek = function()
{
  var date = new Date(this.getTime());
   date.setHours(0, 0, 0, 0);
  date.setDate(date.getDate() + 3 - (date.getDay() + 6) % 7);
  var week1 = new Date(date.getFullYear(), 0, 4);
  return 1 + Math.round(((date.getTime() - week1.getTime()) / 86400000 - 3 + (week1.getDay() + 6) % 7) / 7);
}

Date.prototype.addDays = function(days)
{
    var dat = new Date(this.valueOf());
    dat.setDate(dat.getDate() + days);
    return dat;
}

function validarHoras(start, end, span, type)
{
	var startdate = new Date(start);
	startdate.setHours(startdate.getHours() + 5);
	var enddate = new Date(end);
	enddate.setHours(enddate.getHours() + 5);
	var datestart = startdate.getTime();
	var dateend = enddate.getTime();
	var diff = dateend - datestart;
	var min_span = parseInt(span) * 60;
	var diff_final = Math.floor(diff/60000);
	if(Math.floor(diff/60000) > min_span)
		{
			if(type)
				return true;
			else
			{
				if(Math.floor(diff/60000) < 1)
					return Math.floor(diff/60000) + " minutos";
				else
					return Math.floor(diff/60000)/60 + " horas";
			}
		}
	else
		{
			if(type)
				return false;
			else
				return Math.floor(diff/60000);
		}
}

function validarPasado(end)
{
	var hoy = new Date();
	hoy.setHours(hoy.getHours());
	var enddate = new Date(end);
	enddate.setHours(enddate.getHours() + 5);
	if(enddate < hoy)
		return true;
	else
		return false;
}

function validarDias(start, end)
{
	var startdate = new Date(start);
	var enddate = new Date(end);
	if(enddate.getDate() > startdate.getDate())
		return true;
	else
		return false;
}