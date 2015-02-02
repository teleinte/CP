function envioFormulario(arr,url,params,metodo,direccion,nombre){		
        const rutaAplicatico = "http://aws02.sinfo.co/api/admin/copropiedad/";
        $.ajax(
        {
            url: rutaAplicatico+url,
            type: metodo,
            data: JSON.stringify(arr),
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            async: true,
            success: function(msg) 
            {
                var msgDividido = JSON.stringify(msg);
                var mensaje =  JSON.parse(msgDividido);
                var msgDivididoDos = JSON.stringify(mensaje.message);
                if(mensaje.message=="Token invalido")
                {
                    $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>')
                   	window.location = '../../index.html';
                }
                if(mensaje.status)
                {                  
                    $('#alertas').html('<div class="alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Tip:</strong> Dato insertado Correctamente.</div>')                    
                    window.location = 'usuario.html'
                }
                else {$('#resultado').html(mensaje.error);}
            }
        })        
}

function traerDatos(arr,url,params)
{
    const rutaAplicatico = "http://aws02.sinfo.co/api/admin/copropiedad/";
    $.ajax(
        {
            url: rutaAplicatico+url,
            type: 'POST',
            data: JSON.stringify(arr),
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            async: true,
            success: function(msg) 
            {
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
                    $.each(datos, function(x , y) 
                    {
                        var idmongo= JSON.stringify(y['_id']);
                        var idMongoFinal = JSON.parse(idmongo);
                        $('#tableContainer > tbody:last').append('<tr><td>'+y['nombre']+'</td><td>'+y['telefono']+'</td><td>'+y['email']+'</td><td>'+y['descripcion']+'</td><td><a class="btn editar solo inline" href="usuario-editar.html?idt='+idMongoFinal.$id+'"></a><a class="btn borrar solo inline" href="usuario-eliminar.html?idt='+idMongoFinal.$id+'"></a></td></tr>')
                    })
                }                
            }
        });
}

function traerUnidades(arr,url,params)
{
    const rutaAplicatico = "http://aws02.sinfo.co/api/admin/copropiedad/";
    $.ajax(
        {
            url: rutaAplicatico+url,
            type: 'POST',
            data: JSON.stringify(arr),
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            async: true,
            success: function(msg) 
            {
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
                    $.each(datos, function(x , y) 
                    {
                        var idmongo= JSON.stringify(y['_id']);
                        var idMongoFinal = JSON.parse(idmongo);                        
                        $('#unidad').append("<option value='"+idMongoFinal.$id+"'>"+y['detalle']+"</option>")
                    })
                }                
            }
        });
}

function traerDatosModificables(arr,url,params)
{
    const rutaAplicatico = "http://aws02.sinfo.co/api/admin/copropiedad/";
    $.ajax(
        {
            url: rutaAplicatico+url,
            type: 'POST',
            data: JSON.stringify(arr),
            cache: false,
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            async: true,
            success: function(msg) 
            {
                var msgDividido = JSON.stringify(msg);
                var mensaje =  JSON.parse(msgDividido);
                var msgDivididoDos = JSON.stringify(mensaje.message);
                var datos = JSON.parse(msgDivididoDos);                
                if (datos=="Token invalido")
                {
                    $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Tip:</strong> NO PUDO LISTAR POR TOKEN, Solicitando un nuevo token por favor espere.</div>')
                    window.location = '../index.html';                      
                }
                else
                {
                    $.each(datos, function(x , y) {               
                        var idmongo= JSON.stringify(y['_id']);
                        var idMongoFinal = JSON.parse(idmongo);               
                        if(idMongoFinal.$id==params['idt'])
                        {                            
                            $('#creado_por').val(y['creado_por']);
                            $('#fecha_creacion').val(y['fecha_creacion']);
                            $('#id_copropiedad').val(y['id_copropiedad']);
                            $('#id_crm_persona').val(y['id_crm_persona']);
                            $('#nombre').val(y['nombre']);
                            $('#telefono').val(y['telefono']);
                            $('#email').val(y['email']);
                            $('#unidad').val(y['unidad']);
                            $('#estado').val(y['estado']);
                            $('#tiene_ninios').prop("checked", y['tiene_ninios']);
                            $('#tiene_empleada').prop("checked", y['tiene_empleada']);
                            $('#tiene_mascota').prop("checked", y['tiene_mascota']);
                            $('#tiene_bicicleta').prop("checked", y['tiene_bicicleta']);
                            $('#tiene_vehiculo').prop("checked", y['tiene_vehiculo']);
                            $('#grupo').val(y['grupo']);
                            $('#descripcion').val(y['descripcion']);
                            if (typeof y["contanco_emergencia"] === "object")
                            {
                                $.each(y, function(x , y) 
                                {
                                    $('#enombre').val(y['enombre']);
                                    $('#etelefono').val(y['etelefono']);
                                    $('#ecorreo').val(y['ecorreo']);    
                                });
                            }
                        }                    
                    })
                }                
            }
        });

function sleep(milliseconds) { 
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}
}

function traerModificablesEnteros(arr,url,params)
{
    const rutaAplicatico = "http://aws02.sinfo.co/api/admin/copropiedad/";
    $.ajax(
        {
            url: rutaAplicatico+url,
            type: 'POST',
            data: JSON.stringify(arr),
            cache: false,
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            async: true,
            success: function(msg) 
            {
                var msgDividido = JSON.stringify(msg);
                var mensaje =  JSON.parse(msgDividido);
                var msgDivididoDos = JSON.stringify(mensaje.message);
                var datos = JSON.parse(msgDivididoDos);                
                if (datos=="Token invalido")
                {
                    $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Tip:</strong> NO PUDO LISTAR POR TOKEN, Solicitando un nuevo token por favor espere.</div>')
                    window.location = '../index.html';                      
                }
                else
                {
                    $.each(datos, function(x , y) {               
                        var idmongo= JSON.stringify(y['_id']);
                        var idMongoFinal = JSON.parse(idmongo);               
                        if(idMongoFinal.$id==params['idt'])
                        {                            
                            $('#id_crm_persona').val(y['id_crm_persona']);
                            $('#fecha_creacion').val(y['fecha_creacion']);
                            $('#nombre').val(y['nombre']);
                            $('#direccion').val(y['direccion']);
                            $('#telefono').val(y['telefono']);
                            $('#nit').val(y['nit']);
                            $('#email').val(y['email']);
                            $('#porteria').prop("checked", y['tiene_porteria']);
                            $('#ascensor').prop("checked", y['tiene_acensor']);
                            $('#zona_ddq').prop("checked", y['tiene_zona_ddq']);
                            $('#piscina').prop("checked", y['tiene_piscina']);
                            $('#gimnasio').prop("checked", y['tiene_gimnasio']);
                            $('#sauna').prop("checked", y['tiene_sauna']);
                            $('#turco').prop("checked", y['tiene_turco']);
                            $('#jardin').prop("checked", y['tiene_jardin']);                           
                            $('#estadp').val(y['estadp']);
                            $('#modulos').val(y['modulos_activos']);                            
                            $('#color').val(y['modulos_activos']);                            

                        }                    
                    })
                }                
            }
        });

function sleep(milliseconds) { 
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}
}
function TraerCopropiedadDrop(arr,url,metodo){
    const rutaAplicatico = "http://aws02.sinfo.co/api/admin/copropiedad/";    
    $.ajax(
        {
            url: rutaAplicatico+url,
            type: 'POST',
            data: JSON.stringify(arr),
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            async: false,
            success: function(msg) 
            {
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
                    $.each(datos, function(x , y) 
                    {
                        var idmongo= JSON.stringify(y['_id']);
                        var idMongoFinal = JSON.parse(idmongo);
                        if (idMongoFinal.$id==sessionStorage.getItem('cp'))
                        {
                            $('#copropiedad').append('<option value="'+idMongoFinal.$id+'" data-image="images/msdropdown/color'+y['color']+'.png" data-description="'+y['direccion']+'" selected>'+y['nombre']+'</option>')
                        }
                        else
                        {
                            $('#copropiedad').append('<option value="'+idMongoFinal.$id+'" data-image="images/msdropdown/color'+y['color']+'.png" data-description="'+y['direccion']+'" >'+y['nombre']+'</option>')    
                        }
                        
                    })               
                }
                return false;
            }
        });


}



