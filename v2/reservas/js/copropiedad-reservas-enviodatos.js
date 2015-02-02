function TraerModulosCopropiedad(arr,url,metodo){ 
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

function envioFormulario(arr,url,metodo)
{
    const rutaAplicativo = "http://aws02.sinfo.co/api/";
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
                if(url=="reservas/reserva/" && metodo=="POST")
                    {
                        enviocorreo();
                        $('#alertas').html('<div class="alert alert-success" style="height:10px;"> Reserva creada satisfactoriamente.</div>');
                        setTimeout(refreshWindowCalendario, 1000);
                    }
                if(url=="reservas/reserva/" && metodo=="PUT")
                    {
                        //enviocorreo();
                        $('#alertas').html('<div class="alert alert-success" style="height:10px;"> Reserva modificada satisfactoriamente.</div>');
                        setTimeout(refreshWindow, 1000);
                    }
                if(url=="reservas/reserva/" && metodo=="DELETE")
                    {
                        //enviocorreo();
                        $('#alertas').html('<div class="alert alert-success" style="height:10px;"> Reserva borrada satisfactoriamente.</div>');
                        setTimeout(refreshWindow, 1000);
                    }
            }
            else
            {
                $('#alertas').html('<div class="alert alert-error" style="height:10px;">Error al crear la reserva.</div>');
            }
        }
    });      
}

function envioFormularioInmueble(arr,url,metodo)
{
    const rutaAplicativo = "http://aws02.sinfo.co/api/";
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
                if(url=="reservas/reserva/inmueble/" && metodo=="POST")
                    {
                        //enviocorreo();
                        $('#alertas').html('<div class="alert alert-success" style="height:10px;"> Reserva creada satisfactoriamente.</div>');
                        setTimeout(refreshWindowInmueble, 1000);
                    }
                if(url=="reservas/reserva/inmueble/" && metodo=="PUT")
                    {
                        //enviocorreo();
                        $('#alertas').html('<div class="alert alert-success" style="height:10px;"> Reserva modificada satisfactoriamente.</div>');
                        setTimeout(refreshWindowInmueble, 1000);
                    }
                if(url=="reservas/reserva/inmueble/" && metodo=="DELETE")
                    {
                        //enviocorreo();
                        $('#alertas').html('<div class="alert alert-success" style="height:10px;"> Reserva borrada satisfactoriamente.</div>');
                        setTimeout(refreshWindowInmueble, 1000);
                    }
            }
            else
            {
                $('#alertas').html('<div class="alert alert-error" style="height:10px;">Error al crear la reserva.</div>');
            }
        }
    });      
}

function envioFormularioReporte(arr,url,metodo)
{
    const rutaAplicativo = "http://aws02.sinfo.co/api/";
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
                if(url=="reservas/reserva/inmueble/" && metodo=="POST")
                    {
                        //enviocorreo();
                        $('#alertas').html('<div class="alert alert-success" style="height:10px;"> Reserva creada satisfactoriamente.</div>');
                        setTimeout(refreshWindowInmueble, 1000);
                    }
                if(url=="reservas/reserva/inmueble/" && metodo=="PUT")
                    {
                        //enviocorreo();
                        $('#alertas').html('<div class="alert alert-success" style="height:10px;"> Reserva modificada satisfactoriamente.</div>');
                        setTimeout(refreshWindowInmueble, 1000);
                    }
                if(url=="reservas/reserva/inmueble/" && metodo=="DELETE")
                    {
                        //enviocorreo();
                        $('#alertas').html('<div class="alert alert-success" style="height:10px;"> Reserva borrada satisfactoriamente.</div>');
                        setTimeout(refreshWindowInmueble, 1000);
                    }
            }
            else
            {
                $('#alertas').html('<div class="alert alert-error" style="height:10px;">Error al crear la reserva.</div>');
            }
        }
    });      
}

function traerDatos(arr,url,params)
{
    const rutaAplicativo = "http://aws02.sinfo.co/api/";    
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
    const rutaAplicativo = "http://aws02.sinfo.co/api/";    
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
                            $('#datepicker2').val(y['deadline']);
                            $('#datepicker').val(y['frecordatorio']);
                            $('#compartir_mail').val(y['compartir_mail']);
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
    const rutaAplicativo = "http://aws02.sinfo.co/api/admin/copropiedad/";    
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
    window.location = 'reservas.php';
}

function refreshWindowInmueble()
{
    window.location = 'inmueble.php';
}

function refreshWindowCalendario()
{
    window.location = 'calendario.php';
}