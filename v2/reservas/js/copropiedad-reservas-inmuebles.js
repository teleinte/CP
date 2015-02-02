$(document).ready(function(){
	$('#listainmuebles').DataTable({
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
	$('#inmuebleCrear').dialog({
		resizable: false,
		autoOpen: false,
		width:550,
		title: 'Crear politicas de reserva de inmueble'
	});
	$('#inmuebleEditar').dialog({
		resizable: false,
		autoOpen: false,
		width:550,
		title: 'Modificar politicas de reserva de inmueble'
	});
	$('#inmuebleBorrar').dialog({
		resizable: false,
		autoOpen: false,
		title: 'Borrar inmueble reservado'
	});
	$("input[name='treintas']").click(function() {
		var category = null;
	    if(this.value == "30")
	    {
	    	$("#hora_inicio_reserva").children().remove().end().append('<option value = "06">06:30</option> <option value = "07">07:30</option> <option value = "08">08:30</option> <option value = "09">09:30</option> <option value = "10">10:30</option> <option value = "11">11:30</option> <option value = "12">12:30</option> <option value = "13">13:30</option> <option value = "14">14:30</option> <option value = "15">15:30</option> <option value = "16">16:30</option> <option value = "17">17:30</option> <option value = "18">18:30</option> <option value = "19">19:30</option> <option value = "20">20:30</option> <option value = "21">21:30</option> <option value = "22">22:30</option> <option value = "23">23:30</option>'); 
	    	$("#hora_fin_reserva").children().remove().end().append('<option value = "06">06:30</option> <option value = "07">07:30</option> <option value = "08">08:30</option> <option value = "09">09:30</option> <option value = "10">10:30</option> <option value = "11">11:30</option> <option value = "12">12:30</option> <option value = "13">13:30</option> <option value = "14">14:30</option> <option value = "15">15:30</option> <option value = "16">16:30</option> <option value = "17">17:30</option> <option value = "18">18:30</option> <option value = "19">19:30</option> <option value = "20">20:30</option> <option value = "21">21:30</option> <option value = "22">22:30</option> <option value = "23">23:30</option>'); 
	    	$("#hora_inicio_restriccion").children().remove().end().append('<option value = "06">06:30</option> <option value = "07">07:30</option> <option value = "08">08:30</option> <option value = "09">09:30</option> <option value = "10">10:30</option> <option value = "11">11:30</option> <option value = "12">12:30</option> <option value = "13">13:30</option> <option value = "14">14:30</option> <option value = "15">15:30</option> <option value = "16">16:30</option> <option value = "17">17:30</option> <option value = "18">18:30</option> <option value = "19">19:30</option> <option value = "20">20:30</option> <option value = "21">21:30</option> <option value = "22">22:30</option> <option value = "23">23:30</option>'); 
	    	$("#hora_fin_restriccion").children().remove().end().append('<option value = "06">06:30</option> <option value = "07">07:30</option> <option value = "08">08:30</option> <option value = "09">09:30</option> <option value = "10">10:30</option> <option value = "11">11:30</option> <option value = "12">12:30</option> <option value = "13">13:30</option> <option value = "14">14:30</option> <option value = "15">15:30</option> <option value = "16">16:30</option> <option value = "17">17:30</option> <option value = "18">18:30</option> <option value = "19">19:30</option> <option value = "20">20:30</option> <option value = "21">21:30</option> <option value = "22">22:30</option> <option value = "23">23:30</option>'); 

	    	$("#edit_hora_inicio_reserva").children().remove().end().append('<option value = "06">06:30</option> <option value = "07">07:30</option> <option value = "08">08:30</option> <option value = "09">09:30</option> <option value = "10">10:30</option> <option value = "11">11:30</option> <option value = "12">12:30</option> <option value = "13">13:30</option> <option value = "14">14:30</option> <option value = "15">15:30</option> <option value = "16">16:30</option> <option value = "17">17:30</option> <option value = "18">18:30</option> <option value = "19">19:30</option> <option value = "20">20:30</option> <option value = "21">21:30</option> <option value = "22">22:30</option> <option value = "23">23:30</option>'); 
	    	$("#edit_hora_fin_reserva").children().remove().end().append('<option value = "06">06:30</option> <option value = "07">07:30</option> <option value = "08">08:30</option> <option value = "09">09:30</option> <option value = "10">10:30</option> <option value = "11">11:30</option> <option value = "12">12:30</option> <option value = "13">13:30</option> <option value = "14">14:30</option> <option value = "15">15:30</option> <option value = "16">16:30</option> <option value = "17">17:30</option> <option value = "18">18:30</option> <option value = "19">19:30</option> <option value = "20">20:30</option> <option value = "21">21:30</option> <option value = "22">22:30</option> <option value = "23">23:30</option>'); 
	    	$("#edit_hora_inicio_restriccion").children().remove().end().append('<option value = "06">06:30</option> <option value = "07">07:30</option> <option value = "08">08:30</option> <option value = "09">09:30</option> <option value = "10">10:30</option> <option value = "11">11:30</option> <option value = "12">12:30</option> <option value = "13">13:30</option> <option value = "14">14:30</option> <option value = "15">15:30</option> <option value = "16">16:30</option> <option value = "17">17:30</option> <option value = "18">18:30</option> <option value = "19">19:30</option> <option value = "20">20:30</option> <option value = "21">21:30</option> <option value = "22">22:30</option> <option value = "23">23:30</option>'); 
	    	$("#edit_hora_fin_restriccion").children().remove().end().append('<option value = "06">06:30</option> <option value = "07">07:30</option> <option value = "08">08:30</option> <option value = "09">09:30</option> <option value = "10">10:30</option> <option value = "11">11:30</option> <option value = "12">12:30</option> <option value = "13">13:30</option> <option value = "14">14:30</option> <option value = "15">15:30</option> <option value = "16">16:30</option> <option value = "17">17:30</option> <option value = "18">18:30</option> <option value = "19">19:30</option> <option value = "20">20:30</option> <option value = "21">21:30</option> <option value = "22">22:30</option> <option value = "23">23:30</option>'); 
	    }
	    if(this.value == "00")
	    {
	    	$("#hora_inicio_reserva").children().remove().end().append('<option value = "06">06:00</option> <option value = "07">07:00</option> <option value = "08">08:00</option> <option value = "09">09:00</option> <option value = "10">10:00</option> <option value = "11">11:00</option> <option value = "12">12:00</option> <option value = "13">13:00</option> <option value = "14">14:00</option> <option value = "15">15:00</option> <option value = "16">16:00</option> <option value = "17">17:00</option> <option value = "18">18:00</option> <option value = "19">19:00</option> <option value = "20">20:00</option> <option value = "21">21:00</option> <option value = "22">22:00</option> <option value = "23">23:00</option>'); 
	    	$("#hora_fin_reserva").children().remove().end().append('<option value = "06">06:00</option> <option value = "07">07:00</option> <option value = "08">08:00</option> <option value = "09">09:00</option> <option value = "10">10:00</option> <option value = "11">11:00</option> <option value = "12">12:00</option> <option value = "13">13:00</option> <option value = "14">14:00</option> <option value = "15">15:00</option> <option value = "16">16:00</option> <option value = "17">17:00</option> <option value = "18">18:00</option> <option value = "19">19:00</option> <option value = "20">20:00</option> <option value = "21">21:00</option> <option value = "22">22:00</option> <option value = "23">23:00</option>');
	    	$("#hora_inicio_restriccion").children().remove().end().append('<option value = "06">06:00</option> <option value = "07">07:00</option> <option value = "08">08:00</option> <option value = "09">09:00</option> <option value = "10">10:00</option> <option value = "11">11:00</option> <option value = "12">12:00</option> <option value = "13">13:00</option> <option value = "14">14:00</option> <option value = "15">15:00</option> <option value = "16">16:00</option> <option value = "17">17:00</option> <option value = "18">18:00</option> <option value = "19">19:00</option> <option value = "20">20:00</option> <option value = "21">21:00</option> <option value = "22">22:00</option> <option value = "23">23:00</option>');
	    	$("#hora_fin_restriccion").children().remove().end().append('<option value = "06">06:00</option> <option value = "07">07:00</option> <option value = "08">08:00</option> <option value = "09">09:00</option> <option value = "10">10:00</option> <option value = "11">11:00</option> <option value = "12">12:00</option> <option value = "13">13:00</option> <option value = "14">14:00</option> <option value = "15">15:00</option> <option value = "16">16:00</option> <option value = "17">17:00</option> <option value = "18">18:00</option> <option value = "19">19:00</option> <option value = "20">20:00</option> <option value = "21">21:00</option> <option value = "22">22:00</option> <option value = "23">23:00</option>');

	    	$("#edit_hora_inicio_reserva").children().remove().end().append('<option value = "06">06:00</option> <option value = "07">07:00</option> <option value = "08">08:00</option> <option value = "09">09:00</option> <option value = "10">10:00</option> <option value = "11">11:00</option> <option value = "12">12:00</option> <option value = "13">13:00</option> <option value = "14">14:00</option> <option value = "15">15:00</option> <option value = "16">16:00</option> <option value = "17">17:00</option> <option value = "18">18:00</option> <option value = "19">19:00</option> <option value = "20">20:00</option> <option value = "21">21:00</option> <option value = "22">22:00</option> <option value = "23">23:00</option>'); 
	    	$("#edit_hora_fin_reserva").children().remove().end().append('<option value = "06">06:00</option> <option value = "07">07:00</option> <option value = "08">08:00</option> <option value = "09">09:00</option> <option value = "10">10:00</option> <option value = "11">11:00</option> <option value = "12">12:00</option> <option value = "13">13:00</option> <option value = "14">14:00</option> <option value = "15">15:00</option> <option value = "16">16:00</option> <option value = "17">17:00</option> <option value = "18">18:00</option> <option value = "19">19:00</option> <option value = "20">20:00</option> <option value = "21">21:00</option> <option value = "22">22:00</option> <option value = "23">23:00</option>');
	    	$("#edit_hora_inicio_restriccion").children().remove().end().append('<option value = "06">06:00</option> <option value = "07">07:00</option> <option value = "08">08:00</option> <option value = "09">09:00</option> <option value = "10">10:00</option> <option value = "11">11:00</option> <option value = "12">12:00</option> <option value = "13">13:00</option> <option value = "14">14:00</option> <option value = "15">15:00</option> <option value = "16">16:00</option> <option value = "17">17:00</option> <option value = "18">18:00</option> <option value = "19">19:00</option> <option value = "20">20:00</option> <option value = "21">21:00</option> <option value = "22">22:00</option> <option value = "23">23:00</option>');
	    	$("#edit_hora_fin_restriccion").children().remove().end().append('<option value = "06">06:00</option> <option value = "07">07:00</option> <option value = "08">08:00</option> <option value = "09">09:00</option> <option value = "10">10:00</option> <option value = "11">11:00</option> <option value = "12">12:00</option> <option value = "13">13:00</option> <option value = "14">14:00</option> <option value = "15">15:00</option> <option value = "16">16:00</option> <option value = "17">17:00</option> <option value = "18">18:00</option> <option value = "19">19:00</option> <option value = "20">20:00</option> <option value = "21">21:00</option> <option value = "22">22:00</option> <option value = "23">23:00</option>');
	    }
	});
	$("input[name='edit_treintas']").click(function() {
		var category = null;
	    if(this.value == "30")
	    {
	    	$("#edit_hora_inicio_reserva").children().remove().end().append('<option value = "06">06:30</option> <option value = "07">07:30</option> <option value = "08">08:30</option> <option value = "09">09:30</option> <option value = "10">10:30</option> <option value = "11">11:30</option> <option value = "12">12:30</option> <option value = "13">13:30</option> <option value = "14">14:30</option> <option value = "15">15:30</option> <option value = "16">16:30</option> <option value = "17">17:30</option> <option value = "18">18:30</option> <option value = "19">19:30</option> <option value = "20">20:30</option> <option value = "21">21:30</option> <option value = "22">22:30</option> <option value = "23">23:30</option>'); 
	    	$("#edit_hora_fin_reserva").children().remove().end().append('<option value = "06">06:30</option> <option value = "07">07:30</option> <option value = "08">08:30</option> <option value = "09">09:30</option> <option value = "10">10:30</option> <option value = "11">11:30</option> <option value = "12">12:30</option> <option value = "13">13:30</option> <option value = "14">14:30</option> <option value = "15">15:30</option> <option value = "16">16:30</option> <option value = "17">17:30</option> <option value = "18">18:30</option> <option value = "19">19:30</option> <option value = "20">20:30</option> <option value = "21">21:30</option> <option value = "22">22:30</option> <option value = "23">23:30</option>'); 
	    	$("#edit_hora_inicio_restriccion").children().remove().end().append('<option value = "06">06:30</option> <option value = "07">07:30</option> <option value = "08">08:30</option> <option value = "09">09:30</option> <option value = "10">10:30</option> <option value = "11">11:30</option> <option value = "12">12:30</option> <option value = "13">13:30</option> <option value = "14">14:30</option> <option value = "15">15:30</option> <option value = "16">16:30</option> <option value = "17">17:30</option> <option value = "18">18:30</option> <option value = "19">19:30</option> <option value = "20">20:30</option> <option value = "21">21:30</option> <option value = "22">22:30</option> <option value = "23">23:30</option>'); 
	    	$("#edit_hora_fin_restriccion").children().remove().end().append('<option value = "06">06:30</option> <option value = "07">07:30</option> <option value = "08">08:30</option> <option value = "09">09:30</option> <option value = "10">10:30</option> <option value = "11">11:30</option> <option value = "12">12:30</option> <option value = "13">13:30</option> <option value = "14">14:30</option> <option value = "15">15:30</option> <option value = "16">16:30</option> <option value = "17">17:30</option> <option value = "18">18:30</option> <option value = "19">19:30</option> <option value = "20">20:30</option> <option value = "21">21:30</option> <option value = "22">22:30</option> <option value = "23">23:30</option>'); 
	    }
	    if(this.value == "00")
	    {
	    	$("#edit_hora_inicio_reserva").children().remove().end().append('<option value = "06">06:00</option> <option value = "07">07:00</option> <option value = "08">08:00</option> <option value = "09">09:00</option> <option value = "10">10:00</option> <option value = "11">11:00</option> <option value = "12">12:00</option> <option value = "13">13:00</option> <option value = "14">14:00</option> <option value = "15">15:00</option> <option value = "16">16:00</option> <option value = "17">17:00</option> <option value = "18">18:00</option> <option value = "19">19:00</option> <option value = "20">20:00</option> <option value = "21">21:00</option> <option value = "22">22:00</option> <option value = "23">23:00</option>'); 
	    	$("#edit_hora_fin_reserva").children().remove().end().append('<option value = "06">06:00</option> <option value = "07">07:00</option> <option value = "08">08:00</option> <option value = "09">09:00</option> <option value = "10">10:00</option> <option value = "11">11:00</option> <option value = "12">12:00</option> <option value = "13">13:00</option> <option value = "14">14:00</option> <option value = "15">15:00</option> <option value = "16">16:00</option> <option value = "17">17:00</option> <option value = "18">18:00</option> <option value = "19">19:00</option> <option value = "20">20:00</option> <option value = "21">21:00</option> <option value = "22">22:00</option> <option value = "23">23:00</option>');
	    	$("#edit_hora_inicio_restriccion").children().remove().end().append('<option value = "06">06:00</option> <option value = "07">07:00</option> <option value = "08">08:00</option> <option value = "09">09:00</option> <option value = "10">10:00</option> <option value = "11">11:00</option> <option value = "12">12:00</option> <option value = "13">13:00</option> <option value = "14">14:00</option> <option value = "15">15:00</option> <option value = "16">16:00</option> <option value = "17">17:00</option> <option value = "18">18:00</option> <option value = "19">19:00</option> <option value = "20">20:00</option> <option value = "21">21:00</option> <option value = "22">22:00</option> <option value = "23">23:00</option>');
	    	$("#edit_hora_fin_restriccion").children().remove().end().append('<option value = "06">06:00</option> <option value = "07">07:00</option> <option value = "08">08:00</option> <option value = "09">09:00</option> <option value = "10">10:00</option> <option value = "11">11:00</option> <option value = "12">12:00</option> <option value = "13">13:00</option> <option value = "14">14:00</option> <option value = "15">15:00</option> <option value = "16">16:00</option> <option value = "17">17:00</option> <option value = "18">18:00</option> <option value = "19">19:00</option> <option value = "20">20:00</option> <option value = "21">21:00</option> <option value = "22">22:00</option> <option value = "23">23:00</option>');
	    }
	});
	$("#btnagregarinmueble").click(function(){
		crearPopupCreacion();
	});
	popularInmueblesSelect();
	popularInmueblesTabla();
});

function popularInmueblesTabla()
{
	var rutaAplicativo = "http://aws02.sinfo.co/api/reservas/reservas/inmuebles/lista/";
	var arr = { token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp')}};
	$.post(rutaAplicativo, JSON.stringify(arr))
        .done(function(msg){
        	var reservasCalendario = [];
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
            	var days = ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"];
            	if(!$.isEmptyObject(datos))
                $.each(datos, function(x , y) 
                {
                    var idmongo= JSON.stringify(y['_id']);
                    var idMongoFinal = JSON.parse(idmongo);
                    var t = $('#listainmuebles').DataTable();
                    var name = y['nombre_despliegue'];
                    var grupo = y['grupo'];
                    var tiempo = y['tiempo_reserva'];
                    var inicio_reserva = y['hora_inicio_reserva'];
                    var fin_reserva = y['hora_fin_reserva'];
                    var dias = y['dias_reserva'];
                    var treintas = y['offset_inicio'];
                    dias = dias.split(",");
                    var dias_reserva =new Array();
                    for(i=0;i<=dias.length;i++){if(days[dias[i]] !== undefined)dias_reserva.push(days[dias[i]]);}
                    t.row.add(['',name,grupo,tiempo + " horas",inicio_reserva + ":" + treintas,fin_reserva + ":" + treintas,dias_reserva,'<input type="submit" class="btn editar solo inline btneditainmueble" mongoid="'+idMongoFinal.$id+'" id_copropiedad="'+y['id_copropiedad']+'" name="'+name+'" grupo="'+grupo+'" tiempo="'+tiempo+'" inicio="'+inicio_reserva+'" fin="'+fin_reserva+'" dias="'+dias+'" inicio_r="'+y['hora_inicio_restriccion']+'" fin_r="'+y['hora_fin_restriccion']+'" inmueble="'+y['id_inmueble']+'" offset="'+y['offset_inicio']+'" costo="'+y['valor_reserva']+'" value=""/>  <input type="submit" class="btn borrar solo inline btnborrainmueble" mongoid="'+idMongoFinal.$id+'" value=""/>']).draw();
                })
            }
            $(".btneditainmueble").click(function(){
            	crearPopupEdicion($(this).attr('mongoid'), $(this).attr('id_copropiedad'), $(this).attr('name'), $(this).attr('grupo'), $(this).attr('tiempo'), $(this).attr('inicio'), $(this).attr('fin'), $(this).attr('dias'), $(this).attr('inicio_r'), $(this).attr('fin_r'),$(this).attr('offset'), $(this).attr('costo'), $(this).attr('inmueble'));
            });

            $(".btnborrainmueble").click(function(){
            	crearPopupBorrado($(this).attr('mongoid'));
            });
        });
}

function popularInmueblesSelect()
{
	var rutaAplicativo = "http://aws02.sinfo.co/api/reservas/reservas/copropiedad/inmuebles/";
	var arr = { token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp')}};
	$.post(rutaAplicativo, JSON.stringify(arr))
        .done(function(msg){
        	var reservasCalendario = [];
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
                {
                	$.each(datos, function(x , y) 
                                {
                                    var tipounidad= y['tipo_unidad'];
                                    var identificador = y['identificador'];
                                    var id_inmueble = y['_id']["$id"];
                                    $("#inmueble").append('<option value="' + id_inmueble + '">' + identificador + " - " + tipounidad + "</option>");
                                })
                }
                else
                {
                	$('#btnagregarinmueble').attr('disabled','disabled');
                	$('#btnagregarinmueble').attr('style','display:none');
                }
            }
        });
}

function crearPopupEdicion(mongoid, idcopropiedad, name, grupo, tiempo, inicio, fin, dias, inicior, finr, offset, costo, inmueble)
{
	if(offset == "30")
		{$("#edit_treintas3").click();$("input:radio[id=edit_treintas3]").attr('checked', true);}
	else
		{$("#edit_treintas0").click();$("input:radio[id=edit_treintas0]").attr('checked', true);}
	console.log(offset);

	$("#edit_mongoid").val(mongoid);
	$("#edit_inmueble").val(mongoid);
	$("#edit_nombre_despliegue").val(name);
	$("#edit_tiempo_reserva").val(tiempo);
	$("#edit_hora_inicio_reserva").val(inicio);
	$("#edit_hora_fin_reserva").val(fin);
	$("#edit_hora_inicio_restriccion").val(inicior);
	$("#edit_hora_fin_restriccion").val(finr);
	$("#edit_grupo").val(grupo);
	console.log(dias);
	var days = ["domingo", "lunes", "martes", "miercoles", "jueves", "viernes", "sabado"];
	for(i=0;i<=dias.length;i++)
	{
		if(days[dias[i]] !== undefined)
		{
			var check = "#edit_"+days[dias[i]];
			$(check).prop('checked', true);
			console.log(check);
		}
	}
	$("#edit_dias_reserva").val(dias);
	$("#edit_costo").val(costo);
	$("#inmuebleEditar").dialog({ modal: true });
	$("#inmuebleEditar").dialog('open');
}

function crearPopupCreacion()
{
	$("#inmuebleCrear").dialog({ modal: true });
	$("#inmuebleCrear").dialog('open');
	$("#treintas0").click();
}

function crearPopupBorrado(mongoid)
{
	$("#inmuebleBorrar").dialog({ modal: true });
	$("#inmuebleBorrar").dialog('open');
	$("#del_mongoid").val(mongoid);
}