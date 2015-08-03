function popularTabla(datos)
{
	if(datos != null || datos != undefined)
		if(datos.length > 0)
			$.each(datos,function(x,y){
				var idmongo= JSON.stringify(y['_id']);
				var idMongoFinal = JSON.parse(idmongo);
				var t = $('#inmuebles').DataTable(); 
				var days = ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];
				var dias = "";
				$.each(y['dias_reserva'].split(','),function(k,v){
					dias += ", " + days[v];
				});
				dias = dias.replace(/^[,]+|[,]+$/g, "").trim();
				t.row.add(['',y['nombre'],y['hora_inicio_reserva'] + ":00",y['hora_fin_reserva'] + ":00",dias,String(Number(y['tiempo_reserva'])) + " horas",'<input type="button" class="btn borrar solo inline btnborrainmueble" teid="re:title:114" mongoid="'+idMongoFinal.$id+'"/><input type="button" class="btn editar solo inline btneditainmueble ttip" teid="re:title:113" mongoid="'+idMongoFinal.$id+'" id_copropiedad="'+y['id_copropiedad']+'" name="'+y['nombre']+'" tiempo="'+y['tiempo_reserva']+'" inicio="'+y['hora_inicio_reserva']+'" fin="'+y['hora_fin_reserva']+'" dias="'+dias+'"/> ']).draw();
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

function isOverlapping(start, end, event)
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

function renderizaCalendario(reservadias, reservastart, reservaend, reservaspan, reservainmueble, defaultdate, diasreservables)
{
	var dias = reservadias;
	var rstart = reservastart;
	var rend = reservaend;
	var rslot = reservaspan;
	var fecha = $.fullCalendar.moment($("#fecha-reserva").val(),"YYYY-MM-DD");
	//console.warn(fecha);
	var fechaRequerida = new Date(defaultdate);
	var miniTime = rstart + ":00";
	var maxiTime = rend + ":00";
	$('#calendar1').fullCalendar({
		header: {
			left: '',
			center: 'title',
			right: ''
		},
		editable: true,
		slotDuration: '00:30:00',
		height: 545, 
		firstDay:1,
		defaultDate:fecha,
		displayEventEnd: true,
		minTime: miniTime,
		maxTime: maxiTime,
		hiddenDays: dias,
		allDaySlot: false,
		eventLimit: true,
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
        	$("#reservador").html(event.usuario);
        	$("#comentario").html(event.comentario);
			$("#eventContent").dialog({ modal: true, width:400 });
		},
		selectable: true,
		selectHelper: true,
		lazyFetching: true,
		select: function(start, end, event) {
			$('#calEventDialog #eventStart').val(moment(start).format());
			$('#calEventDialog #eventEnd').val(moment(end).format());
			if ($('#eventStart[value*="T00:00:00"]').length > 0 && $('#eventEnd[value*="T00:00:00"]').length > 0)
			{
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
			if(!isOverlapping(startdate, enddate, event))
			{
				if(validarPasado(enddate))
				{
					$("#reservaStatus").html('<h2><span teid="re:html:74"></span></h2>');
					$("#reservaData").html('<h6><span teid="re:html:75"></span></h2>');
					$("#reservaConfirmar").html('');
					$("#reservaComment").html('');
				}
				//else if(parseInt(horastart.replace(":00","")) >= parseInt(rstart.replace(":00","")) && parseInt(horaend.replace(":00","")) <= parseInt(rend.replace(":00","")))
				else
				{
					if(validarDias(startdate, enddate))
					{
						$("#reservaStatus").html('<h2 teid="re:html:74"></h2>');
						$("#reservaData").html("<p><span teid=re:html:76></span></p><p><span teid=re:html:77></span>" + parseInt(rslot) + " <span teid=re:html:78></span></p><p><span teid=re:html:79></span></p>");
						$("#reservaConfirmar").html('');
						$("#reservaComment").html('');
					}
					else if(validarHoras(startdate, enddate, rslot, true))
					{
						$("#reservaStatus").html('<h2 teid="re:html:74"></h2>');
						$("#reservaData").html("<p><span teid=re:html:76></span></p><p><span teid=re:html:77></span>" + parseInt(rslot) + " <span teid=re:html:78></span></p><p><span teid=re:html:80></span>" + validarHoras(startdate, enddate, rslot, false) + "<span teid=re:html:81></span></p>");
						$("#reservaConfirmar").html('');
						$("#reservaComment").html('');
					}
					else
					{
						$("#reservaData").html( obtenerTerminoLenguage('re','82')+ diastart	+ obtenerTerminoLenguage('re','83') + horastart	+ obtenerTerminoLenguage('re','84') + horaend + obtenerTerminoLenguage('re','85') + diaend);
						$("#reservaComment").html('<label for="crea_comentario" teid="re:html:30"></label><input type="textarea" id="crea_comentario" name="comentario" rows=2 style="width:100%;"/>');
						$("#reservaStatus").html('');
						$("#reservaConfirmar").html('<input type="submit" class="btn icono guardar positivo" teid="re:val:31, re:title:91" />');
						$("#crea_id_copropiedad").val(sessionStorage.getItem("cp"));
						$("#crea_id_inmueble").val(reservainmueble);
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
				$(document).renderme('re');
			}
			else
			{
				$("#reservaStatus").html('<h2 teid="re:html:74"></h2>');
				$("#reservaData").html(obtenerTerminoLenguage('re','86'));
				$("#reservaConfirmar").html('');
				$("#reservaComment").html('');
			}
			$("#calEventDialog").dialog({ modal: true });
			$('#calEventDialog').dialog('open');
		},
		eventSources: [
			{
				events: function(start, end, timezone, callback){
					var rutaAplicativo = traerDireccion()+"api/reservas/reservas/listar/inmueble/fecha/";
					//console.warn($.fullCalendar.moment($("#fecha-reserva").val(),"YYYY-MM-DD"));
					//console.warn($.fullCalendar.moment($("#fecha-reserva").val()).startOf('week').format());
					//console.warn($.fullCalendar.moment($("#fecha-reserva").val()).endOf('week').format());
					var arr = { token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp'),id_inmueble:sessionStorage.getItem("reservaInmueble_id"),fecha_fin:$.fullCalendar.moment($("#fecha-reserva").val()).endOf('week').format().split("T")[0],fecha_inicio:$.fullCalendar.moment($("#fecha-reserva").val()).startOf('week').format().split("T")[0]}};
					//var data = JSON.stringify(arr);
					//console.warn(arr);
					$.post(rutaAplicativo, JSON.stringify(arr))
				        .done(function(msg){
				        	var reservasCalendario = [];
				            var msgDividido = JSON.stringify(msg);
				            var mensaje =  JSON.parse(msgDividido);
				            var msgDivididoDos = JSON.stringify(mensaje.message);
				            var datos = JSON.parse(msgDivididoDos);
				            //console.warn(msg);        
				            if (datos=="Token invalido")
				            {
				                window.location = '../index.php';
				            }
				            else
				            {
				            	if(!$.isEmptyObject(datos))
				                $.each(datos, function(x , y) 
				                {
				                	//console.warn(y);
				                    var user = obtenerTerminoLenguage('re','87') + y['usuario'].split("|")[0].replace("cp-","");
				                    reservasCalendario.push({
				                        title: user,
				                        usuario: y['usuario'].split("|")[0].replace("cp-",""),
				                        comentario: y['comentario'],
				                        start: (y['fecha_inicio']).replace("COT","T"),
				                        end: y['fecha_fin'].replace("COT","T"),
				                        className: "destacado",
				                        editable: false,
				                        overlap: false
				                    });
				                });
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
			                        title:  obtenerTerminoLenguage('re','89'),
			                        start: startdate,
			                        end: enddate,
			                        className:  obtenerTerminoLenguage('re','90'),
			                        editable: false,
			                        overlap: false
			                    });	
			            }
			            callback(diasNoReservables);
			        }
			}
		]
	});

	$("#alertas").html('<div class="alert alert-dismissable alert-info"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4 teid="ale:html:41"></h4></div>'); 
	$(document).renderme('re');
}

function obtenerInmuebles()
{
    var arr = 
    {
      token:sessionStorage.getItem('token'),
      body:
      {
        id_copropiedad : sessionStorage.getItem('cp'),
        id_inmueble : ""                   
      }
    };
    var  url = "reservas/reservas/inmuebles/lista/";
    var datos = traerDatosSync(url, arr, sessionStorage.getItem('cp'));
    //console.log(datos);
    var inmuebles = new Array();
    sessionStorage.setItem("inmueblesReservables",JSON.stringify(datos));  
        
    $.each(datos, function(k,v){
        inmuebles.push('<option value="' + v['_id']['$id'] + '">' + v['nombre'] + "</option>");
    });
    var ddin = inmuebles.join();
    $("#ddrecursos").append(ddin);
    $("#fecha-reserva").val(new Date(sessionStorage.getItem("reservaFechaRequerida")).toISOString().split("T")[0]);
    $("#ddrecursos")[0].selectedIndex = 0;
}

function popularReporte(inmueble, start, end)
{
    var contador = 0;
    var contadorHoras = 0;
    var url = "reservas/reservas/listar/inmueble/fecha/"; 
    var arr = { token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp'),id_inmueble:inmueble,fecha_fin:end,fecha_inicio:start}};
    var datos = traerDatosSync(url,arr,'POST');

    //console.warn(arr);
    
	var t = $('#listareporte').DataTable();
	t.clear();
	var costos = new Array();
	var nombres = new Array();
	//console.warn(datos);
	if(!$.isEmptyObject(datos))
	{
		$.each(datos, function(x , y) 
		{
		    var idmongo= JSON.stringify(y['_id']);
		    var idMongoFinal = JSON.parse(idmongo);
		    var datestart = new Date(y['fecha_inicio'].replace("COT","T"));
		    //datestart.setHours(datestart.getHours() + 5);
		    var dateend = new Date(y['fecha_fin'].replace("COT","T"));
		    //dateend.setHours(dateend.getHours() + 5)
		    var datecreacion = new Date(y['fecha_creacion']);
		    var hours = Math.abs(dateend - datestart) / 36e5;
		    contadorHoras += hours;
		    var user = y['usuario'].split("|")[0].replace("cp-","");
		    /*var dend = new Date(dateend.toLocaleString());
		    var dstart = new Date(datestart.toLocaleString());
		    console.warn(dstart.toISOString().split('T')[0], end);
		    if(String(dstart.toISOString().split('T')[0]) === String(end))
		    	console.warn('true');
		    else
		    	console.warn('buu');*/
		    t.row.add(['',user,datestart.toISOString().split("T")[0] + " " + datestart.toISOString().split("T")[1].replace(":00.000Z",""),dateend.toISOString().split("T")[0] + " " + dateend.toISOString().split("T")[1].replace(":00.000Z","")]).draw();
		    	contador++;
		});
	}
	else
	{
		t.clear().draw();
	}

    $("#ddrecursos").val(inmueble);
    $("#reporte-title").html("<h2><span teid=re:html:120></span><span> " + $("#ddrecursos option:selected").text() + " en " + sessionStorage.getItem('ncp') + "</h2></span>");
    generaInforme(start, end, contador, contadorHoras);
    $(document).renderme('re');
}

function calculaCosto(start, end, costo)
{
    var startdate = new Date(start);
    var enddate = new Date(end);
    var datestart = startdate.getTime();
    var dateend = enddate.getTime();
    var diff = dateend - datestart;
    var diff_final = Math.floor(diff/60000);
    return diff_final/60 + "@@@" + costo * diff_final/60;
}

function generaInforme(fechai, fechaf, reservasCantidad, reservasHoras)
{	
	var promedio='';
    for(inmueble in reservasHoras){
        reservasHorasTotal = reservasHorasTotal + reservasHoras[inmueble];
    }
    if(reservasCantidad===undefined || reservasCantidad==0 || reservasCantidad=='0')
    {
    	promedio=0;
    }
    else{
    	promedio=Math.round(reservasHoras/reservasCantidad);
    }
    


    $("#consolidado").html("");
    $("#consolidado2").html('<div style="padding: 5px 5px 5;  margin-bottom: 10px; border:2px solid #aaa; padding:5px; background-color:#eee;-webkit-border-radius: 5px; -moz-border-radius: 5px;border-radius: 5px;"><table style="width:100%;border-spacing: 0.5rem;"><tr style="text-align:center;font-weight: bold; "><td><span teid="re:html:103"></span></td><td><span teid="re:html:106"></span></td><td><span teid="re:html:108"></span></td><td><span teid="re:html:110"></span></td></tr><tr style="text-align:center;"><td >' + fechai + '<span teid="re:html:104"></span>' + fechaf + '</td><td >' + reservasCantidad + '</td><td>' + reservasHoras + '</td><td>' + promedio + '</td></table></div>');
    $(document).renderme('re');
    $("#consolidado").html('<input type="submit" class="btn ttip positivo" teid="re:val:49, re:title:112" id="btnprint" style="margin:5px 0px;"/><div id="consolidado-print"><table><tr><td><h4><span teid="re:html:103"></span><br/>' + fechai + '<span teid="re:html:104"></span>' + fechaf + '</h4></td><td><h4><span teid="re:html:106"></span><br/>' + reservasCantidad + '</h4></td><td><h4><span teid="re:html:108"></span><br/>' + reservasHoras + '</h4></td><td><h4><span teid="re:html:110"></span><br/>' + promedio + '</h4></td></tr></table><br/></div>');
    //$("#listareporte").clone().appendTo("#consolidado-print");


    $("#btnprint").click(function(){
    	$("#consolidado-print").html('<div style="padding: 5px 5px 5;  margin-bottom: 10px; border:2px solid #aaa; padding:5px; background-color:#eee;-webkit-border-radius: 5px; -moz-border-radius: 5px;border-radius: 5px;"><table style="width:100%;border-spacing: 0.5rem;"><tr style="text-align:center;font-weight: bold; "><td><span teid="re:html:103"></span></td><td><span teid="re:html:106"></span></td><td><span teid="re:html:108"></span></td><td><span teid="re:html:110"></span></td></tr><tr style="text-align:center;"><td >' + fechai + '<span teid="re:html:104"></span>' + fechaf + '</td><td >' + reservasCantidad + '</td><td>' + reservasHoras + '</td><td>' + promedio + '</td></table></div>');
    	$("#consolidado-print").prepend('<div class="logo" id="printlogo" style="width:100%; height:70px; text-align:center;">' + '<h2><span teid=re:html:120></span><span> ' + sessionStorage.getItem('reservaInmueble_text') + ' en ' + sessionStorage.getItem('ncp') + '</h2></span>' + '</div><div style="clear:both;></div>');
    	$(document).renderme('re');
        $("#listareporte").clone().appendTo("#consolidado-print");
        $("#consolidado-print").print();
    });
}

function popularReservas()
{
	var rutaAplicativo = traerDireccion()+"api/reservas/reservas/listar/inmueble/fecha/";
	if(sessionStorage.getItem("reservaInmueble_id") !== null)
	{
		url = "reservas/reservas/listar/inmueble/fecha/"; 
		var arr = { token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp'),id_inmueble:sessionStorage.getItem("reservaInmueble_id"),fecha_fin:sessionStorage.getItem("reservaFechaRequeridaFin").split("T")[0],fecha_inicio:sessionStorage.getItem("reservaFechaRequeridaInicio").split("T")[0]}};
		var datos = traerDatosSync(url,arr,'POST');

		if(!$.isEmptyObject(datos))
	    $.each(datos, function(x , y){
	        var idmongo= JSON.stringify(y['_id']);
	        var idMongoFinal = JSON.parse(idmongo);
	        var t = $('#listareservas').DataTable();                                    
	        var s = y['fecha_inicio'].replace("COT","T");
	        var e = y['fecha_fin'].replace("COT","T");
	        var datestart = new Date(s)
	        //datestart.setHours(datestart.getHours() + 5);
	        var dateend = new Date(e);
	        //dateend.setHours(dateend.getHours() + 5)
	        var ds = new Date(s);
	        ds.setHours(ds.getHours() + 5);
	        var de = new Date(e);
	        de.setHours(de.getHours() + 5);
	        /*var dst = ds.toISOString().split("T")[1].split(":")[0] + ":" + ds.toISOString().split("T")[1].split(":")[1];
			var den = de.toISOString().split("T")[1].split(":")[0] + ":" + de.toISOString().split("T")[1].split(":")[1];*/
	        var datecreacion = new Date(y['fecha_creacion']).toISOString();
	        var user = y['usuario'].split("|")[1];
	        var comment = "";
	        t.row.add(['',datestart.toISOString().replace("T"," ").replace(":00.000Z",""),dateend.toISOString().replace("T"," ").replace(":00.000Z",""),user,y['comentario'],'<input type="submit" class="btn borrar solo inline btnborrareserva ttip" teid="re:title:114" mongoid="'+idMongoFinal.$id+'" usuario="' + y['usuario'] + '" value="" onClick="crearPopupBorrado(\'' + idMongoFinal.$id + '\',\'' + y['usuario'] + '\')"/><input type="submit" class="btn editar solo inline btneditareserva ttip"  teid="re:title:113" mongoid="'+idMongoFinal.$id+'" startdate="'+ds+'" creaciondate="'+datecreacion+'" enddate="'+de+'" user="'+y['usuario']+'" estado="'+ y['estado'] +'" comentario="'+y['comentario']+'" id_copropiedad="'+y['id_copropiedad']+'" id_inmueble="'+y['id_inmueble']+'" grupo="a" estado="'+y['estado']+'" value="" onClick="crearPopupEdicion(\'' + idMongoFinal.$id + '\',\'' + ds +'\',\'' + datecreacion + '\',\'' + de + '\',\'' + y['usuario'] + '\',\'' + y["comentario"] + '\',\'' + y["id_copropiedad"] + '\',\'' + y["id_inmueble"] + '\',\'a\',\'' + y['estado'] + '\')"/>']).draw();
	    });

		$("#ddrecursos").val(sessionStorage.getItem("reservaInmueble_id"));

		/*$(".btneditareserva").click(function(){
			crearPopupEdicion($(this).attr('mongoid'), $(this).attr('startdate'), $(this).attr('creaciondate'), $(this).attr('enddate'), $(this).attr('user'), $(this).attr('comentario'), $(this).attr('id_copropiedad'), $(this).attr('id_inmueble'), $(this).attr('grupo'), $(this).attr('estado'));
		});

		$(".btnborrareserva").click(function(){
			crearPopupBorrado($(this).attr('mongoid'), $(this).attr('usuario'));
		});*/
	}
}

function obtenerDatosInmuebles()
{
	var inmuebles = new Array();
	$.each(JSON.parse(sessionStorage.getItem("inmueblesReservables")), function(x , y) 
	{
		inmuebles[y["id_inmueble"]] = y["nombre_despliegue"];
	});
	return inmuebles;
}

function crearPopupEdicion(mongoid, start, creacion, end, user, comentario, idcopropiedad, idinmueble, grupo, estado)
{
	$("#mongoid").val(mongoid);
	$("#creacion").val(creacion);
	$("#user").val(user);
	$("#comentario").val(comentario);
	$("#idcopropiedad").val(idcopropiedad);
	$("#idinmueble").val(idinmueble);
	$("#estado").val(estado);
	$("#startfecha").datepicker('disable');
	$("#endfecha").datepicker('disable');
	//console.warn(start);
	//console.warn(end);
	var d1 = new Date(start);
	var d2 = new Date(end);
	d2.setHours(d2.getHours() - 5);
	d1.setHours(d1.getHours() - 5);
	$("#startfecha").val(d1.toISOString().split("T")[0]);
	$("#endfecha").val(d2.toISOString().split("T")[0]);
	$("#startfecha").attr('disabled',false);
	$("#endfecha").attr('disabled',false);
	//console.warn(zeroPad(String(Number(new Date(start).toISOString().split("T")[1].replace(":00.000Z","").split(":")[0])-5),2) + ":00");
	$("#starthora").val(d1.toISOString().split("T")[1].split(":")[0] + ":" + d1.toISOString().split("T")[1].split(":")[1]);
	$("#endhora").val(d2.toISOString().split("T")[1].split(":")[0] + ":" + d2.toISOString().split("T")[1].split(":")[1]);
	$("input").blur();
	$("#reservaEdit").dialog({ modal: true });
	$("#reservaEdit").dialog('open');
	if(!Modernizr.inputtypes.date){
		$("#ui-datepicker-div").css("z-index", "99999 !important");
	    $("#startfecha").unbind("keypress");
	    $("#endfecha").unbind("keypress");
	    $("#startfecha").datepicker({
	        minDate: 0,
	        dateFormat: 'yy-mm-dd'
	    });
	    $("#endfecha").datepicker({
	        minDate: 0,
	        dateFormat: 'yy-mm-dd'
	    });
	};
}

function crearPopupBorrado(mongoid, usuario)
{
	$("#reservaBorrar").dialog({ modal: true });
	$("#reservaBorrar").dialog('open');
	$("#mongoid").val(mongoid);
	$("#userborrado").val(usuario);
}