function popularTabla(datos)
{
	if(datos != null || datos != undefined)
		if(datos.length > 0)
			$.each(datos,function(x,y){
				var idmongo= JSON.stringify(y['_id']);
				var idMongoFinal = JSON.parse(idmongo);
				var accion= '';
				var creacion = '';
				var hora_creacion = '';
				var cierre = '';
				var hora_cierre = '';
				if(y['fecha_cierre']!==null || y['fecha_cierre']!==undefined)
				{
					cierre= y['fecha_cierre'].split("T")[0];
					hora_cierre= y['fecha_cierre'].split("T")[1].split(":")[0] + ":" + y['fecha_cierre'].split("T")[1].split(":")[1];
					
				}
				if(y['fecha_creacion']!==null || y['fecha_creacion']!==undefined)
				{
					creacion= y['fecha_creacion'].split("T")[0];
					hora_creacion= y['fecha_creacion'].split("T")[1].split(":")[0] + ":" + y['fecha_creacion'].split("T")[1].split(":")[1];
				}

				if(y['estado']!=="Cerrado")
				{
					accion = '<a teid="sl:title:13" class="btn completar solo inline ttip completar_sol" mongoid="'+idMongoFinal.$id+'"></a>';
					cierre = "";
					hora_cierre = "";
				}
				var t = $('#casos-soporte').DataTable(); 
				t.row.add([
					'',
					(idMongoFinal.$id).substring(18,25),
					y['caso'],
					y['notas'],
					creacion,
					hora_creacion,
					cierre,
					hora_cierre,
					y['usuario_nombre'],
					y['id_copropiedad'],
					y['estado'],
					accion
					]).draw();
				$(document).renderme('sp');
			});
}

function popularRespuestaCaso(datos)
{
	if(datos != null || datos != undefined)
		if(datos.length > 0)
			$.each(datos,function(x,y){
				var idmongo= JSON.stringify(y['_id']);
				var idMongoFinal = JSON.parse(idmongo);
				
				$('#id_copropiedad_cliente').html(y['id_copropiedad']);
				$('#id_caso').html((idMongoFinal.$id).substring(18,25));
				$('#fecha_creacion_caso').html(y['fecha_creacion']);
				$('#caso_cliente').html(y['caso']);
				$('#notas_cliente').html(y['notas']);
				$('#cliente_nombre').html(y['usuario_nombre']);
				$('#cliente_correo').html(y['usuario_correo']);
				$('#id_crm_cliente').val(y['usuario']);

					
					
					/*y['fecha_creacion'].split("T")[1].split(":")[0] + ":" + y['fecha_creacion'].split("T")[1].split(":")[1],
					y['usuario_nombre'],
					,
					y['estado'],
					'<a teid="sl:title:13" class="btn completar solo inline ttip completar_sol" mongoid="'+idMongoFinal.$id+'"></a>'
					]).draw();*/
				$(document).renderme('sp');
			});
}

function enviocorreosoporte(body, subject, email) //--OK
{   
 
 var actualurl="/"; 
 enviocorreoAsync(email, subject, body, actualurl, "casos");
}