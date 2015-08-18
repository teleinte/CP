//Funcion para popular la tabla de tareas
function mimicclick()
{
  //alert(id);
  //$("#"+id).click();
}

function popularTabla(datos)
{
    var cont = 0;
    if(datos != null || datos != undefined)
  $.each(datos,function(x,y){
    var idmongo= JSON.stringify(y['_id']);
    var idMongoFinal = JSON.parse(idmongo);
		var t = $('#tareas').DataTable();
    var accion = '<input type="button" id="elim' + cont + '" class="btn borrar solo inline btnr_eliminar_tarea ttip" id="btnr_eliminar_tarea" teid="tar:title:11" mongoid="' + y['_id']['$id'] + '" nombre="' + y['nombre'] + '" estado="' + y['estado'] + '" deadline="' + y['deadline'] + '" frecuencia="' + y['frecuencia'] + '" notas="' + y['notas'] + '" creacion="' + y['fecha_creacion'] + '" onClick="mimicclick()" />&nbsp;<input type="button" class="btn completar solo inline btnr_completar_tarea ttip" id="btnr_completar_tarea" teid="tar:title:10" mongoid="' + y['_id']['$id'] + '" nombre="' + y['nombre'] + '" estado="' + y['estado'] + '" deadline="' + y['deadline'] + '" frecuencia="' + y['frecuencia'] + '" notas="' + y['notas'] + '" creacion="' + y['fecha_creacion'] + '"/>&nbsp;<input type="button" id="btnr_editar_tarea" class="btn editar solo inline btnr_editar_tarea ttip"  teid="tar:title:9" mongoid="' + y['_id']['$id'] + '" nombre="' + y['nombre'] + '" estado="' + y['estado'] + '" deadline="' + y['deadline'] + '" frecuencia="' + y['frecuencia'] + '" notas="' + y['notas'] + '" creacion="' + y['fecha_creacion'] + '"/>';
    if(y['estado']=='completada')
    {
      accion = '<input type="button" id="elim' + cont + '" class="btn borrar solo inline btnr_eliminar_tarea ttip" id="btnr_eliminar_tarea" teid="tar:title:11" mongoid="' + y['_id']['$id'] + '" nombre="' + y['nombre'] + '" estado="' + y['estado'] + '" deadline="' + y['deadline'] + '" frecuencia="' + y['frecuencia'] + '" notas="' + y['notas'] + '" creacion="' + y['fecha_creacion'] + '" onClick="mimicclick()" />';
    }
        if(y['estado']!="cerrada")
        {
            t.row.add( [
	            '',                            
	            y['nombre'],
	            y['notas'],
	            y['deadline'].split("COT")[0],
              toTitleCase(y['estado']),
              accion
	        ]).draw();
        }
      cont ++;
	});
}
function toTitleCase(str)
{
    return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
}

function tareaDelete(mongoid,creacion,nombre,fin,frecuencia,notas)
{
     var arr = 
     {
       token:sessionStorage.getItem('token'),
       body:
       {
            id:mongoid,
            id_copropiedad : sessionStorage.getItem('cp'),
            creador: sessionStorage.getItem('id_crm'),
            fecha_creacion:creacion,
            tipo:"tarea",
            nombre:nombre,
            estado:"eliminada",
            fecha_fin:fecha(),
            deadline:fin,
            notas:notas,
            frecuencia:frecuencia
       }
     }; 
     var url = "tareas/list/";
     var response = envioFormularioSync(url,arr,'DELETE');
     if(response)
     {
       setTimeout(refreshWindow('index.php'),1000);
     }
     else
     {
       $("#alertas").html('<div class="alert alert-dismissable alert-error" teid="tar:html:9"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="tar:html:1"></strong></div>');
       $(document).renderme('tar');
     }
}

function tareaCompletar(mongoid,creacion,nombre,fin,frecuencia,notas)
{
     var arr = 
     {
       token:sessionStorage.getItem('token'),
       body:
       {
        id:mongoid,
        id_copropiedad : sessionStorage.getItem('cp'),
        creador: sessionStorage.getItem('id_crm'),
        fecha_creacion:creacion,
        tipo:"tarea",
        nombre:nombre,
        estado:"completada",
        fecha_fin:fecha(),
        deadline:fin,
        notas:notas,
        frecuencia:frecuencia
       }
     }; 
     var url = "tareas/list/";
     var response = envioFormularioSync(url,arr,'DELETE');
     if(response)
     {
       setTimeout(refreshWindow('index.php'),1000);
     }
     else
     {
       $("#alertas").html('<div class="alert alert-dismissable alert-error" teid="tar:html:13"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="tar:html:1"></strong></div>');
       $(document).renderme('tar');
     }
}