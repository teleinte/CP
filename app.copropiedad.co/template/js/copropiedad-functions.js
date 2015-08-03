function enviocorreoSync(mail_to, mail_subject, mail_message, url, tipo)
{
  if(tipo === undefined || tipo === null) tipo = "normal";
  if(tipo == "normal")
  {
    if(url == null || url == undefined)
    var rutaAplicativo = traerDireccion()+'api/mailer/mail/send2';
    else
    var rutaAplicativo = url +'api/mailer/mail/send2';
  }
  else
  {
    if(url == null || url == undefined)
    var rutaAplicativo = traerDireccion()+'api/mailer/mail/send';
    else
    var rutaAplicativo = url +'api/mailer/mail/send';
  }

  var metodo = "POST";
  var arr="";
  if(sessionStorage.getItem('token') != null || sessionStorage.getItem('token') != undefined)
  {
    arr = 
    {
      token:sessionStorage.getItem('token'),
      body:
      {
        to: mail_to,
        subject: mail_subject,
        message: mail_message
      }
    }
  }
  else
  {
    arr = 
    {
      token:sessionStorage.getItem('regtoken'),
      body:
      {
        to: mail_to,
        subject: mail_subject,
        message: mail_message
      }
    }
  }
  var response = false;
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
          if(mensaje.message=="Token invalido")
          {
              window.location = '../';
          }
          else
          {
              response = mensaje.status;
          }
      }
  }); 
  
  return response;   
}

function enviocorreoAsync(mail_to, mail_subject, mail_message, url, tipo)
{
  if(tipo === undefined || tipo === null) tipo = "normal";
  if(tipo == "normal")
  {
    if(url == null || url == undefined)
    var rutaAplicativo = traerDireccion()+'api/mailer/mail/send2';
    else
    var rutaAplicativo = url +'api/mailer/mail/send2';
  }
  else
  {
    if(url == null || url == undefined)
    var rutaAplicativo = traerDireccion()+'api/mailer/mail/send';
    else
    var rutaAplicativo = url +'api/mailer/mail/send';
  }

  var metodo = "POST";
  var arr = 
  {
    token:sessionStorage.getItem('token'),
    body:
    {
      to: mail_to,
      subject: mail_subject,
      message: mail_message
    }
  }
  var response = false;

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
          if(mensaje.message=="Token invalido")
          {
              window.location = '../';
          }
          else
          {
              response = mensaje.status;
          }
      }
  }); 

  return response;          
}

function CreaToken(AutDeUsuario, usuario, modulo)
{
  var rutaAplicativo = traerDireccion() + "api/"; 
  var arr = {body:{autkey:AutDeUsuario,user:usuario}};            
  $.ajax({
    url: rutaAplicativo + modulo + '/token',
    type: 'POST',
    data: JSON.stringify(arr),
    contentType: 'application/json; charset=utf-8',
    dataType: 'json',
    async: true,
    success: function(msg) {
        var msgDividido = JSON.stringify(msg);                    
        var mensaje =  JSON.parse(msgDividido);
        var msgDivididoDos = JSON.stringify(mensaje.message);
        if (mensaje.status==false)
        {
            window.location="../"
        }                
        var datos = JSON.parse(msgDivididoDos);
        $.each(datos, function(x , y) 
        {                     
             sessionStorage.setItem(x, y);
             location.reload()                    
        }                
        )
      }
  });   
}

function envioFormularioSync(url, arr, metodo)
{
  var rutaAplicativo = traerDireccion()+"api/";
  //console.log(arr);
  var response = false;
  $.ajax(
  {
      url: rutaAplicativo+url,
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
              response = false;
          }
          else
          {
              response = mensaje.status;
          }
      }
  });

  return response;       
}

function envioFormularioAsync(url, arr, metodo)
{
  var rutaAplicativo = traerDireccion()+"api/";
  //console.log(url);
  //console.log(rutaAplicativo);
  var response = false;
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
              response = false;
          }
          else
          {
              response = mensaje.status;
          }
      }
  });

  return response;       
}

function envioFormularioMessageSync(url, arr, metodo)
{
  var rutaAplicativo = traerDireccion()+"api/";
  var response = false;
  $.ajax(
  {
      url: rutaAplicativo+url,
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
              response = false;
          }
          else
          {
              response = msg;
          }
      }
  });

  return response;       
}

function envioFormularioMessageBodySync(url, arr, metodo)
{
  var rutaAplicativo = traerDireccion()+"api/";
  var response = false;
  $.ajax(
  {
      url: rutaAplicativo+url,
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
              response = false;
          }
          else
          {
              response = mensaje.message;
          }
      }
  });

  return response;       
}

function envioFormularioMessageAsync(url, arr, metodo)
{
  var rutaAplicativo = traerDireccion()+"api/";
  //console.log(url);
  //console.log(rutaAplicativo);
  var response = false;
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
              response = false;
          }
          else
          {
              response = msg;
          }
      }
  });

  return response;       
}

function envioFormularioMessageBodyAsync(url, arr, metodo)
{
  var rutaAplicativo = traerDireccion()+"api/";
  //console.log(url);
  //console.log(rutaAplicativo);
  var response = false;
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
              response = false;
          }
          else
          {
              response = msgDivididoDos;
          }
      }
  });

  return response;       
}

function envioFormularioURLMessageSync(url, arr, metodo)
{
  var rutaAplicativo = url;
  //console.log(rutaAplicativo);
  var response = false;
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
          if(mensaje.message=="Token invalido")
          {
              response = false;
          }
          else
          {
              response = msg;
          }
      }
  });
  return response;       
}

function envioFormularioURLMessageAsync(url, arr, metodo)
{
  var rutaAplicativo = url;
  var response = false;
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
          if(mensaje.message=="Token invalido")
          {
              response = false;
          }
          else
          {
              response = msg;
          }
      }
  });

  return response;       
}

function traerDatosAsync(url,arr,params)
{
  var rutaAplicativo = traerDireccion()+"api/";
  var response = false;
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
                  window.location = '../';
              }
              else
              {
                  response = datos;
              }                
          }
      });
  return response;
}

function traerDatosSync(url,arr,params)
{
  var rutaAplicativo = traerDireccion()+"api/";
  //console.log(rutaAplicativo + url);
  var response = false;
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
                  window.location = '../';
              }
              else
              {
                  response = datos;
              }                
          }
      });
  return response;
}

function traerDatosAsyncCustom(url,arr,metodo)
{
  var rutaAplicativo = traerDireccion()+"api/";
  var response = false;
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
              var datos = JSON.parse(msgDivididoDos);                
              if (datos=="Token invalido")
              {              
                  window.location = '../';
              }
              else
              {
                  response = datos;
              }                
          }
      });
  return response;
}

function traerDatosSyncCustom(url,arr,metodo)
{
  var rutaAplicativo = traerDireccion()+"api/";
  var response = false;
  $.ajax(
      {
          url: rutaAplicativo+url,
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
              var datos = JSON.parse(msgDivididoDos);                
              if (datos=="Token invalido")
              {              
                  window.location = '../';
              }
              else
              {
                  response = datos;
              }                
          }
      });
  return response;
}

function fecha()
{
  var d = new Date();
  var n = d.toISOString(); 
  return n;
}  

function TraerModulosCopropiedad(arr,url,metodo)
{ 
  var rutaAplicatico = traerDireccion()+"api/admin/copropiedad/";
  $.ajax({
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

function refreshWindow(page)
{
    window.location = page;
}

function traerDatosHoy()
{
  var rutaAplicativo = "hoy/obtener/";  
  var arr = { token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp')}};
  var salida = "<ul>";
  var datos = traerDatosSync(rutaAplicativo,arr);
  //console.warn(datos);
  var tareasvencidas = new Array();
  var tareashoy = new Array();
  var solicitudes = new Array();
  //var reservashoy = new Array();
  var contadorta = 0;
  var contadortv = 0;
  var contadorso = 0;
  if(!$.isEmptyObject(datos))
    $.each(datos, function(x , y){
      var hoy = new Date().toISOString().split("T")[0]; 
      //console.warn(y);
      //console.log(y['nombre'] + "-" + y['fecha'] + "-" + y['tipo']);
      if(y['tipo'] == 'tarea')
      {
        var fechaitem = new Date(y['deadline'].replace("COT","T")).toISOString().split("T")[0];
        if(fechaitem == hoy)
        {
          if(contadortv == 0)
          {
            tareashoy.push('<div class="title" style="margin-top:5px;">Tareas para hoy</div>');
            contadortv = contadortv + 1;
          }
          tareashoy.push('<li><div style="padding-left:15px; float:left;"><a href="https://appdes.copropiedad.co/calendario/editar-tarea.php" deadline="' + y['deadline'] + '" estado="' + y['estado'] + '" creacion="' + y['fecha_creacion'] + '" frecuencia="' + y['frecuencia'] + '" nombre="' + y['nombre'] + '" notas="' + y['notas'] + '" tipo="' + y['tipo'] + '" mongoid="' + y['_id']['$id'] + '" class="tarhoylink">' + y['nombre'] + '</a></div><div class="floatright">Vence hoy</div></li>');
          contadortv = contadortv + 1;
        }
        else
        {
          if(contadorta == 0)
          {
            tareasvencidas.push('<div class="title" style="margin-top:5px;">Tareas vencidas</div>');
            contadorta = contadorta + 1;
          }
          tareasvencidas.push('<li><div style="padding-left:15px; float:left;"><a href="https://appdes.copropiedad.co/calendario/editar-tarea.php" deadline="' + y['deadline'] + '" estado="' + y['estado'] + '" creacion="' + y['fecha_creacion'] + '" frecuencia="' + y['frecuencia'] + '" nombre="' + y['nombre'] + '" notas="' + y['notas'] + '" tipo="' + y['tipo'] + '" mongoid="' + y['_id']['$id'] + '" class="tarhoylink">' + y['nombre'] + '</a></div><div class="floatright"> Venció el ' + fechaitem + '</div></li>');
          contadorta = contadorta + 1;
        }
      }
      
      /*else if(y['tipo'] == 'reserva')
      {
        if(reservashoy.length < 1)
          reservashoy.push('<div class="title" style="margin-top:5px;">Reservas para hoy</div>');
        var fechar = new Date(y['fecha'].replace("COT","T")).toISOString().split("T")[1].replace(":00.000Z","");
        reservashoy.push('<li><div class="floatleft"><a href="http://aws02.sinfo.co/v2/reservas/">&nbsp;&nbsp;' + y['nombre'] + '</a></div><div class="floatright">' + fechar + '</div></li>');
      }*/
      else if(y['item_type'] == 'solicitudes')
      {
        if(contadorso == 0)
          solicitudes.push('<div class="title" style="margin-top:5px;">Solicitudes abiertas / Fecha Apertura</div>');
        var fechas = new Date(y['fecha_creacion'].replace("COT","T")).toISOString().split("T")[0].replace(":00+00:00","");
        var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
        var firstDate = new Date(fechas);
        var secondDate = new Date();
        var diffDays = Math.ceil((firstDate.getTime() - secondDate.getTime())/(oneDay))*-1;
        if(diffDays == 0)
          solicitudes.push('<li><div style="padding-left:15px; float:left;"><a href="' + traerDireccion() + 'solicitudes/" mongoid="' + y['_id']['$id'] + '" estado="' + y['estado'] + '" fechacierre="' + y['fecha_cierre'] + '" fecha_creacion="' + y['fecha_creacion'] + '" item_type="' + y['item_type'] + '" notas="' + y['notas'] + '" solicitud="' + y['solicitud'] + '" usuario="' + y['usuario'] + '" class="solhoylink">' + y['solicitud'] + '</a></div><div class="floatright">Abierta hoy</div></li>'); 
        else
          solicitudes.push('<li><div style="padding-left:15px; float:left;"><a href="' + traerDireccion() + 'solicitudes/" mongoid="' + y['_id']['$id'] + '" estado="' + y['estado'] + '" fechacierre="' + y['fecha_cierre'] + '" fecha_creacion="' + y['fecha_creacion'] + '" item_type="' + y['item_type'] + '" notas="' + y['notas'] + '" solicitud="' + y['solicitud'] + '" usuario="' + y['usuario'] + '" class="solhoylink">' + y['solicitud'] + '</a></div><div class="floatright">Abierta hace ' + diffDays + ' dias</div></li>');  
        contadorso = contadorso + 1
      }
    });

  salida = tareashoy.concat(tareasvencidas).concat(solicitudes);//.concat(reservashoy);
  $("#pending-panel").html("<ul>" + salida.join("") + "</ul>");
  //console.log(datos3.length);
  //if(solicitudes.length > 0)
  if(datos.length > 0)
  {
    $("#pending-counter-text").text("Mis Pendientes...");
    $("#pending-counter").html(datos.length);
  }
  else
  {
    $("#pending-counter").html(datos.length);
    $("#pending-counter-text").text('No hay pendientes para hoy');
    $("#pending-panel").addClass('nohaynada');
  }

  $(".tarhoylink").click(function(event){
    event.preventDefault();
    var elem = 
    {
      id:$(this).attr('mongoid'),
      fecha_creacion:$(this).attr('creacion'),
      tipo:"tarea",
      nombre:$(this).attr('nombre'),
      estado:$(this).attr('estado'),
      deadline:$(this).attr('deadline'),
      notas:$(this).attr('notas'),
      frecuencia:$(this).attr('frecuencia')
    }
    //console.warn(elem);
    sessionStorage.setItem('acelem',JSON.stringify(elem));
    sessionStorage.setItem('referer','../tarea');
    window.location = "../calendario/editar-tarea.php";
  });
}

function CreaTokenAuth(AutDeUsuario, usuario)
{
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
            if(x == "token")
              sessionStorage.setItem("regtoken",y);
            else
              sessionStorage.setItem(x,y);
          });                
       }
       else
       {
          return "notoken";
       }
   });
}

function obtenerLenguaje()
{
  var rutaAplicativo = "lang/";  
  var arr = { token:sessionStorage.getItem('token'),body:{lang:sessionStorage.getItem('idioma')}};
  var datos = traerDatosSyncCustom(rutaAplicativo,arr,'PUT');
  if(!$.isEmptyObject(datos))
    $.each(datos, function(x , y){
      localStorage.setItem(sessionStorage.getItem('idioma'), JSON.stringify(y['items']));
    });
}

function actualizarLenguage()
{
  var rutaAplicativo = "lang/";  
  var arr = { token:sessionStorage.getItem('token'),body:{lang:sessionStorage.getItem('idioma')}};
  return traerDatosSync(rutaAplicativo,arr);
}

function obtenerTerminoLenguage(thisPage, thisId, lang)
{
  var PageTexts = "";
    if(lang === undefined || lang === null)
      PageTexts = JSON.parse(localStorage.getItem($('html').attr('lang')));
    else
      PageTexts = JSON.parse(localStorage.getItem(lang));
    var term = PageTexts[thisPage][thisId];
    //console.log(thisPage + ":" + thisId + ":" + term);

    return term;
}

function checkRemoteUserFlow(url)
{ 
  var arr = {token:sessionStorage.getItem('token'),body:{id_crm:sessionStorage.getItem('id_crm'),id_copropiedad:sessionStorage.getItem('cp')}};
  var datos = envioFormularioURLMessageSync(url + "api/userflow/",arr,'POST');
  var res = false;
  //console.warn(url + "api/userflow/");
  //console.warn(datos);
  if(datos)
  {
    var msgDividido = JSON.stringify(datos);
    var mensaje =  JSON.parse(msgDividido);
    var msgDivididoDos = JSON.stringify(mensaje.message);
    var response = JSON.parse(msgDivididoDos);
    //console.log(response);
    if (mensaje.status)
    {            
      sessionStorage.setItem('userflow', Number(mensaje.message));
      res = true;
    }
    return res;
  }
}

function checkUserFlow(url)
{
  if(sessionStorage.getItem('userflow') != null || sessionStorage.getItem('userflow') != undefined)
  {
    return true;
  }
  else
  {
    checkRemoteUserFlow(url);
  }
  return true;
}

function checkVigencia(url)
{
  var actualUrl = "api/admin/copropiedad/copropiedad/usuarioCopropiedad/";
  var arr = {token:sessionStorage.getItem('token'),body:{id_crm_persona:sessionStorage.getItem('id_crm')}};
  var datos = envioFormularioURLMessageSync(url + actualUrl,arr,'POST');
  var res = false;
  //console.warn(datos);
  if(datos)
  {
    var msgDividido = JSON.stringify(datos);
    var mensaje =  JSON.parse(msgDividido);
    var msgDivididoDos = JSON.stringify(mensaje.message);
    var response = JSON.parse(msgDivididoDos);
    if (mensaje.status)
    {            
      res = mensaje.message;
    }
    return res;
  }
}

function checkVigenciaCP(url,cps)
{
  var actualUrl = "api/admin/copropiedad/copropiedad/usuarioCopropiedad/vigencias/";
  var arr = {token:sessionStorage.getItem('token'),body:{cp:cps}};
  var datos = envioFormularioURLMessageSync(url + actualUrl,arr,'POST');
  var res = false;
  //console.warn(datos);
  //console.warn(arr);
  if(datos)
  {
    var msgDividido = JSON.stringify(datos);
    var mensaje =  JSON.parse(msgDividido);
    var msgDivididoDos = JSON.stringify(mensaje.message);
    var response = JSON.parse(msgDivididoDos);
    if (mensaje.status)
    {            
      res = mensaje.message;
    }
    return res;
  }
}

function checkPerfiles(url)
{
  var actualUrl = "api/admin/copropiedad/usuario/personacrm/";
  var arr = {token:sessionStorage.getItem('token'),body:{correo:sessionStorage.getItem('email').replace('cp-','')}};
  var datos = envioFormularioURLMessageSync(url + actualUrl,arr,'POST');
  var res = false;
  //console.warn(datos);
  if(datos)
  {
    var msgDividido = JSON.stringify(datos);
    var mensaje =  JSON.parse(msgDividido);
    var msgDivididoDos = JSON.stringify(mensaje.message);
    var response = JSON.parse(msgDivididoDos);
    if (mensaje.status)
    {            
      res = mensaje.message;
    }
    return res;
  }
}

function checkPerfilesUser(url, email)
{
  var actualUrl = "api/admin/copropiedad/usuario/personacrm/";
  var arr = {token:sessionStorage.getItem('token'),body:{correo:email}};
  var datos = envioFormularioURLMessageSync(url + actualUrl,arr,'POST');
  var res = false;
  //console.warn(datos);
  if(datos)
  {
    var msgDividido = JSON.stringify(datos);
    var mensaje =  JSON.parse(msgDividido);
    var msgDivididoDos = JSON.stringify(mensaje.message);
    var response = JSON.parse(msgDivididoDos);
    if (mensaje.status)
    {            
      res = mensaje.message;
    }
    return res;
  }
}

function checkTokenValidity()
{
  var ruta = "hoy/verificar/";  
  var arr = {token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp')}};
  return envioFormularioSync(ruta, arr, 'POST');
}

function setupIngreso(estadoCP,cps)
{
  var admin = Array();
  var otros = Array();
  var vencidas = Array();

  if((estadoCP != 99) && (cps != null || cps != undefined))
  {
    //console.warn(cps);
    if(cps != undefined || cps != null || cps != false)
    {
      $.each(cps['activas'],function(k,v){
        switch(parseInt(estadoCP))
        {
          case 1:
            if(v['rol'] == 'administrador')
            {
              admin.push(v['_id']['$id'] + "@@@" + v['nombre']);
            }
          break;
          case 2:
            if(v['rol'] == 'administrador')
            {
              admin.push(v['_id']['$id'] + "@@@" + v['nombre']);
            }
            else
            {
              otros.push(v['_id']['$id'] + "@@@" + v['nombre']);
            }
          break;
          case 3:
            if(v['rol'] == 'residente')
            {
              otros.push(v['_id']['$id'] + "@@@" + v['nombre']);
            }
          break;
        }
      });
    }
    else
    {
      location.href = traerDireccion() + 'inicio';
    }

    $.each(cps['vencidas'],function(k,v){
      if(v['rol'] == 'administrador')
      {
        vencidas.push(v['id_copropiedad'] + "@@@" + v['nombre']);
      }
    });

    sessionStorage.setItem('cp_otros',otros);
    sessionStorage.setItem('cp_vencidas',vencidas);
    sessionStorage.setItem('cp_admin',admin);
    return true;
  }
  else
  {
    return false;
  }
}

function setupInicialCP()
{
  var datos = sessionStorage.getItem('cp_admin').split(',');
  console.warn(datos);
  if(datos != null)
  {
      var cadena = "";
      $.each(datos,function(x,y){
          var idmongo = y.split('@@@')[0];
          var nombre = y.split('@@@')[1];
          //console.log(nombre);
        
        if(sessionStorage.getItem('cp') === null || sessionStorage.getItem('cp') === undefined || sessionStorage.getItem('cp').length < 5 || sessionStorage.getItem('cp') == "undefined")
        {
          sessionStorage.setItem('cp',idmongo);
        }
      });
    }
}

function listarCopropiedades()
{
  var estadousuario = parseInt(sessionStorage.getItem('estadoCP'));
  switch(parseInt(estadousuario))
  {
    case 1:
      var datos = sessionStorage.getItem('cp_admin');
    break;
    case 2:
      var datos = sessionStorage.getItem('cp_admin');
    break;
    case 3:
      var datos = sessionStorage.getItem('cp_otros');
    break;
    default:
      return false;
    break;
  }

  if(datos !== null)
  {
      datos = datos.split(',');
      var cadena = "";
      $.each(datos,function(x,y){
          var idmongo = y.split('@@@')[0];
          var nombre = y.split('@@@')[1];
        
        if(sessionStorage.getItem('cp') === null || sessionStorage.getItem('cp') === undefined )
          sessionStorage.setItem('cp',idmongo);

          if (idmongo == sessionStorage.getItem('cp'))
          {
            cadena += '<option value="' + idmongo + '" title="' + y['direccion'] + '" selected>' + nombre + '</option>';
            sessionStorage.setItem('ncp',nombre);
          }
          else
          {
            cadena +='<option value="' + idmongo + '">' + nombre + '</option>';
          }                                            
      });

      cadena+='<option value="nueva">Crear nueva copropiedad...</option>'
      
      if($('#selcopropiedades').length){
        $('#selcopropiedades').html(cadena);
      }
  }
}

function ucfirst(str)
{
  return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
}

function printDiv(divName) 
{
  var printContents = document.getElementById(divName).innerHTML;
  var originalContents = document.body.innerHTML;

  document.body.innerHTML = printContents;

  window.print();

  document.body.innerHTML = originalContents;
}

function calculateArrayLenght(items)
{
  Object.size = function(obj) {
      var size = 0, key;
      for (key in obj) {
          if (obj.hasOwnProperty(key)) size++;
      }
      return size;
  };

  var size = Object.size(items);
  return size;
}

function agregarDias(dias)
{
    var response = "";
    var d = new Date();
    d.setTime(d.getTime() + dias * 86400000 );
    response = d.toISOString().split('T')[0];
    return response;
}

function cleanArray(actual){
  var newArray = new Array();
  for(var i = 0; i<actual.length; i++){
      if (actual[i]){
        newArray.push(actual[i]);
    }
  }
  return newArray;
}

function zeroPad(num, places){
  var zero = places - num.toString().length + 1;
  return Array(+(zero > 0 && zero)).join("0") + num;
}

function arrToObj(arr)
{
  var obj = arr.reduce(function(o, v, i) {
    o[i] = v;
    return o;
  }, {});

  return obj;
}

function generateUUID() {
    var d = new Date().getTime();
    var uuid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
        var r = (d + Math.random()*16)%16 | 0;
        d = Math.floor(d/16);
        return (c=='x' ? r : (r&0x3|0x8)).toString(16);
    });
    return uuid;
};


function existeLDAP(email, token)
{
  var salida = false;
  var rutaAplicativoAuth = "https://auth.sinfo.co/auth/verify/";
  var arrAuth =   {
                    token:token,
                    body:
                    {
                      email:"cp-" + email
                    }
                  };
  $.ajax(
  {
      url: rutaAplicativoAuth,
      type: "POST",
      data: JSON.stringify(arrAuth),
      contentType: 'application/json; charset=utf-8',
      dataType: 'json',
      async: false,
      success: function(msg) 
      {
          var msgDividido = JSON.stringify(msg);
          var mensaje =  JSON.parse(msgDividido);
          var msgDivididoDos = JSON.stringify(mensaje.message);
          salida = mensaje.status;
      }
  });

  return salida;
}

function verificarEstadoCP(email, token)
{
  var arrcp = {token:token, body:{email:email.toLowerCase().replace('cp-','')}}; 
  var rutaAplicativoCP= "https://appdes.copropiedad.co/api/estados/obtener/";
  var salida = 99;
  $.ajax({
      url: rutaAplicativoCP,
      type: "POST",
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
          salida = mensaje2.message;
        }
      }
    });
  return salida;
}

function verificarEstadoCRM(email, token)
{
  var arrcp = {token:token, body:{email:email.toLowerCase().replace('cp-','')}}; 
  var rutaAplicativoCP= "https://appdes.copropiedad.co/api/estados/obtener/";
  var salida = -1;
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
          salida = mensaje2.message;
        }
      }
    });
  return salida;
}

if (typeof String.prototype.startsWith != 'function') {
  String.prototype.startsWith = function (str){
    return this.indexOf(str) === 0;
  };
}

function makeString(object) {
      if (object == null) return '';
      return String(object);
    };
 
function escapeRegExp(str) {
      return makeString(str).replace(/([.*+?^=!:${}()|[\]\/\\])/g, '\\$1');
    };
     
function defaultToWhiteSpace(characters) {
      if (characters == null)
        return '\\s';
      else if (characters.source)
        return characters.source;
      else
        return '[' + escapeRegExp(characters) + ']';
    };  
     
function ltrim(str, characters) {
    var nativeTrimLeft = String.prototype.trimLeft;
      str = makeString(str);
      if (!characters && nativeTrimLeft) return nativeTrimLeft.call(str);
      characters = defaultToWhiteSpace(characters);
      return str.replace(new RegExp('^' + characters + '+'), '');
    };
 
function trim(str, characters) {
    var nativeTrim = String.prototype.trim;
      str = makeString(str);
      if (!characters && nativeTrim) return nativeTrim.call(str);
      characters = defaultToWhiteSpace(characters);
      return str.replace(new RegExp('^' + characters + '+|' + characters + '+$', 'g'), '');
    };
     
function rtrim(str, characters) {
    var nativeTrimRight = String.prototype.trimRight;
      str = makeString(str);
      if (!characters && nativeTrimRight) return nativeTrimRight.call(str);
      characters = defaultToWhiteSpace(characters);
      return str.replace(new RegExp(characters + '+$'), '');
    };

function convertUTCDateToLocalDate(date) {
    var newDate = new Date(date.getTime()+date.getTimezoneOffset()*60*1000);
    var offset = date.getTimezoneOffset() / 60;
    var hours = date.getHours();
    newDate.setHours(hours - offset);
    return newDate;   
}