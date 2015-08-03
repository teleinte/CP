function eventoEdit(mongoid,creacion,nombre,inicio,fin,invitados,otros,frecuencia,cal_cp,notas)
{
    var arr = 
    {
      token:sessionStorage.getItem('token'),
      body:
      {
        id:mongoid,
        id_copropiedad : sessionStorage.getItem('cp'),
        creador: sessionStorage.getItem('id_crm'),
        fecha_creacion:creacion,
        tipo: obtenerTerminoLenguage('cl','38'),
        nombre:nombre,
        estado:obtenerTerminoLenguage('cl','37'),
        fecha_inicio:inicio,
        fecha_fin:fin,
        compartir_invitados:invitados,
        compartir_otros:otros,
        frecuencia:frecuencia,
        cal_copropiedad:cal_cp,
        notas:notas
      }
    }; 
    var url = "eventos/evento/";
    var response = envioFormularioSync(url,arr,'PUT');

    if(response)
    {
        var arre = 
        {
          token:sessionStorage.getItem('token'),
          body:
          {
            idcopropiedad : sessionStorage.getItem('cp'),
            grupo: invitados
          }
        }; 
        $(document).renderme('ma');
        var body = '<h4 style="color:#666 !important;">'+ sessionStorage.getItem('nombreCompleto') + obtenerTerminoLenguage('ma','1') + sessionStorage.getItem('ncp') + obtenerTerminoLenguage('ma','31') + nombre  + obtenerTerminoLenguage('ma','2') +'</h4><ul style="color:#666 !important;"><li>'+obtenerTerminoLenguage('ma','10')+inicio.split("T")[0]+'</li><li>'+obtenerTerminoLenguage('ma','26')+fin.split("T")[0]+'</li><li>'+obtenerTerminoLenguage('ma','11')+inicio.split("T")[1].replace(':00:00',':00').replace('+00:00','')+'</li><li>'+obtenerTerminoLenguage('ma','27')+fin.split("T")[1].replace(':00:00',':00').replace(':30:00',':30')+'</li></ul></p>';
        $(document).renderme('ma');
        //console.warn(body);
        $(document).renderme('ma');
        if(otros.length > 10)           
        {
            $(document).renderme('ma');
            //enviocorreoSync(otros, sessionStorage.getItem('nombreCompleto') +obtenerTerminoLenguage('ma','7') + sessionStorage.getItem('ncp') + obtenerTerminoLenguage('ma','12')+ nombre + obtenerTerminoLenguage('ma','2'), body, traerDireccion());
            enviocorreoSync(otros, obtenerTerminoLenguage('ma','54'), body, traerDireccion());
            $(document).renderme('ma');
        }
        if (invitados != 'ninguno')
        {
            var correos = "";
            var urle = "eventos/usuario/grupo/";
            var responsee = traerDatosSync(urle,arre,'POST');
            if(responsee!=null)
            {
                $.each(responsee,function(k,v)
                {
                    correos = correos + "," + v;
                });
                $(document).renderme('ma');
                //enviocorreoSync(correos.substring(1), sessionStorage.getItem('nombreCompleto') + obtenerTerminoLenguage('ma','7') + sessionStorage.getItem('ncp') + obtenerTerminoLenguage('ma','12') + nombre + obtenerTerminoLenguage('ma','2'), body, traerDireccion());
                enviocorreoSync(correos.substring(1), obtenerTerminoLenguage('ma','54'), body, traerDireccion());
                $(document).renderme('ma');
            }
        }
        //console.warn(responsee);
        setTimeout(refreshWindow('index.php'),2000);
    }
    else
    {
      $("#alertas").html('<div class="alert alert-dismissable alert-error" teid="ale:html:7"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:1"></strong></div>');
      $(document).renderme('cl');
    }
}

function eventoDelete(mongoid,creacion,nombre,inicio,fin,invitados,otros,frecuencia,cal_cp,notas)
{
     var arr = 
     {
       token:sessionStorage.getItem('token'),
       body:
       {
         id:mongoid,
         id_copropiedad : sessionStorage.getItem('cp'),
         creador: sessionStorage.getItem('id_crm'),
         fecha_creacion:creacion,
         tipo: obtenerTerminoLenguage('cl','38'),
         nombre:nombre,
         estado: obtenerTerminoLenguage('cl','40'),
         fecha_inicio:inicio,
         fecha_fin:fin,
         compartir_invitados:invitados,
         compartir_otros:otros,
         frecuencia:frecuencia,
         cal_copropiedad:cal_cp,
         notas:notas
       }
     };
     var url = "eventos/evento/";
     var response = envioFormularioSync(url,arr,'PUT'); 
     if(response)
     {
        
        $(document).renderme('ma');
        var body = '<h4 style="color:#666 !important;">'+ sessionStorage.getItem('nombreCompleto') + obtenerTerminoLenguage('ma','1') + sessionStorage.getItem('ncp') + obtenerTerminoLenguage('ma','29') + nombre + obtenerTerminoLenguage('ma','43') +'</h4><ul style="color:#666 !important;"><li>'+obtenerTerminoLenguage('ma','3')+inicio.split("T")[0]+'</li><li>'+obtenerTerminoLenguage('ma','24')+fin.split("T")[0]+'</li><li>'+obtenerTerminoLenguage('ma','4')+inicio.split("T")[1].replace(':00:00',':00').replace('+00:00','')+'</li><li>'+obtenerTerminoLenguage('ma','25')+fin.split("T")[1].replace(':00:00',':00').replace(':30:00',':30')+'</li></ul></p>';
        $(document).renderme('ma');
        if(otros.length > 10)           
        {
            $(document).renderme('ma');
            //enviocorreoSync(otros, sessionStorage.getItem('nombreCompleto') + obtenerTerminoLenguage('ma','7') + sessionStorage.getItem('ncp') + obtenerTerminoLenguage('ma','29') + nombre + obtenerTerminoLenguage('ma','2'), body, traerDireccion());
            enviocorreoSync(otros, obtenerTerminoLenguage('ma','52'), body, traerDireccion());
            $(document).renderme('ma');
        }

        if(invitados != 'ninguno')
        {
            var arre = 
            {
              token:sessionStorage.getItem('token'),
              body:
              {
                idcopropiedad : sessionStorage.getItem('cp'),
                grupo: invitados
              }
            }; 
            var correos = "";
            var urle = "eventos/usuario/grupo/";
            var responsee = traerDatosSync(urle,arre,'POST');
            if(responsee!=null)
            {
                $.each(responsee,function(k,v)
                {
                    correos = correos + "," + v;
                });
                $(document).renderme('ma');
                //enviocorreoSync(correos.substring(1), sessionStorage.getItem('nombreCompleto') + obtenerTerminoLenguage('ma','7') + sessionStorage.getItem('ncp') + obtenerTerminoLenguage('ma','29') + nombre + obtenerTerminoLenguage('ma','2'), body, traerDireccion());
                enviocorreoSync(correos.substring(1), obtenerTerminoLenguage('ma','52'), body, traerDireccion());
                $(document).renderme('ma');
            }
        }
        setTimeout(refreshWindow('index.php'),2000);
     }
     else
     {
       $("#alertas").html('<div class="alert alert-dismissable alert-error" teid="ale:html:8"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:1"></strong></div>');
       $(document).renderme('cl');
     }
}

function tareaDelete(mongoid,creacion,nombre,fin,frecuencia,notas)
{
     var arr = 
     {
       token:sessionStorage.getItem('token'),
       body:
       {
            id:mongoid,
            id_copropiedad : sessionStorage.getItem('cp'),
            creador: sessionStorage.getItem('id_crm'),
            fecha_creacion:creacion,
            tipo: "tarea",
            nombre:nombre,
            estado:"eliminada",
            fecha_fin:fecha(),
            deadline:fin,
            notas:notas,
            frecuencia:frecuencia
       }
     }; 
     var url = "tareas/list/";
     var response = envioFormularioSync(url,arr,'DELETE');
     if(response)
     {
       setTimeout(refreshWindow(sessionStorage.getItem('referer')),1000);
     }
     else
     {
       $("#alertas").html('<div class="alert alert-dismissable alert-error" teid="ale:html:9"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:1"></strong></div>');
       $(document).renderme('cl');
     }
}

function tareaCompletar(mongoid,creacion,nombre,fin,frecuencia,notas)
{
     var arr = 
     {
       token:sessionStorage.getItem('token'),
       body:
       {
        id:mongoid,
        id_copropiedad : sessionStorage.getItem('cp'),
        creador: sessionStorage.getItem('id_crm'),
        fecha_creacion:creacion,
        tipo: "tarea",
        nombre:nombre,
        estado: "completada",
        fecha_fin:fecha(),
        deadline:fin,
        notas:notas,
        frecuencia:frecuencia
       }
     }; 
     var url = "tareas/list/";
     var response = envioFormularioSync(url,arr,'DELETE');
     if(response)
     {
       setTimeout(refreshWindow(sessionStorage.getItem('referer')),1000);
     }
     else
     {
       $("#alertas").html('<div class="alert alert-dismissable alert-error" teid="ale:html:10"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:1"></strong></div>');
       $(document).renderme('cl');
     }
}


function enviocorreo(){
    var rutaAplicativo = traerDireccion()+"api/mailer/mail/tareas/compartir/";
    var metodo = "POST";
    var mail_arr = $('#compartir_mail').val().split(",");
    for (key in mail_arr) {
    var arr = {
                  token:sessionStorage.getItem('token'),
                  body:
                  {  
                        id_crm_persona:sessionStorage.getItem('id_crm'),
                        fecha_solicitud:fecha(),
                        nombre_remitente:sessionStorage.getItem('nombre'),
                        nombre_tarea:$('#nombre').val(),
                        destinatarios:[  
                           {  
                              nombre:obtenerTerminoLenguage('cl','43'),
                              email:mail_arr[key]
                           }
                        ],
                  }
                }; 
                console.log(JSON.stringify(arr));
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
    });
    }       
}

function enviocorreoEvento(eventin){
        var rutaAplicativo = traerDireccion()+"api/mailer/mail/eventos/compartir/";
        var metodo = "POST";        
        var arr = 
        {
            token:sessionStorage.getItem('token'),
            body:
            {
                id_copropiedad : sessionStorage.getItem('cp'),
                id_evento:eventin,
                id_crm_persona:sessionStorage.getItem('id_crm'),
                fecha_solicitud:fecha(),
                nombre_remitente:sessionStorage.getItem('nombre'),                        
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
        });      
}