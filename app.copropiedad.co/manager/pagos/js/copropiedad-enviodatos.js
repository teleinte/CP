function envioFormulario(arr,url,metodo,params)
{
  var rutaAplicativo = "https://aws02.sinfo.co/api/managercp/";
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
      //alert(JSON.stringify(mensaje.message));
      if(mensaje.status)
      { 
        if(url=="pagosteleinte" && metodo=="PUT")
        {
          $('#alertas').html('<div class="alert alert-dismissable alert-success" style="height:10px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Datos cambiados correctamente.</div>');
          //setTimeout('index.php', 1000);
          //window.location = '../dashboard/dashboard.php';
        }
        if(url=="pagosteleinte" && metodo=="POST")
        {
          $('#alertas').html('<div class="alert alert-dismissable alert-success" style="height:10px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Datos almacenados correctamente.</div>');
          //setTimeout('index.php', 1000);
          //window.location = '../dashboard/dashboard.php';
        }
        if(url=="pagosteleinte" && metodo=="DELETE")
        {
          $('#alertas').html('<div class="alert alert-dismissable alert-success" style="height:10px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Datos eliminados correctamente.</div>');
          //setTimeout('index.php', 1000);
          //window.location = '../dashboard/dashboard.php';
        }
        if(url=="dar_vigencia" && metodo=="POST")
        {
          $('#alertas').html('<div class="alert alert-dismissable alert-success" style="height:10px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Vigencia almacenada correctamente.</div>');
            location.href='index.php'
          //setTimeout('index.php', 1000);
          //window.location = '../dashboard/dashboard.php';
        }
      }
      else
      {
        $('#alertas').html(mensaje.error);
      }
    }
  });        
}

function traerDatos(arr,url,metodo)
{
  var rutaAplicativo = "https://aws02.sinfo.co/api/managercp/";
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
          $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>');               
          window.location = '../index.php';
      }
      else
      { 
        if(mensaje.status)
        {
            $.each(datos, function(x , y) 
            {
              if(y['id_crm_persona'])
              {
                var idmongo= JSON.stringify(y['id_copropiedad']);
                var id_pago= y['referenceCode'];
                //alert(idmongo);
                var id_copropiedadFinal = JSON.parse(idmongo);
                //alert(id_copropiedadFinal);
                var t = $('#example').DataTable();
                var boton='';
                if (y['cruzado']=='0' && y['estado']=='1')
                {
                  boton='<a class="btn" href="confirme_vigencia.php?id='+id_copropiedadFinal+'+'+id_pago+'">Dar Vigencia</a>'
                }
                
                t.row.add( 
                  [
                  '',                            
                  y['name_pagador'],
                  y['email_pagador'],
                  y['ncp'],
                  y['referencia_activa'],
                  y['referenceCode'],
                  y['valor'],
                  y['estado'],
                  boton
                  //' <a class="btn" href="del_client.php?idt='+idMongoFinal.$id+'">Eliminar</a>'//'<a id="open-editarcopripiedad" class="btn" href="nueva_ref.php?idt='+idMongoFinal.$id+'"></a>',//<a class="btn borrar solo inline" href="tarea-eliminar.php?idt='+idMongoFinal.$id+'"></a>'
                  ] ).draw();
              }
              
            })
        }
        else
        {
            $('#alertas').html('<div class="alert alert-dismissable alert-success" style="height:10px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Cargue los datos de copropiedad para activar su modulo de pagos en linea. Verifique la tarifa. </div>');
        }
      }
    }
  });       
}

function traerDatosVigencia(arr,url,metodo)
{
  var rutaAplicativo = "https://aws02.sinfo.co/api/managercp/";
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
          $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>');               
          window.location = 'index.php';
      }
      else
      { 
        if(mensaje.status)
        {
          $.each(datos, function(x , y) 
          {
            if(y['id_crm_persona'])
            {
              //var idmongo= JSON.stringify(y['id_copropiedad']);
              //var id_copropiedadFinal = JSON.parse(idmongo);
              //alert(id_copropiedadFinal);
              $('#id_crm_persona').val(y['id_crm_persona']);
              $('#fecha_pago').val(y['fecha_pago']);
              $('#fecha_confirmacion').val(y['fecha_confirmacion']);
              $('#referencia_activa').val(y['referencia_activa']);
              $('#valor').val(y['valor']);
              $('#id_copropiedad').val(y['id_copropiedad']);
              $('#ncp').val(y['ncp']);
              $('#cruzado').val(y['cruzado']);
              $('#email_pagador').val(y['email_pagador']);
              $('#name_pagador').val(y['name_pagador']);
              $('#referenceCode').val(y['referenceCode']);
              $('#estado').val(y['estado']);
            }
            //alert($('#referenceCode').val());
          })
        }
        else
        {
            $('#alertas').html('<div class="alert alert-dismissable alert-success" style="height:10px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Cargue los datos de copropiedad para activar su modulo de pagos en linea. Verifique la tarifa. </div>');
        }
      }
    }
  });       
}

