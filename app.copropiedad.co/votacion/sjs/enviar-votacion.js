$(document).ready(function(){
    $(document).renderme('vo');
      var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
      var arr = {token:sessionStorage.getItem('token'),body:{_id:params['idt']}};
      var response = traerDatosSync("votacion/encuesta/copropiedad/filtro", arr, sessionStorage.getItem('cp'));
      traerCabecerasEnvio(response);    
      $("#alertas").html('<div class="alert alert-dismissable alert-info" teid="ale:html:137"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>');  
      try
      {
        var arr = {token:sessionStorage.getItem('token'),body:{id_encuesta:params['idt']}};
        var response = traerDatosSync("votacion/encuestaEnvio/listar", arr);  
      }catch(err) {
        var nohayerror;
      }
      // traerEnvio(response);
    $("#mastarde").click(function(event){
        var pagina="index.php";
        setTimeout(refreshWindow(pagina),1000);
    })


    $("#form-envio-encuesta").submit(function(event){
      var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;});
      event.preventDefault();
      var ParamFecha=fecha();        
      //solicitando un toquen para la vatacion
      var arr = {body:{id_encuesta:$('#id_encuesta').val(),fechaFin:$('#fechaFin').val()}};
      var url = "votacion/tokenEncuesta";
      var response = traerDatosSync("votacion/tokenEncuesta", arr);      
      $.each(response, function(x , y)
        {
            retornado=y;
        });
      
      // cambiando el estado de la cabecera a estado 2. creada enviada
      var arr = {token:sessionStorage.getItem('token'),body:{id_encuesta:$('#id_encuesta').val()}};
      var url = "encuestas/creadaenviada";
      var response = envioFormularioSync(url, arr,"PUT");

      // esta es la cosa esta 
      var arr = 
      {
          token:sessionStorage.getItem('token'),
          body:
          {
              id_copropiedad:sessionStorage.getItem('cp'),
              id_encuesta:$('#id_encuesta').val(),
              invitados:$('#invitados').val(),
              invitados_externos:$('#odestinatario').val(),
              tokenencuesta:retornado,
              asunto:$('#asunto').val(),
              mensaje:$('#mensaje').val(),                            
              urlencuesta:traerDireccion()+"render-encuesta/"
          }
      };      
      var url = "encuestas/encuestaEnvio";
      var llegada = envioFormularioMessageSync("encuestas/encuestaEnvio",arr,'POST')
      var correosTotales="";
      var enviadoTotal=0;

      $.each(llegada, function(x , y)
      {
        if(x=="message")
        {
          $.each(y, function(alfa , beta)
          {              
              if(alfa=="correostotales"){correosTotales = beta}
              if(alfa=="enviadototal"){enviadoTotal = beta}
          });
        }
      });

      //pintar cuantos se han invitado 
      var total=enviadoTotal; 

      $(document).renderme('en');
      if(total==0)
      {
        sessionStorage.setItem("cenviosvotos",'<div class="alert alert-dismissable alert-error" style="height:10px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:1"></strong>La votación no se envió, Los usuarios digitados o elegidos ya habian sido notificados o no existen en el sistema</div>');
        $(document).renderme('vo');
      }
      else
      {
        $(document).renderme('vo');
        enviocorreovotacion("app.copropiedad.co", correosTotales, $('#mensaje').val(), $('#fechaFin').val(),obtenerTerminoLenguage('ma','49') + $('#asunto').val(), traerDireccion()+"render-encuesta/",retornado)
        $(document).renderme('vo');
        sessionStorage.setItem("cenviosvotos",'<div class="alert alert-dismissable alert-info" style="height:10px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> '+obtenerTerminoLenguage('ale','45')+ total +obtenerTerminoLenguage('ale','46')+$('#asunto').val()+'</div>');
        $(document).renderme('vo');
      }
      var pagina="index.php";
      setTimeout(refreshWindow(pagina),8000);
      });

    $(document).renderme('vo');
    $(".ttip").addClass("tooltip-boton");

    $( ".tooltip-boton[title!='']" ).qtip({
      position: {
        my: 'top center',
            at: 'bottom center',
            viewport: $(window), //para correr el tooltip si no cabe en la pantalla
        adjust: {
          method: 'flip invert' //método de ajuste si no cabe en la pantalla
        }
          },
      style: {
            tip: {
                corner: false
            }
        }
    });
});