function traerDatosHoy()
{
	var rutaAplicativo = "https://app.copropiedad.co/api/hoy/obtener/";  
	var arr = { token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp')}};
	var salida = "<ul>";
	$.post(rutaAplicativo, JSON.stringify(arr))
	        .done(function(msg){
	            var msgDividido = JSON.stringify(msg);
	            var mensaje =  JSON.parse(msgDividido);
	            var msgDivididoDos = JSON.stringify(mensaje.message);
	            var datos3 = JSON.parse(msgDivididoDos);                
	            if (datos3=="Token invalido")
	            {
	                $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>')                  
	                window.location = '../index.php';
	            }
	            else
	            {	
	            	var tareasvencidas = new Array();
	            	var tareashoy = new Array();
	            	//var reservashoy = new Array();
	            	var solicitudes = new Array();
	            	if(!$.isEmptyObject(datos3))
            		$.each(datos3, function(x , y)
            		{
            			var hoy = new Date().toISOString().split("T")[0];	
            			//console.log(y['nombre'] + "-" + y['fecha'] + "-" + y['tipo']);
            			if(y['tipo'] == 'tarea')
            			{
            				var fechaitem = new Date(y['fecha'].replace("COT","T")).toISOString().split("T")[0];
            				if(fechaitem == hoy)
            				{
            					if(tareasvencidas.length < 1)
            						tareasvencidas.push('<div class="title" style="margin-top:5px;">Tareas para hoy</div>');
            					tareashoy.push('<li><div class="floatleft"><a href="https://app.copropiedad.co/tarea/">&nbsp;&nbsp;' + y['nombre'] + '</a></div><div class="floatright">Vence hoy</div></li>');
            				}
            				else
            				{
            					if(tareasvencidas.length < 1)
            						tareasvencidas.push('<div class="title" style="margin-top:5px;">Tareas vencidas</div>');
            					tareasvencidas.push('<li><div class="floatleft"><a href="https://app.copropiedad.co/tarea/">&nbsp;&nbsp;' + y['nombre'] + '</a></div><div class="floatright"> Venció el ' + fechaitem + '</div></li>');
            				}
            			}
            			/*else if(y['tipo'] == 'reserva')
            			{
            				if(reservashoy.length < 1)
            					reservashoy.push('<div class="title" style="margin-top:5px;">Reservas para hoy</div>');
            				var fechar = new Date(y['fecha'].replace("COT","T")).toISOString().split("T")[1].replace(":00.000Z","");
            				reservashoy.push('<li><div class="floatleft"><a href="http://aws02.sinfo.co/v2/reservas/">&nbsp;&nbsp;' + y['nombre'] + '</a></div><div class="floatright">' + fechar + '</div></li>');
            			}*/
            			else if(y['tipo'] == 'solicitud')
            			{
            				if(solicitudes.length < 1)
            					solicitudes.push('<div class="title" style="margin-top:5px;">Solicitudes abiertas / Fecha Apertura</div>');
            				var fechas = new Date(y['fecha'].replace("COT","T")).toISOString().split("T")[0].replace(":00+00:00","");
            				var oneDay = 24*60*60*1000;	// hours*minutes*seconds*milliseconds
            				var firstDate = new Date(fechas);
            				var secondDate = new Date();
            				var diffDays = Math.ceil((firstDate.getTime() - secondDate.getTime())/(oneDay))*-1;
            				if(diffDays == 0)
            					solicitudes.push('<li><div class="floatleft"><a href="https://app.copropiedad.co/solicitudes/">&nbsp;&nbsp;' + y['nombre'] + '</a></div><div class="floatright">Abierta hoy</div></li>');	
            				else
            					solicitudes.push('<li><div class="floatleft"><a href="https://app.copropiedad.co/solicitudes/">&nbsp;&nbsp;' + y['nombre'] + '</a></div><div class="floatright">Abierta hace ' + diffDays + ' dias</div></li>');	
            			}
            		});
					
					salida = tareashoy.concat(tareasvencidas).concat(solicitudes);//.concat(reservashoy);
					$("#pending-panel").html("<ul>" + salida.join("") + "</ul>");
					console.log(datos3.length);
					if(solicitudes.length > 0)
						{
							$("#pending-counter-text").text("Mis Pendientes...");
							$("#pending-counter").html(datos3.length);
						}
					else
						{
							$("#pending-counter").html(datos3.length);
							$("#pending-counter-text").text('No hay pendientes para hoy');
						}
	            }
	        });
}

$(document).ready(function() {
	traerDatosHoy();
});