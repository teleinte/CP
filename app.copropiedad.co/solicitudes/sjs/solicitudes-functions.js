function popularTabla(datos)
{
	if(datos != null || datos != undefined)
		if(datos.length > 0)
			$.each(datos,function(x,y){
				var idmongo= JSON.stringify(y['_id']);
				var idMongoFinal = JSON.parse(idmongo);
        var t = $('#solicitudes').DataTable(); 
				t.row.add([
          '',
          (idMongoFinal.$id).substring(18,25),
          y['solicitud'],
          y['notas'],
          y['fecha_creacion'].split("T")[0],
          y['fecha_creacion'].split("T")[1].split(":")[0] + ":" + y['fecha_creacion'].split("T")[1].split(":")[1],
          y['usuario_nombre'],
          '<a teid="sl:title:13" class="btn completar solo inline ttip completar_sol" mongoid="'+idMongoFinal.$id+'"></a>'
          ]).draw();
				$(document).renderme('sl');
			});
}
 function popularRespuestaCaso(datos)
{
  if(datos != null || datos != undefined)
    if(datos.length > 0)
      $.each(datos,function(x,y)
      {
        var idmongo= JSON.stringify(y['_id']);
        var idMongoFinal = JSON.parse(idmongo);
        $('#fecha_creacion_guardar').val(y['fecha_creacion']);
        $('#nombre_copropiedad').html(sessionStorage.getItem('ncp'));
        $('#id_caso').html((idMongoFinal.$id).substring(18,25));
        $('#fecha_creacion_caso').html($('#fecha_creacion_guardar').val().split('T')[0]);
        $('#caso_cliente').html(y['solicitud']);
        $('#notas_cliente').html(y['notas']);
        $('#cliente_nombre').html(y['usuario_nombre']);
        $('#cliente_correo').html(y['usuario_correo']);
        $('#id_crm_cliente').val(y['usuario']);
        $('#id_copropiedad').val(y['id_copropiedad']);
        //$('#nombre_cliente').val(y['usuario_nombre']);
        $(document).renderme('sp');
        
      });
}

function popularTablaHistorico(datos)
{
  if(datos != null || datos != undefined)
    if(datos.length > 0)
      $.each(datos,function(x,y){
        var idmongo= JSON.stringify(y['_id']);
        var idMongoFinal = JSON.parse(idmongo);
        var t = $('#solicitudes').DataTable(); 
        t.row.add([
          '',
          (idMongoFinal.$id).substring(18,25),
          y['solicitud'],
          y['notas'],
          y['fecha_creacion'].split("T")[0],
          y['fecha_creacion'].split("T")[1].split(":")[0] + ":" + y['fecha_creacion'].split("T")[1].split(":")[1],
          y['fecha_cierre'].split("T")[0],
          y['usuario_nombre']
          ]).draw();
        $(document).renderme('sl');
      });
}

function enviocorreosolicitud(body, subject, email) //--OK
{   
 var actualurl="/"; 
 enviocorreoAsync(email, subject, body, actualurl);
}