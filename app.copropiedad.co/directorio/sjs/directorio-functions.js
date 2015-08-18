function popularTabla(datos)
{
	if(datos != null || datos != undefined)
		if(datos.length > 0)
			if(datos != "Error en el sistema de autenticacion")
				$.each(datos,function(x,y){
					var idmongo= JSON.stringify(y['_id']);
					var idMongoFinal = JSON.parse(idmongo);
					var t = $('#directorio_table').DataTable();
					var principal ='No';
					if(y['principal']) 
						principal ='Si';
					t.row.add([
						'',
						y['nombre'],
						y['email'],
						y['telefono'],
						y['grupo'],
						y['unidad'],
						principal
						]).draw();
					
					$(document).renderme('sp');
				});
}

function popularTablaProveedores(datos)
{
	if(datos != null || datos != undefined)
		if(datos.length > 0)
			if(datos != "Error en el sistema de autenticacion")
				$.each(datos,function(x,y){
					var idmongo= JSON.stringify(y['_id']);
					var idMongoFinal = JSON.parse(idmongo);
					var t = $('#directorio_table').DataTable(); 
					t.row.add([
						'',
						y['nombre'],
						y['email'],
						y['telefono'],
						y['grupo'],
						y['unidad']
						]).draw();
					
					$(document).renderme('sp');
				});
}

function enviocorreosoporte(body, subject, email) //--OK
{   
 var actualurl="/"; 
 enviocorreoAsync(email, subject, body, actualurl, "casos");
}