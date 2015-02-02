	$(document).ready(function() {
		//var arr = { token:sessionStorage.getItem('token'),body:{id_copropiedad:parseInt(sessionStorage.getItem('cp')),tipo:"tarea"}};
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
				start: '8:00', // a start time (10am in this example)
				end: '18:00', // an end time (6pm in this example)
			
				dow: [ 1, 2, 3, 4, 5 ]
				// days of week. an array of zero-based day of week integers (0=Sunday)
				// (Monday-Thursday in this example)
			},
			defaultView: 'agendaWeek',
			aspectRatio: 1.5,
			eventClick:  function(event, jsEvent, view) {
				//set the values and open the modal
				$("#startTime").html(moment(event.start).format('MMMM D, h:mm A'));
            	$("#endTime").html(moment(event.end).format('MMMM D, h:mm A'));
				$("#eventInfo").html(event.title);
				$("#eventDesc").html(event.description);
                $("#eventPrioridad").html(event.prioridad);
                $("#eventDeadline").html(event.deadline);
                $("#eventFrecuencia").html(event.frecuencia);
                $("#eventFechaRecordatorio").html(event.recordatorio);
                $("#eventRecordatorioCP").html(event.cp_recordatorio);
                $("#eventRecordatorioMail").html(event.mail_recordatorio);
                $("#eventResponsable").html(event.responsable);
                $("#eventCompartida").html(event.compartida);
                $("#eli_nombre").val(event.title);
                $("#eli_estado").val(event.estado);
                $("#eli_responsable").val(event.responsable);
                $("#eli_prioridad").val(event.prioridad);
                $("#eli_datepicker2").val(event.deadline);
                $("#eli_compartir_mail").val(event.compartida);
                $("#eli_frecuencia").val(event.frecuencia);
                $("#eli_datepicker").val(event.recordatorio);
                $("#eli_recordatorio_mail").val(event.mail_recordatorio);
                $("#eli_recordatorio_cp").val(event.cp_recordatorio);
                $("#eli_notas").val(event.description);
                $("#eli_id").val(event.id);
                $("#btn_editar_tarea").attr("href","../tarea/tarea-editar.php?idt=" + event.id);
                sessionStorage.setItem("referer","../calendario");
                $("#com_nombre").val(event.title);
                $("#com_estado").val(event.estado);
                $("#com_responsable").val(event.responsable);
                $("#com_prioridad").val(event.prioridad);
                $("#com_datepicker2").val(event.deadline);
                $("#com_compartir_mail").val(event.compartida);
                $("#com_frecuencia").val(event.frecuencia);
                $("#com_datepicker").val(event.recordatorio);
                $("#com_recordatorio_mail").val(event.mail_recordatorio);
                $("#com_recordatorio_cp").val(event.cp_recordatorio);
                $("#com_notas" ).val(event.description);
                $("#com_id").val(event.id);
                if(event.tipo == "evento")
                {
                	$('#TareaContent').hide();
                	$('#EventoContent').show();
                	$("#ev_nombre").html(event.title);
                	$("#ev_fecha_creacion").html(event.fecha_creacion);
                	$("#ev_fecha_inicio").html(event.finicio.split("T")[0] + " - " + event.finicio.split("T")[1].replace(":00+00:00",""));
                	$("#ev_fecha_fin").html(event.ffin.split("T")[0] + " - " + event.ffin.split("T")[1].replace(":00+00:00",""));
                	$("#ev_frecuencia").html(event.frecuencia);
                	$("#ev_cal_copropiedad").html(event.cal_copropiedad);
                	$("#ev_recordatorio").html(event.recordatorio);
                	$("#ev_recordatorio_cp").html(event.cp_recordatorio);
                	$("#ev_recordatorio_mail").html(event.mail_recordatorio);
                	$("#ev_compartir_mail").html(event.compartida);
                	$("#ev_notas" ).html(event.description);
                	$("#ev_id").html(event.id);
                	$("#btn_editar_evento").attr("href","../evento/evento-editar.php?idt=" + event.id);
                	sessionStorage.setItem("referer","../calendario");
                	$("#eev_nombre").val(event.title);
                	$("#eev_fecha_creacion").val(event.fecha_creacion);
                	$("#eev_fecha_inicio").val(event.finicio);
                	$("#eev_fecha_fin").val(event.ffin);
                	$("#eev_frecuencia").val(event.frecuencia);
                	$("#eev_cal_copropiedad").val(event.cal_copropiedad);
                	$("#eev_frecordatorio").val(event.recordatorio);
                	$("#eev_recordatorio_cp").val(event.cp_recordatorio);
                	$("#eev_recordatorio_mail").val(event.mail_recordatorio);
                	$("#eev_compartir_mail").val(event.compartida);
                	$("#eev_notas" ).val(event.description);
                	$("#eev_id").val(event.id);
                }
                else
                {
                	$('#TareaContent').show();
                	$('#EventoContent').hide();
                }

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
				if(enddate == null)
					enddate = startdate;
				$("#datepicker2").val(startdate.split("T")[0]);
				$("#datepicker3").val(startdate.split("T")[0]);
				$("#datepicker4").val(enddate.split("T")[0]);
				$("#starttimee").val(startdate.split("T")[1].replace(":00+00:00",""));
				$("#endtimee").val(enddate.split("T")[1].replace(":00+00:00",""));
				$("#calEventDialog").dialog({ modal: true });
				$('#calEventDialog').dialog('open');
			},
			eventSources: [
				{
					events: function(start, end, timezone, callback){
						const rutaAplicativo = "http://aws02.sinfo.co/api/tareas/getlist";  
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
						                $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>')                  
						                window.location = '../index.html';
						            }
						            else
						            {
						            	if(!$.isEmptyObject(datos))
						                $.each(datos, function(x , y) 
						                {
						                	var cp_recor = "NO";
						                	var mail_recor = "NO";
						                	var frec = "";
						                	if(y['recordatorio_cp']){cp_recor="SI"}
						                	if(y['recordatorio_mail']){mail_recor="SI"}
						                	if(y['frecuencia'].length < 2){frec="Ninguna"}
						                    tareasCalendario.push({
						                        title: y['nombre'],
						                        description: y['notas'],
						                        start: (y['fecha_creacion']).split("T")[0],
						                        end: y['deadline'],
						                        prioridad: y['prioridad'],
						                        deadline: y['deadline'],
						                        frecuencia: frec,
						                        recordatorio: y['frecordatorio'],
						                        cp_recordatorio: cp_recor,
						                        mail_recordatorio: mail_recor,
						                        responsable: y['responsable'],
						                        estado: y['estado'],
						                        id: y['_id']['$id'],
						                        compartida: y['compartir_mail'],
						                        compartida: "tarea",
						                        //className: "destacado"
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
						const rutaAplicativo = "http://aws02.sinfo.co/api/eventos/getevento/";  
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
						                $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>')                  
						                window.location = '../index.html';
						            }
						            else
						            {	
						            	if(!$.isEmptyObject(datos2))
					            		$.each(datos2, function(x , y) 
					            		{
					            			var inicio = (y['fecha_inicio']).split("T")[0] + "T" + (y['fecha_inicio']).split("T")[1];
					            			var fin = (y['fecha_fin']).split("T")[0] + "T" + (y['fecha_fin']).split("T")[1];
					            			var cp_recor = "NO";
					            			var mail_recor = "NO";
					            			var cal_cop = "NO";
					            			var frec = "";
					            			if(y['recordatorio_cp']){cp_recor="SI"}
					            			if(y['recordatorio_mail']){mail_recor="SI"}
					            			if(y['cal_copropiedad']){cal_cop="SI"}else{cal_cop="NO"}
					            			if(y['frecuencia'].length < 2){frec="Ninguna"}
					            		    eventosCalendario.push({
					            		        title: y['nombre'],
					            		        fecha_creacion: y['fecha_creacion'],
					            		        description: y['notas'],
					            		        start: inicio,
					            		        end: fin,
					            		        finicio: inicio,
					            		        ffin: fin,
					            		        frecuencia: frec,
					            		        recordatorio: y['frecordatorio'],
					            		        cp_recordatorio: cp_recor,
					            		        mail_recordatorio: mail_recor,
					            		        cal_copropiedad: cal_cop,
					            		        estado: y['estado'],
					            		        id: y['_id']['$id'],
					            		        tipo: "evento",
					            		        compartida: y['compartir_mail'],
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
						const rutaAplicativo = "http://aws02.sinfo.co/api/eventos/geteventocop/";  
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
						                $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>')                  
						                window.location = '../index.html';
						            }
						            else
						            {	
						            	if(!$.isEmptyObject(datos3))
					            		$.each(datos3, function(x , y) 
					            		{
					            			var inicio = (y['fecha_inicio']).split("T")[0] + "T" + (y['fecha_inicio']).split("T")[1];
					            			var fin = (y['fecha_fin']).split("T")[0] + "T" + (y['fecha_fin']).split("T")[1];
					            			var cp_recor = "NO";
					            			var mail_recor = "NO";
					            			var cal_cop = "NO";
					            			var frec = "";
					            			if(y['recordatorio_cp']){cp_recor="SI"}else{cp_recor="NO"}
					            			if(y['recordatorio_mail']){mail_recor="SI"}else{mail_recor="NO"}
					            			if(y['cal_copropiedad']){cal_cop="SI"}else{cal_cop="NO"}
					            			if(y['frecuencia'].length < 2){frec="Ninguna"}
					            		    eventosCalendarioCo.push({
					            		        title: y['nombre'],
					            		        fecha_creacion: y['fecha_creacion'],
					            		        description: y['notas'],
					            		        start: inicio,
					            		        end: fin,
					            		        finicio: inicio,
					            		        ffin: fin,
					            		        frecuencia: frec,
					            		        recordatorio: y['frecordatorio'],
					            		        cp_recordatorio: cp_recor,
					            		        mail_recordatorio: mail_recor,
					            		        cal_copropiedad: cal_cop,
					            		        estado: y['estado'],
					            		        id: y['_id']['$id'],
					            		        tipo: "evento",
					            		        compartida: y['compartir_mail'],
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
            	$("#rev_frecordatorio").val(event.recordatorio);
            	$("#rev_recordatorio_cp").val(event.cp_recordatorio);
            	$("#rev_recordatorio_mail").val(event.mail_recordatorio);
            	$("#rev_compartir_mail").val(event.compartida);
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
		            $("#eventDropEndDate").html(event.end.format('DD-MM-YYYY'));
		            $('#eventDropEndTime').html(event.end.format('HH:mm'));
		            $('#eventResizeFullStartDate').val(event.start.format());
		            $('#eventResizeFullEndDate').val(event.end.format());
		      		$("#rev_nombre").val(event.title);
	            	$("#rev_fecha_creacion").val(event.fecha_creacion);
	            	$("#rev_fecha_inicio").val(event.start.format());
	            	$("#rev_fecha_fin").val(event.end.format());
	            	if(event.frecuencia.length > 2){$("#rev_frecuencia").val(event.frecuencia);}else{$("#rev_frecuencia").val("Ninguna");}
	            	$("#rev_cal_copropiedad").val(event.cal_copropiedad);
	            	$("#rev_frecordatorio").val(event.recordatorio);
	            	$("#rev_recordatorio_cp").val(event.cp_recordatorio);
	            	$("#rev_recordatorio_mail").val(event.mail_recordatorio);
	            	$("#rev_compartir_mail").val(event.compartida);
	            	$("#rev_notas" ).val(event.description);
	            	$("#rev_id").val(event.id);
	            	$('#calEventDialogDrop').dialog({ modal: true });
	            	$('#calEventDialogDrop').dialog('open');
		    	}
		    	else
		    	{
		    		$('#calEventTaskDialogDrop').dialog({ modal: true });
		            $('#calEventTaskDialogDrop').dialog('open');
		            revertFunc();
		    	}
	        }
		});
		var title = $('#eventTitle');
		var start = $('#eventStart');
		var end = $('#eventEnd');
		$('#calEventDialog').dialog({
			resizable: false,
			autoOpen: false,
			width: 500,
			title: 'Crear Evento o Tarea'
		});
		$('#calEventDialogResize').dialog({
			resizable: false,
			autoOpen: false,
			width: 250,
			title: 'Modificación',
			buttons: {
				Aceptar: function() {
		      	 	eventoEdit();
		      	 	//$('#calendar').fullCalendar('rerenderEvents');
		      	 	$(this).dialog('close');
				},
				Cancelar: function() {
		      		$(this).dialog('close');
				}
			}
		});
		$('#calEventDialogDrop').dialog({
			resizable: false,
			autoOpen: false,
			width: 250,
			title: 'Crear Evento o Tarea',
			buttons: {
				Aceptar: function() {
		      	 	eventoEdit();
		      	 	//$('#calendar').fullCalendar('rerenderEvents');
		      	 	$(this).dialog('close');
				},
				Cancelar: function() {
		      		$(this).dialog('close');
				}
			}

		});
		$('#calEventTaskDialogDrop').dialog({
			resizable: false,
			autoOpen: false,
			width: 250,
			title: 'Modificación',
			buttons: {
				Aceptar: function() {
					//$('#calendar').fullCalendar('rerenderEvents');
		      	 	$(this).dialog('close');
				}
			}
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