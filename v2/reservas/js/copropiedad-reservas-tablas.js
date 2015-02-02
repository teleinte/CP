$(document).ready(function() {
	obtenerInmuebles();
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

	//if(sessionStorage.getItem("reservaFechaRequerida") === null)
		sessionStorage.setItem("reservaFechaRequerida",d);
	//if(sessionStorage.getItem("reservaFechaRequeridaInicio") === null)
		sessionStorage.setItem("reservaFechaRequeridaInicio",inicio);
	//if(sessionStorage.getItem("reservaFechaRequeridaFin") === null)
		sessionStorage.setItem("reservaFechaRequeridaFin",fin);

	if(sessionStorage.getItem("reservaInmueble_id") !== null)
	$.each(JSON.parse(sessionStorage.getItem("inmueblesReservables")), function(x , y) 
	{
		if(y["id_inmueble"] == sessionStorage.getItem("reservaInmueble_id"))
		{
			$("#reserva-title").html("<h2>Reservas para " + sessionStorage.getItem("reservaInmueble_text") + "</h2>");
			$("#fechareservainicio").val(inicio);
			$("#fechareservafin").val(fin);
		}
		else if(sessionStorage.getItem("reservaInmueble_id").indexOf("Zonas ") == 0)
		{
			$("#reserva-title").html("<h2>Reservas para " + sessionStorage.getItem("reservaInmueble_text") + "</h2>");
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
	    "buttonText": "Columnas",
	    exclude: [ 0, 2, 3, 6 ]
	  },
	  "language": {
	    "sProcessing":     "Procesando...",
	    "sLengthMenu":     "Mostrar _MENU_ registros",
	    "sZeroRecords":    "No se encontraron resultados",
	    "sEmptyTable":     "Ningún dato disponible en esta tabla",
	    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
	    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
	    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
	    "sInfoPostFix":    "",
	    "sSearch":         "Buscar:",
	    "sUrl":            "",
	    "sInfoThousands":  ",",
	    "sLoadingRecords": "Cargando...",
	    "oPaginate": {
	      "sFirst":    "Primero",
	      "sLast":     "Último",
	      "sNext":     "Siguiente",
	      "sPrevious": "Anterior"
	    },
	    "oAria": {
	      "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
	      "sSortDescending": ": Activar para ordenar la columna de manera descendente"
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
		title: 'Modificación de reserva'
	});

	$('#reservaBorrar').dialog({
		resizable: false,
		autoOpen: false,
		title: 'Borrado de reserva'
	});

	popularReservas();
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

function popularReservas()
{
	var rutaAplicativo = "http://aws02.sinfo.co/api/reservas/reservas/listar/inmueble/fecha/";
	if(sessionStorage.getItem("reservaInmueble_id") !== null)
	{
		if(sessionStorage.getItem("reservaInmueble_id").indexOf("Zonas ") != 0)
		{
			rutaAplicativo = "http://aws02.sinfo.co/api/reservas/reservas/listar/inmueble/fecha/"; 
			var arr = { token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp'),id_inmueble:sessionStorage.getItem("reservaInmueble_id"),fecha_fin:sessionStorage.getItem("reservaFechaRequeridaFin").split("T")[0],fecha_inicio:sessionStorage.getItem("reservaFechaRequeridaInicio").split("T")[0]}};
		}
		else
		{
			rutaAplicativo = "http://aws02.sinfo.co/api/reservas/reservas/listar/grupo/fecha/"; 
			var arr = { token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp'),grupo:sessionStorage.getItem("reservaInmueble_id"),fecha_fin:sessionStorage.getItem("reservaFechaRequeridaFin").split("T")[0],fecha_inicio:sessionStorage.getItem("reservaFechaRequeridaInicio").split("T")[0]} };
		}
		//var data = JSON.stringify(arr);
		$.post(rutaAplicativo, JSON.stringify(arr))
		        .done(function(msg){
		        	var reservasCalendario = [];
		            var msgDividido = JSON.stringify(msg);
		            var mensaje =  JSON.parse(msgDividido);
		            var msgDivididoDos = JSON.stringify(mensaje.message);
		            var datos = JSON.parse(msgDivididoDos);    
		            var nombresInmuebles = obtenerDatosInmuebles();    
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
		                    var idmongo= JSON.stringify(y['_id']);
		                    var idMongoFinal = JSON.parse(idmongo);
		                    var t = $('#listareservas').DataTable();
		                    var datestart = new Date(y['fecha_inicio'].replace("COT","T"));
		                    var dateend = new Date(y['fecha_fin'].replace("COT","T"));
		                    var datecreacion = new Date(y['fecha_creacion']).toISOString();
		                    var user = y['usuario'].split("|")[1];
		                    var comment = "";
		                    t.row.add(['',datestart.toLocaleString(),dateend.toLocaleString(),user,y['comentario'],'<input type="submit" class="btn editar solo inline btneditareserva" mongoid="'+idMongoFinal.$id+'" startdate="'+datestart+'" creaciondate="'+datecreacion+'" enddate="'+dateend+'" user="'+y['usuario']+'" comentario="'+y['comentario']+'" id_copropiedad="'+y['id_copropiedad']+'" id_inmueble="'+y['id_inmueble']+'" grupo="'+y['grupo']+'" estado="'+y['estado']+'" value=""/>  <input type="submit" class="btn borrar solo inline btnborrareserva" mongoid="'+idMongoFinal.$id+'" value=""/>']).draw();
		                })
		            }
		            $("#ddrecursos").val(sessionStorage.getItem("reservaInmueble_id"));

		            $(".btneditareserva").click(function(){
		            	crearPopupEdicion($(this).attr('mongoid'), $(this).attr('startdate'), $(this).attr('creaciondate'), $(this).attr('enddate'), $(this).attr('user'), $(this).attr('comentario'), $(this).attr('id_copropiedad'), $(this).attr('id_inmueble'), $(this).attr('grupo'), $(this).attr('estado'));
		            });

		            $(".btnborrareserva").click(function(){
		            	crearPopupBorrado($(this).attr('mongoid'));
		            });
		        });
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
	$("#grupo").val(grupo);
	$("#estado").val(estado);
	$("#startfecha").datepicker({ dateFormat: "yy-mm-dd" });
	$("#endfecha").datepicker({ dateFormat: "yy-mm-dd" });
	$("#startfecha").datepicker('disable');
	$("#endfecha").datepicker('disable');
	$("#startfecha").val(new Date(start).toISOString().split("T")[0]);
	$("#endfecha").val(new Date(end).toISOString().split("T")[0]);
	$("#starthora").val(new Date(start).toISOString().split("T")[1].replace(":00.000Z",""));
	$("#endhora").val(new Date(end).toISOString().split("T")[1].replace(":00.000Z",""));
	$("input").blur();
	$("#reservaEdit").dialog({ modal: true });
	$("#reservaEdit").dialog('open');
	$("#startfecha").datepicker('enable');
	$("#endfecha").datepicker('enable');
}

function crearPopupBorrado(mongoid)
{
	$("#reservaBorrar").dialog({ modal: true });
	$("#reservaBorrar").dialog('open');
	$("#mongoid").val(mongoid);
}