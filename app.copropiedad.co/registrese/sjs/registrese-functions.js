function CrearUsuario(actualurl) //--OK
{
    var rutaAplicativo = "https://appdes.copropiedad.co/api/estados/estados/";  
    var crm = Math.floor((Math.random() * 100000000000) + 1);
    $("#enviarregistro").val('Enviando datos...');
    var existe = existeLDAP($("#email").val().toLowerCase(), sessionStorage.getItem('regtoken'));
    if(existe)
    {
      var estadoCP = verificarEstadoCP($("#email").val(), sessionStorage.getItem('regtoken'));
      //console.warn(estadoCP);
      if(estadoCP != 99)
      {
        if(estadoCP == 1 || estadoCP == 2)
        {
          $("#enviarregistro").attr('disabled',false);
          $('#alertas').html('<div class="alert alert-error" style="height:auto; margin:5px auto;">El usuario <strong>' + $("#email").val() + '</strong> ya estaba previamente registrado en Copropiedad.co</div>');
          $("#enviarregistro").val('Intentar de nuevo');
          sessionStorage.setItem('captcha',btoa(generarCaptcha()));
          $('#captchatext').html(atob(sessionStorage.getItem('captcha')));
          $("#captcha").val('');
        }
        else
        {
          var arruser = {nombre:$('#nombre').val(), apellido:$('#apellido').val(), email:$('#email').val().toLowerCase(), telefono:$('#telefono').val()}; 
          var arrcp = {token:sessionStorage.getItem("regtoken"), body:{email:$('#email').val().toLowerCase(),estado:2,id_crm_persona:crm}};
          sessionStorage.setItem('message','Su usuario se encontraba previamente registrado como residente en Copropiedad.co. Para continuar con el proceso de registro como administrador de propiedad horizontal, debe iniciar sesión y crear una copropiedad.');
          sessionStorage.setItem('userdata',btoa(JSON.stringify(arruser)));
          sessionStorage.setItem('isAdmin',2);
          sessionStorage.setItem('newSt',btoa(JSON.stringify(arrcp)));
          location.href = 'https://appdes.copropiedad.co';
        }
      }
      else
      {
        $('#alertas').html('<div class="alert alert-error" style="height:auto; margin:5px auto;">Ha ocurrido un activando su usuario, por favor <a class="btn alertaserror" href="../contacto">contacte con nuestro departamento de servicio al cliente</a></div>');
      }
    }
    else
    {
      var arr = 
      {
        token:sessionStorage.getItem("regtoken"),
        body:
        {
          creado_por:"registro",
          fecha_creacion:fecha(),
          nombre:$('#nombre').val(),
          apellido:$('#apellido').val(),
          email:$('#email').val().toLowerCase(),
          telefono:$('#telefono').val(),
          estado:0,
          id_crm_persona:parseInt(crm)
        }
      };
      $.post(rutaAplicativo, JSON.stringify(arr))
      .done(function(data){
          var msgDividido = JSON.stringify(data);
          var mensaje =  JSON.parse(msgDividido);
          var msgDivididoDos = JSON.stringify(mensaje.message);
          if(mensaje.status)
          {
              $("#enviarregistro").attr('disabled',true);
              var ldaparr = {body:{id_crm:crm}}; 
              enviocorreobienvenida(actualurl, $("#email").val(), JSON.stringify(ldaparr));
              enviocorreoNotificacion(actualurl);
              $(".titulo-principal").html('<h1>¡Gracias!</h1>');
              $(".login").fadeOut("slow",function(){
                $("#gracias").html('<h2 style="text-align:left">Hemos enviado un correo de verificación al correo electrónico que ha registrado. Allí encontrará un vínculo para continuar con el proceso de activación.</h2>');
              });
          }
          else
          {
            $('#alertas').html('<div class="alert alert-error" style="height:auto; margin:5px auto;">Ha ocurrido un error creando su usuario, por favor <a class="btn alertaserror" href="../contacto">contacte con nuestro departamento de servicio al cliente</a></div>');
          }
      });
    }
}
function envioFormularioPassword(actualurl) //---OK
{
    if($('#password').val() == $('#passwordconf').val())
    {
        $('input[type=submit]').attr('disabled',true);
        $('input[type=submit]').val('Activando...');
        var rutaAplicativoAuth = "https://auth.sinfo.co/auth/"; 
        var rutaAplicativoCP= "https://appdes.copropiedad.co/api/estados/estados/";
        var arr = JSON.parse($("#arr").val());
        arr["body"]["password"] = $('#passwordconf').val();
        $.ajax(
        {
            url: rutaAplicativoAuth,
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
                  var arrcp = {token:sessionStorage.getItem("regtoken"), body:{email:arr["body"]["email"].toLowerCase().replace('cp-',''),estado:$("#ecp").val(),id_crm_persona:parseInt(arr["body"]["id_crm"])}}; 
                  $.ajax({
                      url: rutaAplicativoCP,
                      type: "PUT",
                      data: JSON.stringify(arrcp),
                      contentType: 'application/json; charset=utf-8',
                      dataType: 'json',
                      async: false,
                      success: function(data) 
                      {
                        var msgDividido2 = JSON.stringify(data);
                        var mensaje2 =  JSON.parse(msgDividido2);
                        var msgDivididoDos2 = JSON.stringify(mensaje2.message);
                        if(mensaje2.status)
                        {
                          $(".titulo-principal").html('<h1>¡Usuario activado!</h1>');
                          $(".login").fadeOut("slow",function(){
                            $("#gracias").html('<h2 style="text-align:left">El proceso de activación ha sido satisfactorio, usted ya puede iniciar sesión en Copropiedad.co</h2><br/><a class="btn big" href="' + actualurl + '">Iniciar sesión</a>');
                          });
                        }
                        else
                        {
                          $('#alertas').html('<div class="alert alert-error" style="height:auto; margin:5px auto;">Ha ocurrido un error creando su usuario, por favor <a class="btn alertaserror" href="../contacto">contacte con nuestro departamento de servicio al cliente</a></div>');
                        }
                      }
                    });
                }
                else if(mensaje.error.indexOf("Modify: No such object") != -1)
                {
                    $('#alertas').html('<div class="alert alert-error" style="height:auto; margin:5px auto;">Su usuario no existe en el sistema y no es posible activarlo. Puede iniciar el proceso de registro haciendo click <a class="btn alertaserror" href="index.php"> aquí. </a></div>');
                    $('input[type=submit]').val('Regresar');
                    $('input[type=submit]').click(function(){location.href = actualurl});
                    $('input[type=submit]').attr('disabled',false);
                }
                else if(mensaje.error.indexOf("ldap_add(): Add: Already exists") != -1)
                {
                    $('#alertas').html('<div class="alert alert-error" style="height:auto; margin:5px auto;">El usuario <strong>' + arr["body"]["email"].replace("cp-","") + '</strong> ya se encuentra activo en el sistema y no es posible activarlo.</div>');
                    $('input[type=submit]').val('Regresar');
                    $('input[type=submit]').click(function(){location.href = actualurl});
                    $('input[type=submit]').attr('disabled',false);
                }
                else
                {
                    $('#alertas').html('<div class="alert alert-error" style="height:auto; margin:5px auto;">Ha ocurrido un error activando su usuario, por favor <a class="btn alertaserror" href="../contacto">contacte con nuestro departamento de servicio al cliente</a></div>');
                }
            }
        });
    }
    else
    {
        $('#alertas').html('<div class="alert alert-error" style="height:auto; margin:5px auto;">Las contraseñas que ha escrito no coinciden, por favor inténtelo de nuevo.</div>');
    }
}
function envioFormularioPasswordCambio(actualurl) //--OK
{
    if($('#password').val() == $('#passwordconf').val())
    {
        $('input[type=submit]').attr('disabled',true);
        $('input[type=submit]').val('Cambiando contraseña...');
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
                    enviocorreopwdchg(actualurl);
                    $(".titulo-principal").html('<h1>¡Ha cambiado su contraseña!</h1>');
                    $(".login").fadeOut("slow",function(){
                      $("#gracias").html('<h2 style="text-align:left">El proceso de cambio de contraseña ha sido satisfactorio, inicie sesión en Copropiedad.co con su nueva contraseña.</h2><br/><a class="btn big" href="' + actualurl + '">Iniciar sesión</a>');
                    });
                }
                else if(mensaje.error.indexOf("Modify: No such object") != -1)
                {
                    $('#alertas').html('<div class="alert alert-error" style="height:auto; margin:5px auto;">No es posible realizar el cambio de contraseña, su correo no se encuentra registrado en el sistema. Puede iniciar el proceso de registro haciendo click <a class="btn alertaserror" href="index.php"> aquí. </a></div>');
                }
                else
                {
                    $('#alertas').html('<div class="alert alert-error" style="height:auto; margin:5px auto;">Ha ocurrido un error activando su usuario, por favor <a class="btn alertaserror" href="../contacto">contacte con nuestro departamento de servicio al cliente</a></div>');
                }
            }
        });
    }
    else
    {
        $('#alertas').html('<div class="alert alert-error" style="height:auto; margin:5px auto;">Las contraseñas que ha escrito no coinciden, por favor inténtelo de nuevo.</div>');
    }
}

function envioFormularioLink(actualurl) //--OK
{
  var existe = false;
  $('input[type=submit]').attr('disabled',true);
  $('input[type=submit]').val('Generando nuevo enlace...');

  existe = existeLDAP($('#email').val(), $('#token').val());

  //ENVIAR CORREO
    if(existe)
    {
        var rutaActivacion = actualurl + "/registrese/activar.php?token=";
        var code = btoa(encodeURIComponent($('#nombre').val()) + "^cp-" + $('#email').val());
        var link = rutaActivacion + encodeURIComponent(sessionStorage.getItem('regtoken')) + "&code=" + code;
        
        var body = '<h4 style="color:#666 !important;">Bienvenido a Copropiedad.Co la manera confiable de administrar Propiedades Horizontales.</h4><h4 style="color:#666 !important;">El usuario de su cuenta es: <strong>' + $('#email').val() + '</strong></h4><h4 style="color:#666 !important;">Para activar su cuenta, es necesario que asigne una contraseña haciendo click en el siguiente botón: </h4><br/><p style="text-align: center; margin-bottom: 0;"><a href="' + link + '" style="background:#f51e7c; color:#fff!important; text-decoration: none; padding:15px 20px; border-radius: 3px;">Asignar contraseña y activar</a></p>';

        var to = $('#email').val();
        
        var response = enviocorreoSync(to, "Bienvenido a Copropiedad.co", body, actualurl + "/","registro");

        if(response)
        {
          $(".titulo-principal").html('<h1>¡Correo enviado!</h1>');
          $(".login").fadeOut("slow",function(){
            $("#gracias").html('<h2>Hemos enviado un nuevo correo de confirmación a la dirección ' + $("#email").val() + ' </h2>');
          });
        }
        else
        {
            $('#alertas').html('<div class="alert alert-error" style="height:auto; margin:5px auto;">Ha ocurrido un error enviando el correo de activación, por favor <a class="btn alertaserror" href="../contacto">contacte con nuestro departamento de servicio al cliente</a></div>');
        }
    }
    else
    {
      $('input[type=submit]').attr('disabled',false);
      $('input[type=submit]').val('Obtener link');
      $('#alertas').html('<div class="alert alert-error" style="height:auto; margin:5px auto;">Su correo electrónico no se encuentra registrado en el sistema <a class="btn alertaserror" href="../registrese"> Registrese aquí. </a></div>');
    }    
}

function envioFormularioCambio(actualurl) //--OK
{
  var existe = false;
  $('input[type=submit]').attr('disabled',true);
  $('input[type=submit]').val('Generando enlace...');
  var metodo = "POST";
  var arr = {
                token:sessionStorage.getItem('regtoken'),
                body:
                {  
                      id_crm_persona:"registro",
                      fecha_solicitud:new Date(),
                      nombre_remitente:"registro",
                      tipo:"cambiopasswordinicio",
                      destinatarios:[  
                         {  
                            nombre: $('#nombre').val(),
                            link: rutaActivacion + encodeURIComponent(sessionStorage.getItem('regtoken')) + "&code=" + code,
                            email: $('#email').val()
                         }
                      ],
                }
              }; 
  // VALIDA SI USUARIO EXISTE EN LDAP
    var rutaAplicativoAuth = "https://auth.sinfo.co/auth/verify/";
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

  //REVISAR ACA PARA ENVIO DE CORREOS
  if(existe)
  {
    var rutaActivacion = actualurl + "/registrese/confirmar-password.php?token=";
    var code = btoa(encodeURIComponent($('#nombre').val()) + "^cp-" + $('#email').val());
    var link = rutaActivacion + encodeURIComponent(sessionStorage.getItem('regtoken')) + "&code=" + code;

    var body = '<h4 style="color:#666 !important;">Haga click en el siguiente botón para realizar el cambio de contraseña en Copropiedad.co</h4><br/><p style="text-align: center; margin-bottom: 0;margin-top: 5;"><a href="' + link + '" style="background:#f51e7c; color:#fff!important; text-decoration: none; padding:10px 20px; border-radius: 3px;">Realizar el cambio de contraseña</a></p>';

    var to = $('#email').val();
    
    var response = enviocorreoSync(to, "Solicitud cambio de contraseña", body, actualurl + "/","registro");

    if(response)
    {
        $(".titulo-principal").html('<h1>¡Correo enviado!</h1>');
        $(".login").fadeOut("slow",function(){
          $("#gracias").html('<h2 style="text-align:left">Hemos enviado un correo con las instrucciones para cambiar la contraseña a la dirección ' + $("#email").val() + '</h2>');
        });
    }
    else
    {
      $('input[type=submit]').attr('disabled',false);
      $('input[type=submit]').val('Cambiar contraseña');
      $('#alertas').html('<div class="alert alert-error" style="height:auto; margin:5px auto;">Ha ocurrido un error enviando el correo de cambio de contraseña, por favor <a class="btn alertaserror" href="../contacto">contacte con nuestro departamento de servicio al cliente</a></div>');
    } 
  }
  else
  {
      $('#alertas').html('<div class="alert alert-error" style="height:auto; margin:5px auto;">El correo electrónico '+ $('#email').val() +' no está registrado en el sistema.</div>');
      /*$('#cambio_form').fadeOut("slow",function(){
        $("#gracias").html('<p><a href="../registrese"> Registrar usuario nuevo </a></p>');
      });*/
      $('input[type=submit]').attr('disabled',false);
      $('input[type=submit]').val('Intentar de nuevo');
  }        
}

function enviocorreobienvenida(actualurl, email, body) //--OK
{   
  //var rutaAplicativo = actualurl + "/api/mailer/mail/registro/bienvenida/";
  var rutaActivacion = actualurl + "/registrese/activar.php?token=";
  var code = btoa(encodeURIComponent(body));
  var link = rutaActivacion + encodeURIComponent(sessionStorage.getItem('regtoken')) + "&code=" + code + "&ecp=1";
  var metodo = "POST";
  
  var body = '<h4 style="color:#666 !important;">Bienvenido a Copropiedad.co la manera confiable de administrar Propiedades Horizontales.</h4><h4 style="color:#666 !important;">El usuario de su cuenta es: <strong>' + email + '</strong></h4><h4 style="color:#666 !important;">Para activar su cuenta, es necesario que asigne una contraseña haciendo click en el siguiente botón: </h4><br/><p style="text-align: center; margin-bottom: 0;"><a href="' + link + '" style="background:#f51e7c; color:#fff!important; text-decoration: none; padding:15px 20px; border-radius: 3px;">Asignar contraseña y activar</a></p>';

  var to = email;
  
  enviocorreoSync(to, "Bienvenido a Copropiedad.co", body, actualurl + "/","registro");
}

function enviocorreoNotificacion(actualurl) //--OK
{   
  var rutaAplicativo = actualurl + "/api/mailer/mail/registro/notificacion/";        
  var metodo = "POST";
  var arr = 
  {
    token:sessionStorage.getItem('regtoken'),
    body:
    {  
      id_crm_persona:"registro",
      fecha_solicitud:new Date(),
      nombre_remitente:"registro",
      destinos:"gvelasquez@teleinte.com,azamudio@teleinte.com,ralbornoz@teleinte.com",
      //destinos:"jgil@teleinte.com,gvelasquez@teleinte.com,azamudio@teleinte.com,ralbornoz@teleinte.com",
      destinatarios:[  
         {  
            nombre: $('#nombre').val(),
            apellido : $('#apellido').val(),
            email : $('#email').val(),
            telefono : $('#telefono').val(),
            direccion: $('#direccion').val(),
            nombreedificio: $('#nombreedificio').val(),
            tipo : $('#tipo').val(),
            pais: $('#pais').val(),
            ciudad: $('#ciudad').val()
         }
      ],
    }
  };
  //console.log(arr);
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
      }
  })        
}

function enviocorreopwd(actualurl)  //--OK
{   
  var rutaAplicativo = actualurl + "/api/mailer/mail/usuario/cambiopassword/";
  var metodo = "POST";
  var mail = $('#email').val();
  var arr = {
    token:$('#token').val(),
    body:
    {  
          id_crm_persona:"registro",
          fecha_solicitud:new Date(),
          nombre_remitente:"registro",
          destinatarios:[  
             {  
                nombre: $('#nombre').val(),
                email: mail.replace("cp-","")
             }
          ]
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
      }
  })        
}

function enviocorreopwdchg(actualurl) //--OK
{   
  var body = '<h4 style="color:#666 !important;">Su contraseña ha sido actualizada exitosamente. Ahora puede ingresar a Copropiedad.co con sus nuevas credenciales.</h4><br/><a href="https://appdes.copropiedad.co" style="background:#f51e7c; color:#fff!important; text-decoration: none; padding:15px 20px; border-radius: 3px;">Ingresar</a></p>';

  var to = $('#email').val().replace('cp-','');
  
  enviocorreoSync(to, "Modificación de contraseña", body, actualurl + "/","registro");
}
