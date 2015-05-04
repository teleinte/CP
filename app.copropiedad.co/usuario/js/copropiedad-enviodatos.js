function envioFormulario(arr,url,params,metodo){  
    var rutaAplicatico = "https://app.copropiedad.co/api/unidad/";
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
                setTimeout(refreshWindow, 4000);
                //window.location = '../../index.html';
            }
            if(mensaje.status)
            {                  
                $.each(mensaje.message, function(x , y) 
                {
                    sessionStorage.setItem("insertado",y);
                });
            }
            else {$('#resultado').html(mensaje.error);}
        }
    });
}

function envioFormularioDos(arr,url,metodo){
        var rutaAplicatico = "https://app.copropiedad.co/api/admin/copropiedad/";
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
                    window.location = '../../index.php';
                }                
            }
        })        
}


function envioFormularioModificado(arr,url,params,metodo){  
    var rutaAplicatico = "https://app.copropiedad.co/api/";
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
                setTimeout(refreshWindow, 4000);
                //window.location = '../../index.html';
            }
            if(mensaje.status)
            {                  
                $('#alertas').html('<div class="alert alert-dismissable alert-success" style="height:10px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Dato modificado correctamente.</div>');
            }
            else {$('#resultado').html(mensaje.error);}
        }
    });
}





function envioFormularioUsuario(arr,url,params,metodo){  
        var rutaAplicatico = "https://app.copropiedad.co/api/admin/copropiedad/";
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
                    setTimeout(refreshWindow, 4000);
                    window.location = '../../index.html';
                }
                if(mensaje.status)
                {                  
                    $.each(mensaje.message, function(x , y) 
                    {
                        sessionStorage.setItem("insertadoUsuario",y);
                    });
                }
                else {$('#resultado').html(mensaje.error);}
            }
        });
}

function envioFormularioUsuarioEncargado(arr,url,params,metodo, numero){  
    if(numero ===0)
    {
        //alert("Si es igual a cero");
        var rutaAplicatico = "https://app.copropiedad.co/api/unidad/";
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
                    setTimeout(refreshWindow, 4000);
                    window.location = '../../index.html';
                }
                if(mensaje.status)
                {                  
                    $.each(mensaje.message, function(x , y) 
                    {
                        sessionStorage.setItem("retornadoUsuarioEncargado",y);
                        envioFormularioLDAP(0);
                    });
                }
                else {$('#resultado').html(mensaje.error);}
            }
        });        
    }
    else
    {
        envioFormularioLDAP(numero);
    }
}


function envioUsuarioEncargado(arr,url,params,metodo){  
    
    var rutaAplicatico = "https://app.copropiedad.co/api/unidad/";
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
                window.location = '../../index.html';
            }
            if(mensaje.status)
            {                  
                $('#alertas').html('<div class="alert alert-dismissable alert-success" style="height:10px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Dato modificado correctamente.</div>');
            }
            else {$('#resultado').html(mensaje.error);}
        }
    });        
   
   
}


function envioFormularioLDAP(numero)
{
    var arr = 
    {
      token:sessionStorage.getItem("token"),
      body:
      {
        nombre:$('#nombre'+numero).val(),
        estado:"1",
        apellido:$('#apellido'+numero).val(),
        email:"cp-" + $('#email'+numero).val(),
        genero:" ",
        nacionalidad:" ",
        lugarNacimiento:" ",
        paisNacimiento:"CO",
        fechaNacimiento:"01/01/1901",
        idioma:"Español",
        id_crm: sessionStorage.getItem('id_crmPro'),
        password:"19283uj9qwnoa98ndfnsdf",
        tipoDocumento:"CC",
        numeroDocumento:"123465789"
      }
    };    
    //alert(JSON.stringify(arr));    
    $.ajax(
    {
        url: "https://auth.sinfo.co/auth/",
        type: "POST",
        data: JSON.stringify(arr),
        contentType: 'application/json; charset=utf-8',
        dataType: 'json',
        async: false,
        success: function(msg)
        {
            var msgDividido = JSON.stringify(msg);
            var mensaje =  JSON.parse(msgDividido);
            var msgDivididoDos = JSON.stringify(mensaje.message);
            if(mensaje.status)
            {
                enviocorreo(numero);
                $('#alertas').html('<div class="alert alert-success" style="height:auto; margin:5px auto;">Datos insertados correctamente, se ha enviado un correo de invitación a los nuevos usuarios registrados.</div>');
                window.location = '../../index.php';
            }
            else
            {
                enviocorreo(numero);
                // if(mensaje.error.indexOf("Add: Already exists") != -1)
                // {
                //     $('#alertas').html('<div class="alert alert-error" style="height:auto; margin:5px auto;">Tu usuario ya ha sido registrado, <a class="btn alertaserror" href="cambiar-password.php"> olvidaste tu contraseña? </a></div>');
                // }
                // else
                // {
                //     $('#alertas').html('<div class="alert alert-error" style="height:auto; margin:5px auto;">Ha ocurrido un error creando tu usuario, por favor <a class="btn alertaserror" href="../contacto">contacta con nuestro departamento de servicio al cliente</a></div>');
                // }
            }
        }

    });
}


function enviocorreo(numero){     
        var rutaAplicativo = "https://app.copropiedad.co/api/mailer/mail/registro/bienvenida/";
        var rutaActivacion = "https://app.copropiedad.co/registrese/activar.php?token=";
        var code = btoa(encodeURIComponent($('#nombre'+numero).val()) + "^cp-" + $('#email'+numero).val());
        //alert(rutaActivacion + encodeURIComponent(sessionStorage.getItem('token')) + "&code=" + encodeURIComponent(code));
        var metodo = "POST";
        var arr = {
        token:sessionStorage.getItem('token'),
        body:
        {  
              id_crm_persona:"registro",
              fecha_solicitud:new Date(),
              nombre_remitente:"registro",
              destinatarios:[  
                 {  
                    user: $('#email'+numero).val(),
                    link: rutaActivacion + encodeURIComponent(sessionStorage.getItem('token')) + "&code=" + code,
                    email: $('#email'+numero).val()
                 }
              ],
        }
      }; 
        $.ajax(
        {
            url: rutaAplicativo,
            type: metodo,
            data: JSON.stringify(arr),
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            async: false,
            success: function(msg) 
            {
                var msgDividido = JSON.stringify(msg);
                var mensaje =  JSON.parse(msgDividido);             
            }
        });
}

function traerDatos(arr,url,params)
{
    var rutaAplicatico = "https://app.copropiedad.co/api/unidad/";
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
                    window.location = '../../index.php';
                }
                else
                {
                    $.each(datos, function(x , y) 
                    {
                        $.each(y, function(alfa , beta) {if(alfa=="_id"){$.each(beta, function(uno ,dos){idmongo=dos});}});
                        var t = $('#example').DataTable();                            
                        var enlace='<a class="btn editar solo inline" title="Editar" href="contacto-editar.php?idt='+idmongo+'"></a>';
                        //enlace='<a id="open-editarcopripiedad" class="btn editar solo inline" href="usuario-editar.php?idt='+idMongoFinal.$id+'"></a><a class="btn borrar solo inline" href="usuario-eliminar.php?idt='+idMongoFinal.$id+'"></a>'
                        t.row.add( [
                        '',                            
                        y['identificador'],                            
                        y['tipo_unidad'],
                        enlace                            
                        ] ).draw();
                        //$('#tableContainer > tbody:last').append('<tr><td>'+y['nombre_copropiedad']+'</td><td>'+y['tipo_unidad']+'</td><td>'+y['detalle']+'</td><td><a class="btn editar solo inline" href="inmueble-editar.html?idt='+idMongoFinal.$id+'"></a><a class="btn borrar solo inline" href="inmueble-eliminar.html?idt='+idMongoFinal.$id+'"></a></td></tr>')
                    });
                }                
            }
        });
}

function traerContactos(arr,url,params)
{
    var rutaAplicatico = "https://app.copropiedad.co/api/";
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
                    $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>');
                    window.location = '../../index.php';
                }
                else
                {
                    $.each(datos, function(x , y) 
                    {
                        $.each(y, function(alfa , beta) {if(alfa=="_id"){$.each(beta, function(uno ,dos){idmongo=dos});}});
                        var t = $('#example').DataTable();                            
                        var enlace='<a class="btn editar solo inline" title="Editar" href="usuario-editar.php?idt='+idmongo+'&rg='+params['idt']+'"></a><a class="btn borrar solo inline" title="Borrar" href="usuario-eliminar.php?idt='+idmongo+'&rg='+params['idt']+'"></a><a class="btn completar solo inline" title="Seleccionar como encargado" href="usuario-cambiar.php?idt='+idmongo+'&rg='+params['idt']+'"></a>';
                        //enlace='<a id="open-editarcopripiedad" class="btn editar solo inline" href="usuario-editar.php?idt='+idMongoFinal.$id+'"></a><a class="btn borrar solo inline" href="usuario-eliminar.php?idt='+idMongoFinal.$id+'"></a>'
                        t.row.add( [
                        '',                            
                        y['nombre'],
                        y['telefono'],
                        y['celular'],
                        y['email'],
                        y['empresa'],
                        enlace                            
                        ] ).draw();
                        //$('#tableContainer > tbody:last').append('<tr><td>'+y['nombre_copropiedad']+'</td><td>'+y['tipo_unidad']+'</td><td>'+y['detalle']+'</td><td><a class="btn editar solo inline" href="inmueble-editar.html?idt='+idMongoFinal.$id+'"></a><a class="btn borrar solo inline" href="inmueble-eliminar.html?idt='+idMongoFinal.$id+'"></a></td></tr>')
                    });
                }                
            }
        });
}



function traerClienteModificables(arr,url,params){
    //Consulta para cargar la Cabecera de la encuesta
    rutaAplicativo = "https://app.copropiedad.co/api/";    
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
                        $('#id_unidad').val(idMongoFinal.$id);
                        $('#id_copropiedad').val(y['id_copropiedad']);
                        $('#id_crm_persona').val(y['id_crm_persona']);
                        $('#nombre_copropiedad').val(y['nombre_copropiedad']);
                        $('#tipo').val(y['tipo_unidad']);
                        $('#identificador').val(y['identificador']);                            
                        $('#estado').val(y['estado']);
                        $('#detalle').val(y['detalle']);
                        $('#fecha_creacion').val(y['fecha_creacion']);                            
                    }                    
                });
            }                
        }
    });
}


function traerDatosMProveedor(arr,url,params){
    //Consulta para cargar la Cabecera de la encuesta
    rutaAplicativo = "https://app.copropiedad.co/api/";    
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
                            $('#id_usuario').val(idMongoFinal.$id);
                            $('#creado_por').val(y['creado_por']);
                            $('#fecha_creacion').val(y['fecha_creacion']);
                            $('#id_copropiedad').val(y['id_copropiedad']);
                            $('#id_crm_persona').val(y['id_crm_persona']);
                            $('#nombremostrar').text("Seguro desea eliminar el usuario: "+y['nombre']);                            
                            $('#nombreEncargado').text("Seguro desea dejar encargado al usuario "+y['nombre']+" para temas contables? ");
                            $('#nombre').val(y['nombre']);                            
                            $('#telefono').val(y['telefono']);
                            $('#celular').val(y['celular']);
                            $('#email').val(y['email']);
                            $('#empresa').val(y['empresa']);
                            $('#unidad').val(y['unidad']);
                            $('#tipo').val(y['tipo']);
                            $('#estado').val(y['estado']);
                            $('#grupo').val(y['grupo']);                            
                        }                    
                    });
                }                
            }
        });
}


function traerDatosExtraModificables(arr,url,params){
    //Consulta para cargar la Cabecera de la encuesta
    rutaAplicativo = "https://app.copropiedad.co/api/"; 
    
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
                    $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Tip:</strong> NO PUDO LISTAR POR TOKEN, Solicitando un nuevo token por favor espere.</div>')
                    window.location = '../index.php';
                }
                else
                {  
                    $.each(datos, function(x , y) { 
                        var idmongo= JSON.stringify(y['_id']);
                        var idMongoFinal = JSON.parse(idmongo);
                            $('#id_extra').val(idMongoFinal.$id);                            
                            $('#nombre_copropiedad').val(y['nombre_copropiedad']);
                            $('#id_crm_persona_extra').val(y['id_crm_persona']);
                            $('#unidad').val(y['unidad']);
                            $('#encargado').val(y['encargado']);
                            $('#Uencargado').text("Contacto Encargado: "+y['encargado']);                            
                            $('#id_usuario').val(y['id_usuario']);
                            $('#email').val(y['email']);
                            $('#coeficiente').val(y['coeficiente']);
                            $('#canon').val(y['canon']);
                            $('#proveedor').val(y['proveedor']);
                    });
                }                
            }
        });
}

function TraerModulosCopropiedad(arr,url,metodo){ 
    //alert("Ahora Si");
    var rutaAplicatico = "https://app.copropiedad.co/api/admin/copropiedad/";
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
                    $.each(mensaje.message, function(x , y) 
                    {
                        sessionStorage.setItem("insertadoUsuario",y);
                    });
                }                
            }
        });
}

