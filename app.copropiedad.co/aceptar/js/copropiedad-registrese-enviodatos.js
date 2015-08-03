function envioFormulario()
{
    var rutaAplicativo = "https://auth.sinfo.co/auth/";        
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
        id_crm:Math.floor((Math.random() * 1000000) + 1),
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
            enviocorreoNotificacion();
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
function envioFormularioPassword()
{
    if($('#password').val() == $('#passwordconf').val())
    {
        var rutaAplicativo = "https://auth.sinfo.co/auth/pwd";
        var arr = 
        {
          token:$('#token').val(),
          body:
          {
            email:$('#email').val(),
            password:$('#password').val()
          }
        };
        $.ajax(
        {
            url: rutaAplicativo,
            type: "PUT",
            data: JSON.stringify(arr),
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            async: true,
            success: function(msg) 
            {
                var msgDividido = JSON.stringify(msg);
                var mensaje =  JSON.parse(msgDividido);
                var msgDivididoDos = JSON.stringify(mensaje.message);
                if(mensaje.status)
                {
                    enviocorreopwd();
                    $('#alertas').html('<div class="alert alert-success" style="height:auto; margin:5px auto;">Tu proceso de activación ha sido satisfactorio, puedes <a class="btn alertas" href="https://aws02.sinfo.co/">iniciar sesión en el copropiedad</a></div>');
                }
                else if(mensaje.error.indexOf("Modify: No such object") != -1)
                {
                    $('#alertas').html('<div class="alert alert-error" style="height:auto; margin:5px auto;">Tu usuario no existe en el sistema y no es posible activarlo. Puedes iniciar el proceso de registro haciendo click <a class="btn alertaserror" href="index.php"> aquí. </a></div>');
                }
                else
                {
                    $('#alertas').html('<div class="alert alert-error" style="height:auto; margin:5px auto;">Ha ocurrido un error activando tu usuario, por favor <a class="btn alertaserror" href="../contacto">contacta con nuestro departamento de servicio al cliente</a></div>');
                }
            }
        });
    }
    else
    {
        $('#alertas').html('<div class="alert alert-error" style="height:auto; margin:5px auto;">Las contraseñas que has escrito no coinciden, por favor intentalo de nuevo.</div>');
    }
}
function envioFormularioPasswordCambio()
{
    if($('#password').val() == $('#passwordconf').val())
    {
        var rutaAplicativo = "https://auth.sinfo.co/auth/pwd";
        var arr = 
        {
          token:$('#token').val(),
          body:
          {
            email:$('#email').val(),
            password:$('#password').val()
          }
        };
        $.ajax(
        {
            url: rutaAplicativo,
            type: "PUT",
            data: JSON.stringify(arr),
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            async: true,
            success: function(msg) 
            {
                var msgDividido = JSON.stringify(msg);
                var mensaje =  JSON.parse(msgDividido);
                var msgDivididoDos = JSON.stringify(mensaje.message);
                if(mensaje.status)
                {
                    enviocorreopwdchg();
                    $('#alertas').html('<div class="alert alert-success" style="height:auto; margin:5px auto;">Tu proceso de cambio de contraseña ha sido satisfactorio, puedes <a class="btn alertas" href="https://app.copropiedad.co/">iniciar sesión en copropiedad</a></div>');
                }
                else if(mensaje.error.indexOf("Modify: No such object") != -1)
                {
                    $('#alertas').html('<div class="alert alert-error" style="height:auto; margin:5px auto;">No es posible realizar el cambio de contraseña, tu correo no se encuentra registrado en el sistema. Puedes iniciar el proceso de registro haciendo click <a class="btn alertaserror" href="index.php"> aquí. </a></div>');
                }
                else
                {
                    $('#alertas').html('<div class="alert alert-error" style="height:auto; margin:5px auto;">Ha ocurrido un error activando tu usuario, por favor <a class="btn alertaserror" href="../contacto">contacta con nuestro departamento de servicio al cliente</a></div>');
                }
            }
        });
    }
    else
    {
        $('#alertas').html('<div class="alert alert-error" style="height:auto; margin:5px auto;">Las contraseñas que has escrito no coinciden, por favor intentalo de nuevo.</div>');
    }
}
function envioFormularioLink()
{
    var rutaAplicativo = traerDireccion()+"api/mailer/mail/registro/activacion/";
    var rutaActivacion = traerDireccion()+"registrese/activar.php?token=";
    var rutaAplicativoAuth = "https://auth.sinfo.co/auth/verify/";
    var existe = false;

    var code = btoa(encodeURIComponent($('#nombre').val()) + "^cp-" + $('#email').val());
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
                              nombre: $('#nombre').val(),
                              link: rutaActivacion + encodeURIComponent(sessionStorage.getItem('token')) + "&code=" + code,
                              email: $('#email').val()
                           }
                        ],
                  }
              }; 

    var arrAuth =   {
                      token:$('#token').val(),
                      body:
                      {
                        email:"cp-" + $('#email').val()
                      }
                    };
    $.ajax(
    {
        url: rutaAplicativoAuth,
        type: metodo,
        data: JSON.stringify(arrAuth),
        contentType: 'application/json; charset=utf-8',
        dataType: 'json',
        async: false,
        success: function(msg) 
        {
            var msgDividido = JSON.stringify(msg);
            var mensaje =  JSON.parse(msgDividido);
            var msgDivididoDos = JSON.stringify(mensaje.message);
            existe = mensaje.status;
        }
    });

    if(existe)
    {
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
                var msgDivididoDos = JSON.stringify(mensaje.message);
                if(mensaje.status)
                {
                    $('#alertas').html('<div class="alert alert-success" style="height:auto; margin:5px auto;">Recibirás un correo de nuevo para finalizar con la activación de tu usuario.</a></div>');
                }
                else
                {
                    $('#alertas').html('<div class="alert alert-error" style="height:auto; margin:5px auto;">Ha ocurrido un error enviando el correo de activación, por favor <a class="btn alertaserror" href="../contacto">contacta con nuestro departamento de servicio al cliente</a></div>');
                }
            }
        });
    }
    else
    {
        $('#alertas').html('<div class="alert alert-error" style="height:auto; margin:5px auto;">Tu usuario no se encuentra registrado en el sistema <a class="btn alertaserror" href="../registrese"> Registrate </a></div>');
    }    
}
function envioFormularioCambio()
{
    var rutaAplicativo = traerDireccion()+"api/mailer/mail/usuario/cambiopassword/";
    var rutaActivacion = traerDireccion()+"registrese/confirmar-password.php?token=";
    var rutaAplicativoAuth = "https://auth.sinfo.co/auth/verify/";
    var existe = false;

    var code = btoa(encodeURIComponent($('#nombre').val()) + "^cp-" + $('#email').val());
    var metodo = "POST";
    var arr = {
                  token:sessionStorage.getItem('token'),
                  body:
                  {  
                        id_crm_persona:"registro",
                        fecha_solicitud:new Date(),
                        nombre_remitente:"registro",
                        tipo:"cambiopasswordinicio",
                        destinatarios:[  
                           {  
                              nombre: $('#nombre').val(),
                              link: rutaActivacion + encodeURIComponent(sessionStorage.getItem('token')) + "&code=" + code,
                              email: $('#email').val()
                           }
                        ],
                  }
                }; 

    var arrAuth =   {
                      token:$('#token').val(),
                      body:
                      {
                        email:"cp-" + $('#email').val()
                      }
                    };
    $.ajax(
    {
        url: rutaAplicativoAuth,
        type: metodo,
        data: JSON.stringify(arrAuth),
        contentType: 'application/json; charset=utf-8',
        dataType: 'json',
        async: false,
        success: function(msg) 
        {
            var msgDividido = JSON.stringify(msg);
            var mensaje =  JSON.parse(msgDividido);
            var msgDivididoDos = JSON.stringify(mensaje.message);
            existe = mensaje.status;
        }
    });
    
    if(existe)
    {
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
                var msgDivididoDos = JSON.stringify(mensaje.message);
                if(mensaje.status)
                {
                    $('#alertas').html('<div class="alert alert-success" style="height:auto; margin:5px auto;">Recibirás un correo para finalizar el proceso de cambio de contraseña.</a></div>');
                }
                else
                {
                    $('#alertas').html('<div class="alert alert-error" style="height:auto; margin:5px auto;">Ha ocurrido un error enviando el correo de cambio de contraseña, por favor <a class="btn alertaserror" href="../contacto">contacta con nuestro departamento de servicio al cliente</a></div>');
                }
            }
        })    
    }
    else
    {
        $('#alertas').html('<div class="alert alert-error" style="height:auto; margin:5px auto;">Tu usuario no se encuentra registrado en el sistema <a class="btn alertaserror" href="../registrese"> Registrate </a></div>');
    }        
}
function activarUsuarioIdle()
{
    if($('#password').val() == $('#passwordconf').val())
    {
        var rutaAplicativo = "https://auth.sinfo.co/auth/activate";
        var arr = 
        {
          token:$('#token').val(),
          body:
          {
            email:$('#email').val()
          }
        };
        $.ajax(
        {
            url: rutaAplicativo,
            type: "PUT",
            data: JSON.stringify(arr),
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            async: true,
            success: function(msg) 
            {
                var msgDividido = JSON.stringify(msg);
                var mensaje =  JSON.parse(msgDividido);
                var msgDivididoDos = JSON.stringify(mensaje.message);
                if(mensaje.status)
                {
                    enviocorreopwd();
                    $('#alertas').html('<div class="alert alert-success" style="height:auto; margin:5px auto;">Tu proceso de activación ha sido satisfactorio, puedes <a class="btn alertas" href="https://app.copropiedad.co/">iniciar sesión en el copropiedad</a></div>');
                }
                else if(mensaje.error.indexOf("Modify: No such object") != -1)
                {
                    $('#alertas').html('<div class="alert alert-error" style="height:auto; margin:5px auto;">Tu usuario no existe en el sistema y no es posible activarlo. Puedes iniciar el proceso de registro haciendo click <a class="btn alertaserror" href="index.php"> aquí. </a></div>');
                }
                else
                {
                    $('#alertas').html('<div class="alert alert-error" style="height:auto; margin:5px auto;">Ha ocurrido un error activando tu usuario, por favor <a class="btn alertaserror" href="../contacto">contacta con nuestro departamento de servicio al cliente</a></div>');
                }
            }
        });
    }
    else
    {
        $('#alertas').html('<div class="alert alert-error" style="height:auto; margin:5px auto;">Las contraseñas que has escrito no coinciden, por favor intentalo de nuevo.</div>');
    }
}
function CreaToken(AutDeUsuario, usuario)
{
    //definicion de constantes
    var rutaAplicativo = "https://auth.sinfo.co/token/"; 
    var arr = {body:{autkey:AutDeUsuario,user:usuario}};            
    $.post(rutaAplicativo, JSON.stringify(arr))
     .done(function(data){
         var msgDividido = JSON.stringify(data);
         var mensaje =  JSON.parse(msgDividido);
         var msgDivididoDos = JSON.stringify(mensaje.message);
         if(mensaje.status)
         {
            var datos = JSON.parse(msgDivididoDos);
            $.each(datos, function(x , y) 
            {                     
                sessionStorage.setItem(x, y);              
            });                
         }
         else
         {
            return "notoken";
         }
     });
}