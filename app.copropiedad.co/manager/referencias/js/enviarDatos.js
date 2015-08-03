function envioFormulario(arr,url,metodo,params)
{
    //var rutaAplicativo = "http://localhost/managercp/";
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
                if(url=="referencias" && metodo=="PUT")
                    {
                        $('#alertas').html('<div class="alert alert-dismissable alert-success" style="height:10px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Datos cambiados correctamente.</div>');
                        //setTimeout('index.php', 1000);
                        //window.location = '../dashboard/dashboard.php';
                    }
                if(url=="referencias" && metodo=="POST")
                    {
                        $('#alertas').html('<div class="alert alert-dismissable alert-success" style="height:10px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Datos almacenados correctamente.</div>');
                        //setTimeout('index.php', 1000);
                        //window.location = '../dashboard/dashboard.php';
                    }
                if(url=="referencias" && metodo=="DELETE")
                    {
                        $('#alertas').html('<div class="alert alert-dismissable alert-success" style="height:10px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Datos eliminados correctamente.</div>');
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
                            y['id_ref'],
                            y['name_ref'],
                            y['campana_ref'],
                            y['time_ref'] + " meses" ,
                            y['valor_ref'],
                            '<a class="btn" href="edit_ref.php?idt='+idMongoFinal.$id+'">Editar</a> <a class="btn" href="del_ref.php?idt='+idMongoFinal.$id+'">Eliminar</a>'//'<a id="open-editarcopripiedad" class="btn" href="nueva_ref.php?idt='+idMongoFinal.$id+'"></a>',//<a class="btn borrar solo inline" href="tarea-eliminar.php?idt='+idMongoFinal.$id+'"></a>'
                        ] ).draw();
                    //$('#id_ref').val(y['id_ref']);
                    //$('#name_ref').val(y['name_ref']);
                    //$('#campana_ref').val(y['campana_ref']);
                    //$("#time_ref").val(y['time_ref']),
                    //$('#valor_ref').val(y['valor_ref']);
                    
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
          $.each(datos, function(x , y) 
          {             
            var idmongo= JSON.stringify(y['_id']);
            var idMongoFinal = JSON.parse(idmongo);
            if(idMongoFinal.$id==params['idt'])
            {               
              $('#id_ref').val(y['id_ref']);
              $('#name_ref').val(y['name_ref']);
              $('#campana_ref').val(y['campana_ref']);
              $("#time_ref").val(y['time_ref']);
              $('#valor_ref').val(y['valor_ref']);  
            }                                    
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
                          $('#id_ref').val(y['id_ref']);
                          $('#name_ref').val(y['name_ref']);
                          $('#campana_ref').val(y['campana_ref']);
                          $("#time_ref").val(y['time_ref']);
                          $('#valor_ref').val(y['valor_ref']);  
                        }                                                       
                    })
                }                
            }
        });
}