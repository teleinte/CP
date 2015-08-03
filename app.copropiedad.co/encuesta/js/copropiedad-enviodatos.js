function envioFormulario(arr,url,metodo,parametros){
        rutaAplicatico = traerDireccion()+"api/";
        $.ajax(
        {
            url: rutaAplicatico+url,
            type: metodo,
            data: JSON.stringify(arr),
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            async: false,
            success: function(msg) 
            {
                var msgDividido = JSON.stringify(msg);
                var mensaje =  JSON.parse(msgDividido);
                var msgDivididoDos = JSON.stringify(mensaje.message);
                if(mensaje.message=="Token invalido")
                {
                    $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>');
                    window.location = '../../index.php';
                }
                if(mensaje.status)
                {
                    if(metodo=="PUT" || metodo=="DELETE")
                    {                        
                        $('#alertas').html('<div class="alert alert-dismissable alert-success" style="height:10px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Cambio satisfactorio.</div>');                        
                        window.location='encuesta-editar.php?idt='+parametros["idt"];                        
                        return false;
                    }
                    else
                    {
                        $.each(mensaje.message, function(x , y) 
                        {
                            sessionStorage.setItem("insertado",y);
                        });
                    }
                }
                else {$('#resultado').html(mensaje.error);}
            }
        });
}

function envioFormularioEliminar(arr,url,metodo,parametros){    
        rutaAplicatico = traerDireccion()+"api/";
        $.ajax(
        {
            url: rutaAplicatico+url,
            type: metodo,
            data: JSON.stringify(arr),
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            async: false,
            success: function(msg) 
            {
                var msgDividido = JSON.stringify(msg);
                var mensaje =  JSON.parse(msgDividido);
                var msgDivididoDos = JSON.stringify(mensaje.message);
                if(mensaje.message=="Token invalido")
                {
                    $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>');
                    window.location = '../../index.php';
                }
                if(mensaje.status)
                {
                    if(metodo=="PUT")
                    {                        
                        $('#alertas').html('<div class="alert alert-dismissable alert-success" style="height:10px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Cambio satisfactorio.</div>');                        
                        window.location='index.php';
                        return false;
                    }
                    else
                    {
                        $.each(mensaje.message, function(x , y) 
                        {
                            sessionStorage.setItem("insertado",y);
                        });
                    }
                }
                else {$('#resultado').html(mensaje.error);}
            }
        });
}



function GrabaParaEnvio(arr,url,metodo){
    rutaAplicatico = traerDireccion()+"api/";
    $.ajax(
    {
        url: rutaAplicatico+url,
        type: metodo,
        data: JSON.stringify(arr),
        contentType: 'application/json; charset=utf-8',
        dataType: 'json',
        async: false,
        success: function(msg) 
        {
            var msgDividido = JSON.stringify(msg);
            var mensaje =  JSON.parse(msgDividido);
            var msgDivididoDos = JSON.stringify(mensaje.message);
            if(mensaje.message==="Token invalido")
            {
                $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>');
                window.location = '../../index.php';
            }
            if(mensaje.status)
            {
                sessionStorage.setItem("ok","insertado");                
            }
            else {$('#resultado').html(mensaje.error);}
        }
    }); 
}

function enviarCorreoEncuesta(arr,url,metodo){
    rutaAplicatico = traerDireccion()+"api/";    
    $.ajax(
    {
        url: rutaAplicatico+url,
        type: metodo,
        data: JSON.stringify(arr),
        contentType: 'application/json; charset=utf-8',
        dataType: 'json',
        async: false,
        success: function(msg) 
        {
            var msgDividido = JSON.stringify(msg);
            var mensaje =  JSON.parse(msgDividido);
            var msgDivididoDos = JSON.stringify(mensaje.message);
            if(mensaje.message==="Token invalido")
            {
                $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>');
                window.location = '../../index.php';
            }
            if(mensaje.status)
            {
                $('#alertas').html('<div class="alert alert-dismissable alert-success" style="height:10px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Se ha enviado la encuesta correctamente.</div>');                        
                window.location='index.php';
            }
            else {$('#resultado').html(mensaje.error);}
        }
    }); 
}

function borraEnvio(arr,url,metodo){
    rutaAplicatico = traerDireccion()+"api/";
    $.ajax(
    {
        url: rutaAplicatico+url,
        type: metodo,
        data: JSON.stringify(arr),
        contentType: 'application/json; charset=utf-8',
        dataType: 'json',
        async: false,
        success: function(msg) 
        {
            var msgDividido = JSON.stringify(msg);
            var mensaje =  JSON.parse(msgDividido);
            var msgDivididoDos = JSON.stringify(mensaje.message);
            if(mensaje.message==="Token invalido")
            {
                $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>');
                window.location = '../../index.php';
            }
            if(mensaje.status)
            {
                
            }
            else {$('#resultado').html(mensaje.error);}
        }
    }); 
}

function envioFormulario(arr,url,metodo,parametros){
        rutaAplicatico = traerDireccion()+"api/";
        $.ajax(
        {
            url: rutaAplicatico+url,
            type: metodo,
            data: JSON.stringify(arr),
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            async: false,
            success: function(msg) 
            {
                var msgDividido = JSON.stringify(msg);
                var mensaje =  JSON.parse(msgDividido);
                var msgDivididoDos = JSON.stringify(mensaje.message);
                if(mensaje.message=="Token invalido")
                {
                    $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>');
                    window.location = '../../index.php';
                }
                if(mensaje.status)
                {
                
                    if(metodo=="PUT" || metodo=="DELETE")
                    {                        
                        $('#alertas').html('<div class="alert alert-dismissable alert-success" style="height:10px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Cambio satisfactorio.</div>');                        
                        window.location='encuesta-editar.php?idt='+parametros["idt"];                        
                        return false;
                    }
                    else
                    {
                        $.each(mensaje.message, function(x , y) 
                        {
                            sessionStorage.setItem("insertado",y);
                        });
                    }
                }
                else {$('#resultado').html(mensaje.error);}
            }
        });
}

function SolicitoToken(arr,url,metodo,parametros){
        rutaAplicatico = traerDireccion()+"api/";
        $.ajax(
        {
            url: rutaAplicatico+url,
            type: metodo,
            data: JSON.stringify(arr),
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            async: false,
            success: function(msg) 
            {
                //alert("paso el envio");
                var msgDividido = JSON.stringify(msg);
                var mensaje =  JSON.parse(msgDividido);
                var msgDivididoDos = JSON.stringify(mensaje.message);                
                $.each(mensaje.message, function(x , y) 
                {
                    sessionStorage.setItem("nuevoToken",y);
                });                                
            }
        });
}

function traerElectores(arr,url,metodo){
rutaAplicativo = traerDireccion()+"api/";    
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
                //alert(JSON.stringify(mensaje.message));
                $('#totalEncuestados').html('Total encuestados: '+JSON.stringify(mensaje.message));
                               
            }
        });
}

function traerElectantes(arr,url,metodo){
rutaAplicativo = traerDireccion()+"api/";
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
                //alert(JSON.stringify(mensaje.message));
                $('#totalInvitados').html('Total invitados a responder: '+JSON.stringify(mensaje.message));
                               
            }
        });
}

function envioPreguntaEliminar(arr,url,metodo,encuesta){
        rutaAplicatico = traerDireccion()+"api/";
        $.ajax(
        {
            url: rutaAplicatico+url,
            type: metodo,
            data: JSON.stringify(arr),
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            async: false,
            success: function(msg) 
            {
                var msgDividido = JSON.stringify(msg);
                var mensaje =  JSON.parse(msgDividido);
                var msgDivididoDos = JSON.stringify(mensaje.message);
                if(mensaje.message=="Token invalido")
                {
                    $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>');
                    window.location = '../../index.php';
                }
                if(mensaje.status)
                {
                    if(metodo=="DELETE")
                    {
                        $('#alertas').html('<div class="alert alert-dismissable alert-success" style="height:10px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Cambio satisfactorio.</div>');                        
                        window.location='encuesta-editar.php?idt='+encuesta;
                        return false;
                    }                    
                }
                else {$('#resultado').html(mensaje.error);}
            }
        });        
}

function envioPregunta(arr,url,metodo){
        rutaAplicatico = traerDireccion()+"api/";
        $.ajax(
        {
            url: rutaAplicatico+url,
            type: metodo,
            data: JSON.stringify(arr),
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            async: false,
            success: function(msg) 
            {                
                var msgDividido = JSON.stringify(msg);
                var mensaje =  JSON.parse(msgDividido);
                var msgDivididoDos = JSON.stringify(mensaje.message);
                if(mensaje.message=="Token invalido")
                {
                    $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>')
                    window.location = '../../index.php';
                }
                if(mensaje.status)
                {                    
                    $('#alertas').html('<div class="alert alert-dismissable alert-success" style="height:10px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Pregunta creada.</div>');
                }
                else {$('#resultado').html(mensaje.error);}
            }
        })        
}

function notificador()
{
    $('#alertas').html('<div class="alert alert-dismissable alert-success" style="height:10px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Encuesta Creada.</div>');
    window.location='index.php';
    return false;
}

function envioPreguntaModificada(arr,url,metodo,encuesta){
        rutaAplicatico = traerDireccion()+"api/";
        $.ajax(
        {
            url: rutaAplicatico+url,
            type: metodo,
            data: JSON.stringify(arr),
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            async: false,
            success: function(msg) 
            {                
                var msgDividido = JSON.stringify(msg);
                var mensaje =  JSON.parse(msgDividido);
                var msgDivididoDos = JSON.stringify(mensaje.message);
                if(mensaje.message=="Token invalido")
                {
                    $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>')
                    window.location = '../../index.php';
                }
                if(mensaje.status)
                {                    
                    $('#alertas').html('<div class="alert alert-dismissable alert-success" style="height:10px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Cambio satisfactorio.</div>');
                    window.location = 'encuesta-editar.php?idt='+encuesta;
                }
                else {$('#resultado').html(mensaje.error);}
            }
        })        
}

function traerDatos(arr,url,params){
    rutaAplicativo = traerDireccion()+"api/";    
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
                        var t = $('#example').DataTable();
                        if(y['estado']=="Completada")
                        {
                            t.row.add( [
                            '',                            
                            y['nombre'],
                            y['descripcion'],
                            y['fecha_fin'],                            
                            ''
                        ] ).draw();

                        }
                        if(y['estado']!="Cerrada")
                        {
                            t.row.add([
                            '',                            
                            y['nombre'],
                            y['descripcion'],
                            y['fecha_fin'],
                            '<a class="btn editar solo inline" title="Editar" href="encuesta-editar.php?idt='+idMongoFinal.$id+'"></a><a class="btn enviar solo inline" title="Enviar" id="open-enviar-encuesta" href="enviar-encuesta.php?idt='+idMongoFinal.$id+'"></a><a class="btn resultados solo inline" title="Resultados" href="resultado-encuesta.php?idt='+idMongoFinal.$id+'"></a><a class="btn borrar solo inline" title="Borrar" href="encuesta-borrar.php?idt='+idMongoFinal.$id+'"></a>'                            
                        ] ).draw();
                        }                        
                    });
                }                
            }
        });
}

function traerPreguntasResultado(arr,url,params){
    rutaAplicativo = traerDireccion()+"api/";    
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
                var contador = 1;
                if (datos=="Token invalido")
                {
                    $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>')                  
                    window.location = '../index.html';
                }
                else
                {
                    $.each(datos, function(x , y) 
                    {
                        //alert("esto es x"+x);
                        var muestra=x.split("|")
                        var t = $('#res-encuesta').DataTable();                        
                        t.row.add([
                        '',
                        contador,
                        '<a href="#" id="pregunta'+contador+'">'+muestra[1]+'</a>',
                        y
                        ] ).draw();
                        $('#pregunta'+contador).click(function(){
                            //alert('ingreso' + (this).id);
                            $('#'+muestra[0]).removeClass("sinver");
                            $('#'+muestra[0]).show();                            
                            $(".sinver").hide();
                            $('#'+muestra[0]).addClass("sinver");
                        });
                        contador++;                                               
                    });
                }                
            }
        });
}

function traerCabecerasModificables(arr,url,params){
    //Consulta para cargar la Cabecera de la encuesta
    rutaAplicativo = traerDireccion()+"api/";    
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
                    window.location = '../index.php';
                }
                else
                {
                    $.each(datos, function(x , y) {               
                        var idmongo= JSON.stringify(y['_id']);
                        var idMongoFinal = JSON.parse(idmongo);               
                            if(idMongoFinal.$id==params['idt'])
                        {
                            $('#id_copropiedad').val(y['id_copropiedad']);
                            $('#id_crm_persona').val(y['id_crm_persona']);
                            $('#fecha_creacion').val(y['fecha_creacion']);
                            $('#tipo').val(y['tipo']);
                            $('#datepicker').val(y['fecha_fin']);
                            $('#nombre').val(y['nombre']);
                            $('#labelnombre').text(y['nombre']);
                            $('#descripcion').val(y['descripcion']);
                            $('#estado').val(y['estado']);
                            $('#invitados').val(y['invitados']);
                            $('#odestinatario').val(y['invitados_externos']);
                        }                    
                    })
                }                
            }
        });
}


function traerCabecerasEnvio(arr,url,params){
    //Consulta para cargar la Cabecera de la encuesta
    rutaAplicativo = traerDireccion()+"api/";    
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
                    window.location = '../index.php';
                }
                else
                {
                    $.each(datos, function(x , y) {               
                        var idmongo= JSON.stringify(y['_id']);
                        var idMongoFinal = JSON.parse(idmongo);               
                        if(idMongoFinal.$id==params['idt'])
                        {
                            $('#id_copropiedad').val(y['id_copropiedad']);
                            $('#id_crm_persona').val(y['id_crm_persona']);
                            $('#fecha_creacion').val(y['fecha_creacion']);
                            $('#id_encuesta').val(idMongoFinal.$id);                            
                            $('#tipo').val(y['tipo']);
                            $('#fechaFin').val(y['fecha_fin']);
                            $('#nombre').val(y['nombre']);
                            $('#labelnombre').text(y['nombre']);
                            $('#descripcion').val(y['descripcion']);
                            $('#estado').val(y['estado']);                            
                        }                    
                    });
                }                
            }
        });
}


function traerEnvio(arr,url,params){
    //Consulta para cargar la Cabecera de la encuesta
    rutaAplicativo = traerDireccion()+"api/";    
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
                    window.location = '../index.php';
                }
                else
                {                    
                    $.each(datos, function(x , y) {
                        var idmongo= JSON.stringify(y['_id']);
                        var idMongoFinal = JSON.parse(idmongo);               
                            
                        $('#id_encuesta').val(y['id_encuesta']);
                        $('#id_copropiedad').val(y['id_copropiedad']);
                        $('#invitados').val(y['invitados']);
                        $('#odestinatario').val(y['invitados_externos']);
                        $('#asunto').val(y['asunto']);
                        $('#mensaje').val(y['mensaje']); 
                        $('#metodo').val("PUT"); 
                        
                    });
                }                
            }
        });
}

function traerCabecerasRersultados(arr,url,params){
    //Consulta para cargar la Cabecera de la encuesta
    rutaAplicativo = traerDireccion()+"api/";    
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
                    window.location = '../index.php';
                }
                else
                {
                    $.each(datos, function(x , y) {               
                        var idmongo= JSON.stringify(y['_id']);
                        var idMongoFinal = JSON.parse(idmongo);
                        $('#tituloEncuesta').html('Resultados de la Encuesta - '+y['nombre']);
                        $('#id_copropiedad').val(y['id_copropiedad']);
                        $('#id_crm_persona').val(y['id_crm_persona']);
                        $('#fecha_creacion').val(y['fecha_creacion']);
                        $('#tipo').val(y['tipo']);
                        $('#datepicker').val(y['fecha_fin']);
                        $('#nombre').val(y['nombre']);                            
                        $('#descripcion').val(y['descripcion']);
                        $('#estado').val(y['estado']);
                        $('#invitados').val(y['invitados']);
                        $('#odestinatario').val(y['invitados_externos']);
                    });
                }                
            }
        });
}

function traerSetPreguntas(arr,url,params){
    //Consulta para cargar la Cabecera de la encuesta
    rutaAplicativo = traerDireccion()+"api/";    
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
                    window.location = '../index.php';
                }
                else
                {
                    $.each(datos, function(x , y) {                        
                        //alert("estamos dentro papa");
                        //alert(x+" estos son los resultados "+y);
                        sessionStorage.setItem("idp",y);
                    });
                }                
            }
        });
}

function traerPreguntasModificables(arr,url,params){
    //Consulta para cargar la Cabecera de la encuesta
    rutaAplicativo = traerDireccion()+"api/";    
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
                    window.location = '../index.php';
                }
                else
                {
                    $.each(datos, function(x , y) {               
                        var idmongo= JSON.stringify(y['_id']);
                        var idMongoFinal = JSON.parse(idmongo);
                        if(idMongoFinal.$id==params['idt'])
                        {
                            if(y['tipo']!="abierta")
                            {
                                var newStr = y['opciones'].substring(0, y['opciones'].length-1);
                                var varios = newStr.split(",");
                                var opciones="";
                                for(i in varios)
                                {                                    
                                    var otro=varios[i].split("|");
                                    opciones+="\n"+otro[1];
                                }

                                var opciones = opciones.replace("\n", "");                                
                            }
                            else
                            {
                                var opciones= "";
                            }
                            
                            if (y['obligatorio']=="SI"){ $('#obligatoria0').prop("checked","checked");}
                            $('#id_encuesta').val(y['id_encuesta']);
                            $('#enunciado_pregunta0').val(y['pregunta']);
                            $('#nombremostrar').append(" "+y['pregunta']+"?");
                            $('#tipo_pregunta0').val(y['tipo']);
                            $('#opciones_pregunta0').val(opciones);
                            $('#regresador').attr('href', 'encuesta-editar.php?idt='+y['id_encuesta']);                        
                        }                    
                    })
                }                
            }
        });
}

function traerPreguntas(arr,url,params){
    rutaAplicativo = traerDireccion()+"api/";    
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
                    window.location = '../index.php';
                }
                else
                {
                    $.each(datos, function(x , y) 
                    {
                        var idmongo= JSON.stringify(y['_id']);
                        var idMongoFinal = JSON.parse(idmongo);
                        var t = $('#example').DataTable();
                        var opciones=""
                        if (y['tipo']=="abierta")
                        { 
                            opciones="";
                        } 
                        else 
                        {                            
                            for(i=0; i<y['opciones'].length; i++) 
                            {
                                opciones+=(y['opciones'].charAt(i)).replace("|",": ")
                            }

                        }
                        if(y['tipo']==="seleccion_multiple_multiple_respuesta")
                        {
                            var tipejo="Seleccion multiple con multiples respuestas";
                        }
                        if(y['tipo']==="seleccion_multiple_unica_respuesta")
                        {
                            var tipejo="Seleccion multiple con unica respuesta";
                        }
                        if(y['tipo']==="abierta")
                        {
                            var tipejo="Pregunta de Respuesta Abierta";
                        }
                        t.row.add([
                        '',                            
                        y['pregunta'],
                        tipejo,                        
                        opciones,
                        y['obligatorio'],
                        '<a class="btn editar solo inline" title="Editar" href="pregunta-editar.php?idt='+idMongoFinal.$id+'"></a><a class="btn borrar solo inline" title="Borrar" href="pregunta-borrar.php?idt='+idMongoFinal.$id+'"></a>'
                        //'<a id="open-editarcopripiedad" class="btn editar solo inline" href="tarea-editar.php?idt='+idMongoFinal.$id+'"></a><a class="btn completar solo inline" href="tarea-completar.php?idt='+idMongoFinal.$id+'"></a><a class="btn borrar solo inline" href="tarea-eliminar.php?idt='+idMongoFinal.$id+'"></a>'
                        ] ).draw();                        
                        //$('#example tr:last').after('<tr><td>'+y['nombre']+'</td><td>'+y['direccion']+'</td><td>'+y['telefono']+'</td><td>'+y['nit']+'</td><td><a class="btn editar solo inline" href="copropiedad-editar.html?idt='+idMongoFinal.$id+'"></a><a class="btn borrar solo inline" href="copropiedad-eliminar.html?idt='+idMongoFinal.$id+'"></a></td></tr>')                        
                    })
                }                
            }
        });
}

function traerDatosEliminables(arr,url,params){
    //Consulta para cargar la Cabecera de la encuesta
    rutaAplicativo = traerDireccion()+"api/";    
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
                    window.location = '../index.php';
                }
                else
                {
                    $.each(datos, function(x , y) {               
                        var idmongo= JSON.stringify(y['_id']);
                        var idMongoFinal = JSON.parse(idmongo);               
                        if(idMongoFinal.$id==params['idt'])
                        {
                            $('#id_copropiedad').val(y['id_copropiedad']);
                            $('#id_crm_persona').val(y['id_crm_persona']);
                            $('#fecha_creacion').val(y['fecha_creacion']);
                            $('#tipo').val(y['tipo']);
                            $('#fecha_fin').val(y['fecha_fin']);
                            $('#nombre').val(y['nombre']);
                            $('#nombremostrar').append(" "+y['nombre']+"?");
                            $('#descripcion').val(y['descripcion']);
                            $('#estado').val(y['estado']);
                            $('#invitados').val(y['invitados']);
                            $('#invitados_externos').val(y['invitados_externos']);
                        }                    
                    })
                }                
            }
        });
}

function TraerUsuarioCopropiedad(arr,url,metodo){
    rutaAplicativo = traerDireccion()+"api/admin/copropiedad/";    
    $.ajax(
        {
            url: rutaAplicativo+url,
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

function refreshWindow(){
    if(sessionStorage.getItem("referer").lenght < 2){window.location = 'index.php'}else{window.location = sessionStorage.getItem("referer");};
}

function TraerModulosCopropiedad(arr,url,metodo){     
    rutaAplicatico = traerDireccion()+"api/admin/copropiedad/";
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

