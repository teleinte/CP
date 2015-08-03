function envioFormulario(arr,url,metodo)
{
    var rutaAplicativo = traerDireccion()+"api/payu/";
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
                if(url=="pagar" && metodo=="POST")
                    {
                        $('#resultado').html('<div class="alert alert-dismissable alert-success" style="height:10px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Pago guardado BD.</div>');
                        //setTimeout('index.php', 1000);
                        //window.location = 'index.php';
                    }
                if(url=="usuarios/pagosonline" && metodo=="POST")
                    {
                        $('#resultado').html('<div class="alert alert-dismissable alert-success" style="height:10px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Datos correctamente almacenados.</div>');
                        //setTimeout('index.php', 1000);
                        //window.location = 'index.php';
                    }
            }
            else
            {
                $('#resultado').html(mensaje.error);
            }
        }
    });        
}

function traerDatos(arr,url,metodo)
{
  var rutaAplicativo = traerDireccion()+"api/payu/";
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
                               
                t.row.add( 
                  [
                  '',                            
                  y['referenceCode'],
                  y['buyerEmail'],
                  y['description'],
                  y['estado'],
                  y['amount'],
                  y['fecha_creacion']
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

function TraerModulosCopropiedad(arr,url,metodo){ 
    //alert("Ahora Si");
    var rutaAplicatico = traerDireccion()+"api/admin/copropiedad/";
    $.ajax(
        {
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
                    window.location = '../index.php';
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