function enviocorreo(){		
  var rutaAplicativo = "https://appdes.copropiedad.co/api/mailer/mail/registro/bienvenida/";
  var rutaActivacion = "https://appdes.copropiedad.co/registrese/activar.php?token=";
  var code = btoa(encodeURIComponent($('#nombre').val()) + "^cp-" + $('#email').val());
  //console.log(rutaActivacion + encodeURIComponent(sessionStorage.getItem('token')) + "&code=" + encodeURIComponent(code));
  var metodo = "POST";
  var arr = 
  {
    token:sessionStorage.getItem('token'),
    body:
    {  
        id_crm_persona:"registro",
        fecha_solicitud:new Date(),
        nombre_remitente:"registro",
        destinatarios:[  
           {  
              user: $('#nombre').val(),
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

function enviocorreoNotificacion(){   
  var rutaAplicativo = "https://appdes.copropiedad.co/api/mailer/mail/registro/notificacion/";        
  var metodo = "POST";
  var arr = 
  {
    token:sessionStorage.getItem('token'),
    body:
    {  
      id_crm_persona:"registro",
      fecha_solicitud:new Date(),
      nombre_remitente:"registro",
      destinos:"jgil@teleinte.com,gvelasquez@teleinte.com,azamudio@teleinte.com,ralbornoz@teleinte.com",
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

function enviocorreopwd(){   
  var rutaAplicativo = "https://appdes.copropiedad.co/api/mailer/mail/usuario/cambiopassword/";
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
          //console.log(msg);
      }
  })        
}

function enviocorreopwdchg(){   
  var rutaAplicativo = "https://appdes.copropiedad.co/api/mailer/mail/usuario/infoactualizada/";
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
      }
  })
}