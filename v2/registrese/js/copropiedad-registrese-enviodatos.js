function envioFormulario()
{
        const rutaAplicativo = "http://auth.teleinte.com/auth/";        
        var arr = 
        {
          token:sessionStorage.getItem("token"),
          body:
          {
            nombre:$('#nombre').val(),
            estado:"0",
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
        const rutaAplicativo = "http://auth.teleinte.com/auth/pwd";
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
                    $('#alertas').html('<div class="alert alert-success" style="height:auto; margin:5px auto;">Tu proceso de activación ha sido satisfactorio, puedes <a class="btn alertas" href="http://aws02.sinfo.co/v2/">iniciar sesión en el copropiedad</a></div>');
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
        const rutaAplicativo = "http://auth.teleinte.com/auth/pwd";
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
                    $('#alertas').html('<div class="alert alert-success" style="height:auto; margin:5px auto;">Tu proceso de cambio de contraseña ha sido satisfactorio, puedes <a class="btn alertas" href="http://aws02.sinfo.co/v2/">iniciar sesión en copropiedad</a></div>');
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
            var msgDivididoDos = JSON.stringify(mensaje.message);
            if(mensaje.status)
            {
                $('#alertas').html('<div class="alert alert-success" style="height:auto; margin:5px auto;">Si la dirección de correo que escribiste es correcta, recibirás un correo de nuevo para finalizar con la activación de tu usuario.</a></div>');
            }
            else
            {
                $('#alertas').html('<div class="alert alert-error" style="height:auto; margin:5px auto;">Ha ocurrido un error enviando el correo de activación, por favor <a class="btn alertaserror" href="../contacto">contacta con nuestro departamento de servicio al cliente</a></div>');
            }
        }
    })        
}
function envioFormularioCambio()
{
    const rutaAplicativo = "http://aws02.sinfo.co/api/mailer/mail/usuario/cambiopassword/";
    const rutaActivacion = "http://aws02.sinfo.co/v2/registrese/confirmar-password.php?token=";
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
                $('#alertas').html('<div class="alert alert-success" style="height:auto; margin:5px auto;">Si la dirección de correo que escribiste es correcta, recibirás un correo para finalizar el proceso de cambio de contraseña.</a></div>');
            }
            else
            {
                $('#alertas').html('<div class="alert alert-error" style="height:auto; margin:5px auto;">Ha ocurrido un error enviando el correo de cambio de contraseña, por favor <a class="btn alertaserror" href="../contacto">contacta con nuestro departamento de servicio al cliente</a></div>');
            }
        }
    })        
}
function CreaToken(AutDeUsuario, usuario)
{
    //definicion de constantes
    const rutaAplicativo = "http://auth.teleinte.com/token/"; 
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