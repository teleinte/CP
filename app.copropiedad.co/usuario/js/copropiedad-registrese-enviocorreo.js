function enviocorreo(){		
        var rutaAplicativo = "https://app.copropiedad.co/api/mailer/mail/registro/activacion/";
        var rutaActivacion = "https://app.copropiedad.co/v2/registrese/activar.php?token=";
        var code = btoa(encodeURIComponent($('#nombre').val()) + "^cp-" + $('#email').val());
        console.log(rutaActivacion + encodeURIComponent(sessionStorage.getItem('token')) + "&code=" + encodeURIComponent(code));
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
                //console.log(msg);
            }
        })        
}
function enviocorreopwd(){   
        var rutaAplicativo = "https://app.copropiedad.co/api/mailer/mail/usuario/cambiopassword/";
        var metodo = "POST";
        var mail = $('#email').val();
        var arr = {
          token:$('#token').val(),
          body:
          {  
                id_crm_persona:"registro",
                fecha_solicitud:new Date(),
                nombre_remitente:"registro",
                tipo:"primeravez",
                destinatarios:[  
                   {  
                      nombre: $('#nombre').val(),
                      email: mail.replace("cp-","")
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
                //console.log(msg);
            }
        })        
}
function enviocorreopwdchg(){   
        var rutaAplicativo = "https://app.copropiedad.co/api/mailer/mail/usuario/cambiopassword/";
        var metodo = "POST";
        var mail = $('#email').val();
        var arr = {
          token:$('#token').val(),
          body:
          {  
                id_crm_persona:"registro",
                fecha_solicitud:new Date(),
                nombre_remitente:"registro",
                tipo:"cambiopasswordfin",
                destinatarios:[  
                   {  
                      nombre: $('#nombre').val(),
                      email: mail.replace("cp-","")
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
                //console.log(msg);
            }
        })        
}