function popularTablaDocumentos(datos)
{
	if(datos.length > 0)
		$.each(datos, function(x , y) 
		{
		    var idmongo= JSON.stringify(y['_id']);
		    var idMongoFinal = JSON.parse(idmongo);
		    var t = $('#documentos').DataTable();
		    t.row.add( [
		        '',
		        y['nombre'],
		        y['fecha_creacion'].split("T")[0],
		        ucfirst(y['tipo']),
		        y['descripcion'],
		        '<a class="btn borrar solo inline btnborrar ttip" teid="gd:title:8" mongoid="'+idMongoFinal.$id+'"></a><a class="btn descargar solo inline ttip" teid="gd:title:7" href="'+y['enlace']+'"></a>'
		    ] ).draw();
		    $(document).renderme('gd');

		    var t = $('#tareas').DataTable();
		});
}