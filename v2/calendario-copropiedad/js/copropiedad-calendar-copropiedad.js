	$(document).ready(function() {
		$('#preloader').hide();
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			editable: false,
			eventLimit: true,
			timezone: 'America/Bogota',
			businessHours: {
				start: '8:00',
				end: '18:00',
				dow: [ 1, 2, 3, 4, 5 ]
			},
			defaultView: 'agendaWeek',
			aspectRatio: 1.5,
			eventClick:  function(event, jsEvent, view) {
				$("#ev_fecha_inicio").html(moment(event.start).format('MMMM D, h:mm A'));
            	$("#endTime").html(moment(event.end).format('MMMM D, h:mm A'));
				$("#ev_nombre").html(event.title);
				$("#eventDesc").html(event.description);
                $("#eventPrioridad").html(event.prioridad);
                $("#eventDeadline").html(event.deadline);
				$("#eventContent").dialog({ modal: true, width:400 });
			},
			selectable: false,
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
						const rutaAplicativo = "http://aws02.sinfo.co/api/eventos/geteventocop/";  
						var arr = { token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp'),tipo:"evento"}};
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
					            			if(y['recordatorio_cp']){cp_recor="SI"}
					            			if(y['recordatorio_mail']){mail_recor="SI"}
					            			if(y['cal_copropiedad'] == true || y['cal_copropiedad'] == "SI"){cal_cop="SI"}else{cal_cop="NO"}
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
			]
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
	        cal_copropiedad:$('#rev_cal_copropiedad').val(),
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