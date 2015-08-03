function TraerModulosCopropiedad(arr,url,metodo){ 
    var rutaAplicatico = traerDireccion()+"api/admin/copropiedad/";
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
                        sessionStorage.setItem("cp", idMongoFinal.$id);
                        var datos = JSON.stringify(y['modulos_activos']);
                        sessionStorage.setItem("modulos",y['modulos_activos'])
                        var endata =  JSON.parse(datos);                                                
                        //$('#tableContainer > tbody:last').append('<tr><td>'+y['nombre']+'</td><td>'+y['direccion']+'</td><td>'+y['telefono']+'</td><td>'+y['nit']+'</td><td><a class="btn editar solo inline" href="copropiedad-editar.html?idt='+idMongoFinal.$id+'"></a><a class="btn borrar solo inline" href="copropiedad-eliminar.html?idt='+idMongoFinal.$id+'"></a></td></tr>')
                    })
                }                
            }
        });
}

function envioFormulario(arr,url,params,metodo)
{
        var rutaAplicativo = traerDireccion()+"api/";
        $.ajax(
        {
            url: rutaAplicativo+url,
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
                    if(url=="tareas/list" && metodo=="POST")
                        {   
                            //alert($('#nombre').val());
                            enviocorreo();
                            $('#alertas').html('<div class="alert alert-dismissable alert-success" style="height:10px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Tarea creada satisfactoriamente.</div>');
                            setTimeout(refreshWindow, 1000);
                        }
                    if(url=="tareas/list" && metodo=="PUT")
                        {
                            enviocorreo();
                            $('#alertas').html('<div class="alert alert-dismissable alert-success" style="height:10px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Cambio satisfactorio.</div>');
                            setTimeout(refreshWindow, 1000);
                        }    
                    if(url=="eventos/evento/" && metodo=="POST")
                        {
                            var eventin=JSON.parse(JSON.stringify(mensaje.message));
                            enviocorreoEvento(eventin.$id);
                            $('#alertas').html('<div class="alert alert-dismissable alert-success" style="height:10px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Evento creado satisfactoriamente.</div>');
                            setTimeout(refreshWindow, 1000);
                        }
                    if(url=="eventos/evento/" && metodo=="PUT")
                        {
                            enviocorreo();
                            $('#alertas').html('<div class="alert alert-dismissable alert-success" style="height:10px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Evento Eliminado.</div>');
                            setTimeout(refreshWindow, 1000);
                        }
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
    var rutaAplicativo = traerDireccion()+"api/";    
    $.ajax(
        {
            url: rutaAplicativo+url,
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
    var rutaAplicativo = traerDireccion()+"api/";    
    $.ajax(
        {
            url: rutaAplicativo+url,
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
                            $('#com_responsable').val(y['responsable']);
                            $('#datepicker2').val(y['deadline']);
                            $('#datepicker').val(y['frecordatorio']);
                            $('#eli_datepicker').val(y['frecordatorio']);
                            $('#compartir_mail').val(y['compartir_mail']);
                            $('#eli_compartir_mail').val(y['compartir_mail']);
                            $('#estado').val(y['estado']);
                            $('#prioridad').val(y['prioridad']);
                            $('#notas').val(y['notas']);
                            $('#recordatorio_mail').val(y['recordatorio_mail']);
                            $('#recordatorio_cp').val(y['recordatorio_cp']);
                        }                    
                    })
                }                
            }
        });
}

function TraerUsuarioCopropiedad(arr,url,metodo){
    var rutaAplicativo = traerDireccion()+"api/admin/copropiedad/";    
    $.ajax(
        {
            url: rutaAplicativo+url,
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
                        $('#responsable').append('<option value="'+y['email']+'">'+y['nombre']+'</option>')
                    })               
                }
                return false;
            }
        });
}

function refreshWindow()
{
    window.location = 'index.php';
}

