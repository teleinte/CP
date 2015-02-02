function envioFormularioLDAP()
{
        const rutaAplicativo = "http://auth.teleinte.com/auth/";
        var arr = 
        {
          token:sessionStorage.getItem("token"),
          body:
          {
            nombre:$('#nombre').val(),
            estado:"1",
            apellido:$('#apellido').val(),
            email:"cp-" + $('#email').val(),
            genero:" ",
            nacionalidad:" ",
            lugarNacimiento:" ",
            paisNacimiento:"CO",
            fechaNacimiento:"01/01/1901",
            idioma:"Español",
            id_crm:Math.floor((Math.random() * 1000) + 1),
            password:"19283uj9qwnoa98ndfnsdf",
            tipoDocumento:"CC",
            numeroDocumento:"123465789"
          }
        };
        $.post(rutaAplicativo, JSON.stringify(arr))
            .done(function(data){
                var msgDividido = JSON.stringify(data);
                var mensaje =  JSON.parse(msgDividido);
                var msgDivididoDos = JSON.stringify(mensaje.message);
                if(mensaje.status)
                {
                    enviocorreo();
                    $('#alertas').html('<div class="alert alert-success" style="height:auto; margin:5px auto;">Hemos enviado un correo de verificación al email que has registrado. Encontrarás un vínculo para continuar con el proceso de activación.</div>');
                }
                else
                {
                    if(mensaje.error.indexOf("Add: Already exists") != -1)
                    {
                        $('#alertas').html('<div class="alert alert-error" style="height:auto; margin:5px auto;">Tu usuario ya ha sido registrado, <a class="btn alertaserror" href="cambiar-password.php"> olvidaste tu contraseña? </a></div>');
                    }
                    else
                    {
                        $('#alertas').html('<div class="alert alert-error" style="height:auto; margin:5px auto;">Ha ocurrido un error creando tu usuario, por favor <a class="btn alertaserror" href="../contacto">contacta con nuestro departamento de servicio al cliente</a></div>');
                    }
                }
            });
}

function enviocorreo(){     
        const rutaAplicativo = "http://aws02.sinfo.co/api/mailer/mail/registro/activacion/";
        const rutaActivacion = "http://aws02.sinfo.co/v2/registrese/activar.php?token=";
        const code = btoa(encodeURIComponent($('#nombre').val()) + "^cp-" + $('#email').val());
        console.log(rutaActivacion + encodeURIComponent(sessionStorage.getItem('token')) + "&code=" + encodeURIComponent(code));
        const metodo = "POST";
        var arr = {
                      token:sessionStorage.getItem('token'),
                      body:
                      {  
                            id_crm_persona:"registro",
                            fecha_solicitud:new Date(),
                            nombre_remitente:"registro",
                            destinatarios:[  
                               {  
                                  nombre: $('#nombre').val(),
                                  link: rutaActivacion + encodeURIComponent(sessionStorage.getItem('token')) + "&code=" + code,
                                  email: $('#email').val()
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
            async: true,
            success: function(msg) 
            {
                var msgDividido = JSON.stringify(msg);
                var mensaje =  JSON.parse(msgDividido);
                console.log(msg);
            }
        })        
}


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
                alert("paso el envio");
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
                    $('#alertas').html('<div class="alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Tip:</strong> Dato insertado Correctamente.</div>')
                    envioFormularioLDAP()
                    sleep(3000);
                    window.location = 'usuario.php'
                }
                else {$('#resultado').html(mensaje.error);}
            }
        })        
}

function editaFormulario(arr,url,params,metodo,direccion,nombre){    
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
                    window.location = '../../index.php';
                }
                if(mensaje.status)
                {                  
                    $('#alertas').html('<div class="alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Tip:</strong> Dato insertado Correctamente.</div>')
                    //envioFormularioLDAP()
                    sleep(3000);
                    window.location = 'usuario.php'
                }
                else {$('#resultado').html(mensaje.error);}
            }
        })        
}



function sleep(milliseconds) { 
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}


function traerDatos(arr,url,params)
{
    //alert(JSON.stringify(arr));
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
                    window.location = '../../index.php';
                }
                else
                {
                    $.each(datos, function(x , y) 
                    {
                        var idmongo= JSON.stringify(y['_id']);
                        var idMongoFinal = JSON.parse(idmongo);
                        var t = $('#example').DataTable();
                        var enlace="";
                        if(y['tipo']=="proveedor")
                        {
                            enlace='<a id="open-editarcopripiedad" class="btn editar solo inline" href="proveedor-editar.php?idt='+idMongoFinal.$id+'"></a><a class="btn borrar solo inline" href="proveedor-eliminar.php?idt='+idMongoFinal.$id+'"></a><a class="btn agregar solo inline" href="proveedor-nuevoservicio.php?idt='+idMongoFinal.$id+'"></a>'
                            if(y['contactos'])
                            {
                                t.row.add( [
                                    '',                            
                                    y['nombre'],
                                    y['empresa'],
                                    y['telefono'],                            
                                    y['email'],
                                    y['descripcion'],
                                    y['tipo'],
                                    enlace                            
                                ] ).draw();
                                var datosAntesde = JSON.stringify(y['contactos']);
                                var datosDespues = JSON.parse(datosAntesde);
                                $.each(datosDespues, function(primero , dos){
                                  var datosfinales = JSON.stringify(dos);
                                  var Final = JSON.parse(datosfinales);
                                  
                                   t.row.add( [
                                        '',                            
                                        Final['nombre'],
                                        Final['empresa'],
                                        Final['telefono'],                            
                                        Final['email'],
                                        Final['descripcion'],
                                        Final['tipo'],
                                        enlace                            
                                    ] ).draw();
                                })

                            }
                            else
                            {
                                t.row.add( [
                                    '',                            
                                    y['nombre'],
                                    y['empresa'],
                                    y['telefono'],                            
                                    y['email'],
                                    y['descripcion'],
                                    y['tipo'],
                                    enlace                            
                                ] ).draw();
                            }

                        }
                        if(y['tipo']=="residente")
                        {
                            enlace='<a id="open-editarcopripiedad" class="btn editar solo inline" href="usuario-editar.php?idt='+idMongoFinal.$id+'"></a><a class="btn borrar solo inline" href="usuario-eliminar.php?idt='+idMongoFinal.$id+'"></a>'
                            t.row.add( [
                            '',                            
                            y['nombre'],
                            y['empresa'],
                            y['telefono'],                            
                            y['email'],
                            y['descripcion'],
                            y['tipo'],
                            enlace                            
                        ] ).draw();
                        }                        
                        //$('#tableContainer > tbody:last').append('<tr><td>'+y['nombre_copropiedad']+'</td><td>'+y['tipo_unidad']+'</td><td>'+y['detalle']+'</td><td><a class="btn editar solo inline" href="inmueble-editar.html?idt='+idMongoFinal.$id+'"></a><a class="btn borrar solo inline" href="inmueble-eliminar.html?idt='+idMongoFinal.$id+'"></a></td></tr>')
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
                        $('#unidad').append("<option value='"+idMongoFinal.$id+"1|"+y['detalle']+"'>"+y['detalle']+"</option>")
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
                    window.location = '../../index.php';                      
                }
                else
                {
                    $.each(datos, function(x , y) {               
                        var idmongo= JSON.stringify(y['_id']);
                        var idMongoFinal = JSON.parse(idmongo);
                        var seleccionado="";
                        var partido="";
                        if(idMongoFinal.$id==params['idt'])
                        {
                            seleccionado=y['unidad'];
                            partido=seleccionado.split("|");
                            $('#creado_por').val(y['creado_por']);
                            $('#fecha_creacion').val(y['fecha_creacion']);
                            $('#id_copropiedad').val(y['id_copropiedad']);
                            $('#id_crm_persona').val(y['id_crm_persona']);
                            $('#nombre').val(y['nombre']);
                            $('#telefono').val(y['telefono']);
                            $('#email').val(y['email']);
                            $('#empresa').val(y['empresa']);
                            $('#unidad').append('<option value="'+y['unidad']+'" selected>'+partido[1]+'</option>')
                            //$("#unidad option[value="+y['unidad']+"]").attr("selected",true);
                            //$('#unidad').val(y['unidad']);
                            $('#estado').val(y['estado']);
                            $('#tipo').val(y['tipo']);
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



function traerDatosMProveedor(arr,url,params)
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
                    window.location = '../../index.php';                      
                }
                else
                {
                    $.each(datos, function(x , y) {               
                        var idmongo= JSON.stringify(y['_id']);
                        var idMongoFinal = JSON.parse(idmongo);
                        var seleccionado="";
                        var partido="";
                        if(idMongoFinal.$id==params['idt'])
                        {
                            $('#creado_por').val(y['creado_por']);
                            $('#fecha_creacion').val(y['fecha_creacion']);
                            $('#id_copropiedad').val(y['id_copropiedad']);
                            $('#id_crm_persona').val(y['id_crm_persona']);
                            $('#nombreProveedor').val(y['nombre']);
                            $('#nombremostrar').append(" "+y['nombre']+"?");
                            $('#telefonoProveedor').val(y['telefono']);
                            $('#emailProveedor').val(y['email']);                            
                            $('#descripcionProveedor').val(y['descripcion']);
                            $('#tipoProveedor').val(y['tipo']);
                            $('#estado').val(y['estado']);
                            $('#telefonoDosProveedor').val(y['telefonoDos']);                            
                            var datosAntesde = JSON.stringify(y['contactos']);
                            var datosDespues = JSON.parse(datosAntesde);
                            var contador=1;
                            $.each(datosDespues, function(primero , dos){
                                var datosfinales = JSON.stringify(dos);
                                var Final = JSON.parse(datosfinales);                                
                                $('#nombre'+contador).val(Final['nombre']);
                                $('#telefono'+contador).val(Final['telefono']);
                                $('#telefono2'+contador).val(Final['telefonoDos']);
                                $('#mail'+contador).val(Final['email']);
                                contador++;                               
                             })
                        }                    
                    })
                }                
            }
        });
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
                            $('#empresa').val(y['empresa']);
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

function TraerModulosCopropiedad(arr,url,metodo){ 
    //alert("Ahora Si");
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

