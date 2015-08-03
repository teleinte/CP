$(function() {
	$('#calendar').fullCalendar({
                header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,agendaWeek,agendaDay'
                },
                editable: true,
                eventLimit: true, // allow "more" link when too many events
                timezone: 'America/Bogota',
                businessHours: {
                        start: '6:00', // a start time (10am in this example)
                        end: '22:00', // an end time (6pm in this example)

                        dow: [ 0, 1, 2, 3, 4, 5, 6]
                        // days of week. an array of zero-based day of week integers (0=Sunday)
                        // (Monday-Thursday in this example)
                },
                defaultView: 'agendaWeek',
                aspectRatio: 1.5,
                eventClick:  function(event, jsEvent, view) {
                if(event.tipo=="tarea")
                {
	                $('#TareaContent').show();
	                $('#EventoContent').hide();
	                $("#startTime").html(moment(event.start).format('MMMM D, h:mm A'));
	            	$("#endTime").html(moment(event.end).format('MMMM D, h:mm A'));
	                $("#eventInfo").html(event.title);
	                $("#eventDesc").html(event.description);
	                $("#eventDeadline").html(event.deadline.split('COT')[0]);
	                $("#eventFrecuencia").html(event.frecuencia);
	                $("#btnr_editar_tarea").attr('nombre',event.title);
	                $("#btnr_editar_tarea").attr('estado',event.estado);
	                $("#btnr_editar_tarea").attr('deadline',event.deadline);
	                $("#btnr_editar_tarea").attr('frecuencia',event.frecuencia);
	                $("#btnr_editar_tarea").attr('notas',event.description);
	                $("#btnr_editar_tarea").attr('mongoid',event.id);
	                $("#btnr_editar_tarea").attr('creacion',event.creacion);
	                $("#btnr_eliminar_tarea").attr('mongoid',event.id);
	                $("#btnr_eliminar_tarea").attr('nombre',event.title);
	                $("#btnr_eliminar_tarea").attr('estado',event.estado);
	                $("#btnr_eliminar_tarea").attr('deadline',event.deadline);
	                $("#btnr_eliminar_tarea").attr('frecuencia',event.frecuencia);
	                $("#btnr_eliminar_tarea").attr('notas',event.description);
	                $("#btnr_eliminar_tarea").attr('mongoid',event.id);
	                $("#btnr_eliminar_tarea").attr('creacion',event.creacion);
	                $("#btnr_completar_tarea").attr('mongoid',event.id);
	                $("#btnr_completar_tarea").attr('nombre',event.title);
	                $("#btnr_completar_tarea").attr('estado',event.estado);
	                $("#btnr_completar_tarea").attr('deadline',event.deadline);
	                $("#btnr_completar_tarea").attr('frecuencia',event.frecuencia);
	                $("#btnr_completar_tarea").attr('notas',event.description);
	                $("#btnr_completar_tarea").attr('mongoid',event.id);
	                $("#btnr_completar_tarea").attr('creacion',event.creacion);
                }
	            if(event.tipo == "evento")
                {
                	$('#TareaContent').hide();
                	$('#EventoContent').show();
                	$("#ev_nombre").html(event.title);
                	$("#ev_fecha_inicio").html(event.finicio.split("T")[0] + " - " + event.finicio.split("T")[1].replace(":00+00:00",""));
                	$("#ev_fecha_fin").html(event.ffin.split("T")[0] + " - " + event.ffin.split("T")[1].replace(":00+00:00",""));
                	$("#ev_frecuencia").html(event.frecuencia);
                	$("#ev_cal_copropiedad").html(event.cal_copropiedad);
                	$("#ev_invitados").html(event.invitados);
                	$("#ev_otros").html(event.otros);
                	$("#ev_notas" ).html(event.description);
                	$("#ev_id").html(event.id);
	                $("#btnr_editar_evento").attr('mongoid',event.id);
                	$("#btnr_editar_evento").attr('nombre',event.title);
	                $("#btnr_editar_evento").attr('estado',event.estado);
	                $("#btnr_editar_evento").attr('inicio',event.finicio);
	                $("#btnr_editar_evento").attr('fin',event.ffin);
	                $("#btnr_editar_evento").attr('frecuencia',event.frecuencia);
	                $("#btnr_editar_evento").attr('notas',event.description);
	                $("#btnr_editar_evento").attr('cal_copropiedad',event.cal_copropiedad);
	                $("#btnr_editar_evento").attr('invitados',event.invitados);
	                $("#btnr_editar_evento").attr('otros',event.otros);
	                $("#btnr_editar_evento").attr('creacion',event.creacion);
	                $("#btnr_eliminar_evento").attr('mongoid',event.id);
                	$("#btnr_eliminar_evento").attr('nombre',event.title);
	                $("#btnr_eliminar_evento").attr('estado',event.estado);
	                $("#btnr_eliminar_evento").attr('inicio',event.finicio);
	                $("#btnr_eliminar_evento").attr('fin',event.ffin);
	                $("#btnr_eliminar_evento").attr('frecuencia',event.frecuencia);
	                $("#btnr_eliminar_evento").attr('notas',event.description);
	                $("#btnr_eliminar_evento").attr('cal_copropiedad',event.cal_copropiedad);
	                $("#btnr_eliminar_evento").attr('invitados',event.invitados);
	                $("#btnr_eliminar_evento").attr('otros',event.otros);
	                $("#btnr_eliminar_evento").attr('creacion',event.creacion);
                }

				$("#eventContent").dialog({ modal: true, width:400, title: obtenerTerminoLenguage('cl','16') });
		},
		selectable: true,
		selectHelper: true,
		lazyFetching: true,
		select: function(start, end) {
			var check = moment(start).format();
		    var today = moment().subtract(1,'days').format();
		    //console.warn(moment().subtract(1,'days').format());
		    if(check > today)
		    {
				$('#calEventDialog #eventStart').val(moment(start).format());
				sessionStorage.setItem('new-eventStart',moment(start).format());
				$('#calEventDialog #eventEnd').val(moment(end).format());
				sessionStorage.setItem('new-eventEnd',moment(end).format());

				if ($('#eventStart[value*="T00:00:00"]').length > 0 && $('#eventEnd[value*="T00:00:00"]').length > 0) {
					$('#calEventDialog #eventStart').val(moment(start).format('YYYY-MM-DD'));
					sessionStorage.setItem('new-eventStart',moment(start).format('YYYY-MM-DD'));
					$('#calEventDialog #eventEnd').val(moment(end).format('YYYY-MM-DD'));
					sessionStorage.setItem('new-eventEnd',moment(end).format('YYYY-MM-DD'));
				}

				startdate = moment(start).format();
				enddate = moment(end).format();
				if(enddate == null)
					enddate = startdate;
				$("#datepicker2").val(startdate.split("T")[0]);
				$("#datepicker3").val(startdate.split("T")[0]);
				$("#datepicker4").val(enddate.split("T")[0]);
				$("#starttimee").val(startdate.split("T")[1].replace(":00+00:00",""));
				$("#endtimee").val(enddate.split("T")[1].replace(":00+00:00",""));
				$("#calEventDialog").dialog({ modal: true });
				$('#calEventDialog').dialog('open');
			}
		    else
		    {
		        $("#notavailable").dialog("open");
		    }
		  },
		eventSources: [
			{
				events: function(start, end, timezone, callback){
					var rutaAplicativo = traerDireccion()+"api/tareas/getlist";  
					var arr = { token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp'),tipo:"tarea"}};
					//var data = JSON.stringify(arr);
					$.post(rutaAplicativo, JSON.stringify(arr))
					        .done(function(msg){
					        	var tareasCalendario = [];
					            var msgDividido = JSON.stringify(msg);
					            var mensaje =  JSON.parse(msgDividido);
					            var msgDivididoDos = JSON.stringify(mensaje.message);
					            var datos = JSON.parse(msgDivididoDos);                
					            if (datos=="Token invalido")
					            {
					                $('#alertas').html('<div class="alert alert-dismissable alert-error" teid="ale:html:12"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:1"></strong></div>')
					                $(document).renderme('cl');                  
					                window.location = '../index.php';
					            }
					            else
					            {
					            	if(!$.isEmptyObject(datos))
					                $.each(datos, function(x , y) 
					                {
                                        tareasCalendario.push({
					                        title: y['nombre'],
					                        description: y['notas'],
					                        start: (y['deadline']).split("COT")[0],
					                        end: y['deadline'],
					                        deadline: y['deadline'],
					                        frecuencia: y['frecuencia'],
					                        estado: y['estado'],
					                        id: y['_id']['$id'],
					                        creacion:y['fecha_creacion'],
					                        tipo:"tarea",
					                        className: "verde"
					                    });
					                })
					            }
					            callback(tareasCalendario);
					        });
					}
			},
			{
				events: function(start, end, timezone, callback){
					var rutaAplicativo = traerDireccion()+"api/eventos/getevento/";  
					var arr = { token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp'),tipo:"evento"}};
					//var data = JSON.stringify(arr);
					$.post(rutaAplicativo, JSON.stringify(arr))
					        .done(function(msg){
					        	var eventosCalendario = [];
					            var msgDividido = JSON.stringify(msg);
					            var mensaje =  JSON.parse(msgDividido);
					            var msgDivididoDos = JSON.stringify(mensaje.message);
					            var datos2 = JSON.parse(msgDivididoDos);                
					            if (datos2=="Token invalido")
					            {
					                $('#alertas').html('<div class="alert alert-dismissable alert-error" teid="ale:html:12"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:1"></strong>.</div>')
					                $(document).renderme('cl');                  
					                window.location = '../index.php';
					            }
					            else
					            {	
					            	if(!$.isEmptyObject(datos2))
				            		$.each(datos2, function(x , y) 
				            		{
				            			var inicio = (y['fecha_inicio']).split("T")[0] + "T" + (y['fecha_inicio']).split("T")[1];
				            			var fin = (y['fecha_fin']).split("T")[0] + "T" + (y['fecha_fin']).split("T")[1];
				            			
				            		    eventosCalendario.push({
				            		        title: y['nombre'],
				            		        creacion: y['fecha_creacion'],
				            		        description: y['notas'],
				            		        start: inicio,
				            		        end: fin,
				            		        finicio: inicio,
				            		        ffin: fin,
				            		        frecuencia: y['frecuencia'],
				            		        cal_copropiedad: y['cal_copropiedad'],
				            		        estado: y['estado'],
				            		        id: y['_id']['$id'],
				            		        tipo: "evento",
				            		        invitados: y['compartir_invitados'],
				            		        otros: y['compartir_otros'],
				            		        className: "naranja"
				            		    });
				            		})
					            }
					            callback(eventosCalendario);
					        });
					}
			},
			{
				events: function(start, end, timezone, callback){
					var rutaAplicativo = traerDireccion()+"api/eventos/geteventocop/";  
					var arr = { token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp'),tipo:"evento"}};
					//var data = JSON.stringify(arr);
					$.post(rutaAplicativo, JSON.stringify(arr))
					        .done(function(msg){
					        	var eventosCalendarioCo = [];
					            var msgDividido = JSON.stringify(msg);
					            var mensaje =  JSON.parse(msgDividido);
					            var msgDivididoDos = JSON.stringify(mensaje.message);
					            var datos3 = JSON.parse(msgDivididoDos);                
					            if (datos3=="Token invalido")
					            {
					                $('#alertas').html('<div class="alert alert-dismissable alert-error"  teid="ale:html:12"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:1"></strong></div>')
					                $(document).renderme('cl');                  
					                window.location = '../index.php';
					            }
					            else
					            {	
					            	if(!$.isEmptyObject(datos3))
				            		$.each(datos3, function(x , y) 
				            		{
				            			var inicio = (y['fecha_inicio']).split("T")[0] + "T" + (y['fecha_inicio']).split("T")[1];
				            			var fin = (y['fecha_fin']).split("T")[0] + "T" + (y['fecha_fin']).split("T")[1];
				            		    eventosCalendarioCo.push({
				            		        title: y['nombre'],
				            		        creacion: y['fecha_creacion'],
				            		        description: y['notas'],
				            		        start: inicio,
				            		        end: fin,
				            		        finicio: inicio,
				            		        ffin: fin,
				            		        frecuencia: y['frecuencia'],
				            		        cal_copropiedad: y['cal_copropiedad'],
				            		        estado: y['estado'],
				            		        id: y['_id']['$id'],
				            		        tipo: "evento",
				            		        invitados: y['compartir_invitados'],
				            		        otros: y['compartir_otros'],
				            		        className: "rojo"
				            		    });
				            		})
					            }
					            callback(eventosCalendarioCo);
					        });
					}
			}
		],
		editable: true,
	    eventResize: function(event, delta, revertFunc) {
	      	$("#eventResizeName").html(event.title);
	      	$("#eventResizeDate").html(event.end.format('DD-MM-YYYY'));
	      	$('#eventResizeTime').html(event.end.format('HH:mm'));
	      	$('#eventResizeFullDate').val(event.end.format());
      		$("#rev_nombre").val(event.title);
        	$("#rev_fecha_creacion").val(event.fecha_creacion);
        	$("#rev_fecha_inicio").val(event.finicio);
        	$("#rev_fecha_fin").val(event.end.format());
        	if(event.frecuencia.length > 2){$("#rev_frecuencia").val(event.frecuencia);}else{$("#rev_frecuencia").val("Ninguna");}
        	$("#rev_cal_copropiedad").val(event.cal_copropiedad);
        	$("#rev_invitados").val(event.invitados);
        	$("#rev_otros").val(event.otros);
        	$("#rev_notas" ).val(event.description);
        	$("#rev_id").val(event.id);
	      	$('#calEventDialogResize').dialog({ modal: true });
	      	$('#calEventDialogResize').dialog('open');
	      	revertFunc();
	    },
	    eventDrop: function(event, delta, revertFunc) {
	    	$("#eventDropName").html(event.title);
            $("#eventDropStartDate").html(event.start.format('DD-MM-YYYY'));
            $('#eventDropStartTime').html(event.start.format('HH:mm'));
	    	if(event.tipo == "evento")
	    	{
	    		$(document).renderme('tar');
	            $("#eventDropEndDate").html(event.end.format('DD-MM-YYYY'));
	            $('#eventDropEndTime').html(event.end.format('HH:mm'));
	            $('#eventResizeFullStartDate').val(event.start.format());
	            $('#eventResizeFullEndDate').val(event.end.format());
	      		$("#rev_nombre").val(event.title);
            	$("#rev_fecha_creacion").val(event.creacion);
            	$("#rev_fecha_inicio").val(event.start.format());
            	$("#rev_fecha_fin").val(event.end.format());
            	$("#rev_frecuencia").val(event.frecuencia);
            	$("#rev_cal_copropiedad").val(event.cal_copropiedad);
            	$("#rev_invitados").val(event.invitados);
            	$("#rev_otros").val(event.otros);
            	$("#rev_notas" ).val(event.description);
            	$("#rev_id").val(event.id);
            	$('#calEventDialogDrop').dialog({ modal: true });
            	$('#calEventDialogDrop').dialog('open');
            	$(document).renderme('tar');
	    	}
	    	else
	    	{
	    		$(document).renderme('tar');
	    		$('#calEventTaskDialogDrop').dialog({ modal: true });
	            $('#calEventTaskDialogDrop').dialog('open');
	            revertFunc();
	            $(document).renderme('tar');
	    	}
        }
	});
	var title = $('#eventTitle');
	var start = $('#eventStart');
	var end = $('#eventEnd');

	$('#calEventDialog').dialog({
		resizable: false,
		autoOpen: false,
		width: 400,
		title: obtenerTerminoLenguage('cl','35'),
		buttons:{
			"Crear evento" : function(){
				window.location="crear-evento.php";
			},
			"Crear tarea" : function(){
				window.location="crear-tarea.php";
				sessionStorage.setItem('referer','../calendario');
			},
			"Cancelar" : function(){
				$(this).dialog("close");
			}
		}
	});

	$('#notavailable').dialog({
		resizable: false,
		autoOpen: false,
		width: 400,
		modal: true,
		title: obtenerTerminoLenguage('cl','88'),
		buttons:{
			"Aceptar" : function(){
				$(this).dialog("close");
			}
		}
	});

	$('#calEventDialogResize').dialog({
		resizable: false,
		autoOpen: false,
		width: 250,
		title: obtenerTerminoLenguage('cl','85'),
		close: function(event, ui) {$(this).dialog('destroy');},
		buttons: {
			Cancelar: function() {
				$(this).dialog('close');
				location.reload();
			},
			Aceptar: function() {
	      	 	eventoEdit($("#rev_id").val(),$("#rev_fecha_creacion").val(),$("#rev_nombre").val(),$("#rev_fecha_inicio").val(),$("#rev_fecha_fin").val(),$("#rev_invitados").val(),$("#rev_otros").val(),$("#rev_frecuencia").val(),$("#rev_cal_copropiedad").val(),$("#rev_notas" ).val());
	      	 	//$('#calendar').fullCalendar('rerenderEvents');
	      	 	$(this).dialog('close');
			}
			
		}
	});

	$('#calEventDialogDrop').dialog({
		resizable: false,
		autoOpen: false,
		width: 250,
		title: obtenerTerminoLenguage('cl','85'),
		close: function(event, ui) {$(this).dialog('destroy');},
		buttons: {
			Cancelar: function() {
	      		$(this).dialog('close');
	      		location.reload();
			},
			Aceptar: function() {
	      	 	eventoEdit($("#rev_id").val(),$("#rev_fecha_creacion").val(),$("#rev_nombre").val(),$("#rev_fecha_inicio").val(),$("#rev_fecha_fin").val(),$("#rev_invitados").val(),$("#rev_otros").val(),$("#rev_frecuencia").val(),$("#rev_cal_copropiedad").val(),$("#rev_notas" ).val());
	      	 	//$('#calendar').fullCalendar('rerenderEvents');
	      	 	$(this).dialog('close');
			}
		}
	});

	$('#calEventTaskDialogDrop').dialog({
		resizable: false,
		autoOpen: false,
		width: 250,
		title: obtenerTerminoLenguage('cl','83'),
		//close: function(event, ui) {$(this).dialog('destroy');},
		buttons: {
			Aceptar: function() {
				//$('#calendar').fullCalendar('rerenderEvents');
				window.location = "index.php";
	      	 	$(this).dialog('close');
			}
		}
	});
	$(document).renderme('tar');

	var d = new Date();
	var mes=d.getMonth()+1;

	$(".ui-dialog-content").css('display','none');
	$(".ui-dialog-buttonpane").css('border','none');

	$("#btnr_editar_tarea").click(function(){
		var elem = 
		{
			id:$(this).attr('mongoid'),
			fecha_creacion:$(this).attr('creacion'),
			tipo:"tarea",
			nombre:$(this).attr('nombre'),
			estado:$(this).attr('estado'),
			deadline:$(this).attr('deadline'),
			notas:$(this).attr('notas'),
			frecuencia:$(this).attr('frecuencia')
		}
		sessionStorage.setItem('acelem',JSON.stringify(elem));
		sessionStorage.setItem('referer','../calendario');
		window.location = "editar-tarea.php";
	});

	$("#btnr_editar_evento").click(function(){
		var elem = 
		{
			id:$(this).attr('mongoid'),
			fecha_creacion:$(this).attr('creacion'),
			tipo:"evento",
			nombre:$(this).attr('nombre'),
			estado:$(this).attr('estado'),
			fecha_inicio:$(this).attr('inicio'),
			fecha_fin:$(this).attr('fin'),
			compartir_invitados:$(this).attr('invitados'),
			compartir_otros:$(this).attr('otros'),
			frecuencia:$(this).attr('frecuencia'),
			cal_copropiedad:$(this).attr('cal_copropiedad'),
			notas:$(this).attr('notas')
		}
		sessionStorage.setItem('acelem',JSON.stringify(elem));
		window.location = "editar-evento.php";
	});

	$("#btnr_editar_tarea").click(function(){window.location="editar-tarea.php"});
	$("#btnr_eliminar_tarea").click(function(){
		sessionStorage.setItem('referer','../calendario');
		tareaDelete($(this).attr('mongoid'),$(this).attr('creacion'),$(this).attr('nombre'),$(this).attr('deadline'),$(this).attr('frecuencia'),$(this).attr('notas'));
	});

	$("#btnr_completar_tarea").click(function(){
		sessionStorage.setItem('referer','../calendario');
		tareaCompletar($(this).attr('mongoid'),$(this).attr('creacion'),$(this).attr('nombre'),$(this).attr('deadline'),$(this).attr('frecuencia'),$(this).attr('notas'));
	});

	$("#btnr_editar_evento").click(function(){window.location="editar-evento.php"});

	/*$("#btnr_eliminar_evento").click(function(){
		eventoDelete($(this).attr('mongoid'),$(this).attr('creacion'),$(this).attr('nombre'),$(this).attr('inicio'),$(this).attr('fin'),$(this).attr('invitados'),$(this).attr('otros'),$(this).attr('frecuencia'),$(this).attr('cal_copropiedad'),$(this).attr('notas'));
	});*/

	$(document).renderme('cl');
});