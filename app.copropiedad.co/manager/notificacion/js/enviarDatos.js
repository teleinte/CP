function envioFormulario(arr,url,metodo,params)
{
    //var rutaAplicativo = "http://localhost/managercp/";
    var rutaAplicativo = "https://aws02.sinfo.co/api/notificaciones/";
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
            
            if(mensaje.status)
            {
                if(url=="notificaciones" && metodo=="PUT")
                    {
                        $('#alertas').html('<div class="alert alert-dismissable alert-success" style="height:10px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Datos cambiados correctamente.</div>');
                        location.href='index.php';
                        //setTimeout('index.php', 1000);
                        //window.location = '../dashboard/dashboard.php';
                    }
                if(url=="notificaciones" && metodo=="POST")
                    {
                        $('#alertas').html('<div class="alert alert-dismissable alert-success" style="height:10px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Datos almacenados correctamente.</div>');
                        location.href='index.php';
                        //window.location = '../dashboard/dashboard.php';
                    }
                if(url=="notificaciones" && metodo=="DELETE")
                    {
                        $('#alertas').html('<div class="alert alert-dismissable alert-success" style="height:10px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Datos eliminados correctamente.</div>');
                        location.href='index.php';
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
    //var rutaAplicativo = "http://localhost/managercp/";
    var rutaAplicativo = "https://aws02.sinfo.co/api/notificaciones/";
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
          var t = $('#example').DataTable();
          if (datos=="Token invalido")
          {
              $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>')                  
              window.location = '../index.html';
          }
          else
          { 
            if(mensaje.status)
            { 
              $.each(datos, function(x , y) 
                  {
                    var idmongo= JSON.stringify(y['_id']);
                    var idMongoFinal = JSON.parse(idmongo);
                    t.row.add( [
                            '',                            
                            y['titulo'],
                            y['mensaje'],
                            y['creado_por'],
                            y['fecha_creacion'],
                            y['fecha_despliegue'],
                            y['tipo'],
                            y['prioridad'],
                            '<a class="btn" href="edit_notificacion.php?idt='+idMongoFinal.$id+'">Editar</a> <a class="btn" href="del_notificacion.php?idt='+idMongoFinal.$id+'">Eliminar</a>'//'<a id="open-editarcopripiedad" class="btn" href="nueva_ref.php?idt='+idMongoFinal.$id+'"></a>',//<a class="btn borrar solo inline" href="tarea-eliminar.php?idt='+idMongoFinal.$id+'"></a>'
                        ] ).draw();                    
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
function traerDatosModificables(arr,url,params)
{ 
  var rutaAplicativo = "https://aws02.sinfo.co/api/notificaciones/";    
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
          $.each(datos, function(x , y) 
          {             
            var idmongo= JSON.stringify(y['_id']);
            var idMongoFinal = JSON.parse(idmongo);
            
               
                        
              $('#titulo').val(y['titulo']);
              $('#mensaje').val(y['mensaje']);
              $('#creado_por').val(y['creado_por']);
              $('#fecha_creacion').val(y['fecha_creacion']);
              $('#fecha_despliegue').val(y['fecha_despliegue']);
              $('#tipe').val(y['tipo']);
              $('#prioridad').val(y['prioridad']);
                                              
          })
      }                
    }
  });
}
function traerDatosEliminables(arr,url,params)
{
    var rutaAplicativo = "https://aws02.sinfo.co/api/managercp/";    
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
                          $('#name_client').val(y['name_client']);
                          $('#fecha_registro').val(y['fecha_registro']);
                          $('#fecha_actualizacion').val(y['fecha_actualizacion']);
                          $('#referencia').val(y['referencia']);
                          $('#fecha_fin').val(y['fecha_fin']);
                          $('#cc_client').val(y['cc_client']);
                          $('#email_client').val(y['email_client']);
                          $("#dir_client").val(y['dir_client']);
                          $("#tel_client").val(y['tel_client']);
                          $("#cel_client").val(y['cel_client']);
                          $('#id_crm').val(y['id_crm_persona']);
                          $('#origin_client').val(y['origin_client']);  
                          $("#pais_client").val(y['pais_client']);
                          $('#ciudad_client').val(y['ciudad_client']);  
                        }                                                       
                    })
                }                
            }
        });
}