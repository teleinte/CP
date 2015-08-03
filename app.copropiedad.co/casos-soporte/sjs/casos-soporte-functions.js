function popularTabla(datos)
{
	if(datos != null || datos != undefined)
		if(datos.length > 0)
			$.each(datos,function(x,y){
				var idmongo= JSON.stringify(y['_id']);
				var idMongoFinal = JSON.parse(idmongo);
				var t = $('#casos-soporte').DataTable(); 
				var cierre='';
				var hora_cierre='';
				var creacion='';
				var hora_creacion='';
				var respuesta='';
				if(y['fecha_creacion']!== undefined || y['fecha_creacion']!== null)
				{
					creacion= y['fecha_creacion'].split("T")[0];
					hora_creacion= y['fecha_creacion'].split("T")[1].split(":")[0] + ":" + y['fecha_creacion'].split("T")[1].split(":")[1];

				}
				if(y['respuesta']!== undefined || y['respuesta']!== null)
				{
					respuesta = y['respuesta'];
				}
				if(y['fecha_cierre']!=='')
				{
					cierre= y['fecha_cierre'].split("T")[0];
					hora_cierre=y['fecha_cierre'].split("T")[1].split(":")[0] + ":" + y['fecha_cierre'].split("T")[1].split(":")[1] ;
				}

				if(y['estado']!=="Cerrado")
				{
					cierre = "";
					hora_cierre = "";
				}
				t.row.add([
					'',
					(idMongoFinal.$id).substring(18,25),
					y['caso'],
					y['notas'],
					respuesta,
					creacion,
					hora_creacion,
					cierre,
					hora_cierre,
					y['estado']
					]).draw();
				
				$(document).renderme('sp');
			});
}

function enviocorreosoporte(body, subject, email) //--OK
{   
 
 var actualurl="/"; 
 enviocorreoAsync(email, subject, body, actualurl, "casos");
}