function envioFormulario(arr,url,params,metodo){		
        const rutaAplicatico = "http://aws02.sinfo.co/api/";
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
                   	window.location = '../index.html';
                }
                if(mensaje.status)
                {
                    if(url=="tareas/list" && metodo=="POST"){enviocorreo();}
                    $('#alertas').html('<div class="alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Tip:</strong> Dato insertado Correctamente.</div>')                    
                    window.location = 'tareas.html'
                }
                else
                {
                    $('#resultado').html(mensaje.error);
                }
            }
        })        
}

function traerDatos(arr,url,params)
{
    const rutaAplicatico = "http://aws02.sinfo.co/api/";    
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
                        $('#tableContainer > tbody:last').append('<tr><td>'+y['nombre']+'</td><td>'+y['notas']+'</td><td>'+y['deadline']+'</td><td>'+y['estado']+'</td><td><a class="btn editar solo inline" href="tarea-editar.html?idt='+idMongoFinal.$id+'"></a><a class="btn borrar solo inline" href="tarea-eliminar.html?idt='+idMongoFinal.$id+'"></a></td></tr>')
                    })
                }                
            }
        });
}

function traerDatosModificables(arr,url,params)
{
    const rutaAplicatico = "http://aws02.sinfo.co/api/";    
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
                            $('#nombre').val(y['nombre']);
                            $('#responsable').val(y['responsable']);
                            $('#datepicker2').val(y['deadline']);
                            $('#datepicker').val(y['frecordatorio']);
                            $('#compartir_mail').val(y['compartir_mail']);
                            $('#estado').val(y['estado']);
                            $('#prioridad').val(y['prioridad']);
                            $('#notas').val(y['notas']);
                            $('#recordatorio_mail').val(y['recordatorio_mail']);
                            $('#recordatorio_cp').val(y['recordatorio_cp']);
                            if (y['creador']==sessionStorage.getItem('id_crm'))
                            {
                                $('#estado').append('<option value = "Por Iniciar" selected>Por Iniciar</option><option value = "En Progreso">En Progreso</option><option value = "Cerrada">Cerrada</option><option value = "Borrada">Borrada</option>')
                            }
                            else if(y['responsable']==sessionStorage.getItem('email'))
                            {
                                $('#estado').append('<option value = "Por Iniciar" selected>Por Iniciar</option><option value = "En Progreso">En Progreso</option><option value = "Cerrada">Cerrada</option><option value = "Borrada">Borrada</option>')                                
                            }
                        }                    
                    })
                }                
            }
        });
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

function TraerUsuarioCopropiedad(arr,url,metodo){
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
                        $('#responsable').append('<option value="'+y['email']+'">'+y['nombre']+'</option>')
                        
                        
                    })               
                }
                return false;
            }
        });


}


