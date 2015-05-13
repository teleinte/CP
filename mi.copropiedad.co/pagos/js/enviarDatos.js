function envioFormulario(arr,url,metodo)
{
    var rutaAplicativo = "https://app.copropiedad.co/api/payu/";
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
              return true;
            }
            else
            {
                $('#resultado').html(mensaje.error);
            }
        }
    });        
}
function TraerModulosCopropiedad(arr,url,metodo){ 
    var rutaAplicatico = "https://app.copropiedad.co/api/admin/copropiedad/";
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
function traerDatos(arr,url,metodo,pagos)
{
    var rutaAplicativo = "https://app.copropiedad.co/api/cartera/";
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
              $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>')                  
              window.location = '../index.html';
          }
          else
          {  
            if(mensaje.status)
            { 
              var montos = Array();
              var conceptos= Array();
              var cont = 0;
              if(datos.length > 0)
              $.each(datos, function(x , y) 
              {
                var actual = Number(y['monto']);
                var convertido = '$ ' + actual.toLocaleString('es-CO', { style: 'currency', currency:'COP'});
                var t = $('#example').DataTable();
                var codigo = btoa(sessionStorage.getItem('email')+"^"+y['documento']+"^"+y['concepto']+"^"+y['monto']+"^"+pagos['merchantId']+"^"+pagos['apikey']+"^"+pagos['accountId']);
                  t.row.add(['',y['documento'],y['concepto'],convertido,'<a class="btn" href="pagar.php?id='+codigo+'"> Pagar <a/>'] ).draw();
              });
            }
            else
            {
                $('#alertas').html('<div class="alert alert-dismissable alert-success" style="height:10px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Cargue los datos de copropiedad para activar su modulo de pagos en linea. Verifique la tarifa. </div>');
            }
          }
        }
    });       
}
function traerDatosP()
{
    var rutaAplicativo = "https://app.copropiedad.co/api/payu/consulta/copropiedad/pagosonline/";
    var arr = {token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp')}};
    var pagodata = "";
    $.ajax(
    {   
      url: rutaAplicativo,
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
          test = "1";
          
          if (datos=="Token invalido")
          {
              $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>')                  
              window.location = '../index.html';
          }
          else
          {  
            if(mensaje.status)
            { 
              pagodata = mensaje.message[0];
            }
            else
            {
                $('#alertas').html('<div class="alert alert-dismissable alert-success" style="height:10px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Cargue los datos de copropiedad para activar su modulo de pagos en linea. Verifique la tarifa. </div>');
            }
          }
        }
    });     
    return pagodata;
}