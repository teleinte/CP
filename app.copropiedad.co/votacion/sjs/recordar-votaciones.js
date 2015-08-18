$(document).ready(function(){
  
    $("#alertas").html('<div class="alert alert-dismissable alert-info"><h4 teid="vo:html:77"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>');  
    $(document).renderme('enc');
      $("#regreso").hide();
      var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
      var arr = {token:sessionStorage.getItem('token'),body:{_id:params['idt']}};
      var response = traerDatosSync("encuestas/encuesta/copropiedad/filtro", arr, sessionStorage.getItem('cp'));
      traerCabecerasEnvio(response);
      try
      {
        var arr = {token:sessionStorage.getItem('token'),body:{id_encuesta:params['idt']}};
        var response = traerDatosSync("encuestas/encuestaEnvio/listar", arr);  
      }catch(err) {
        var nohayerror;
      }
      // traerEnvio(response);
    $("#mastarde").click(function(event){
      var pagina="index.php";
      setTimeout(refreshWindow(pagina),1000);
    });

    $("#form-envio-encuesta").submit(function(event){
      var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;});
      event.preventDefault();
      var ParamFecha=fecha();        
      //solicitando un toquen para la encuesta
      var arr = {body:{id_encuesta:$('#id_encuesta').val(),fechaFin:$('#fechaFin').val()}};
      var url = "encuestas/tokenEncuesta";
      var response = traerDatosSync("encuestas/tokenEncuesta", arr);
      $.each(response, function(x , y)
        {
            retornado=y;
        });
      // esta es la cosa esta 
      var arr = {token:sessionStorage.getItem('token'),body:{id_encuesta:$('#id_encuesta').val()}};

      var url = "encuestas/encuesta/VotantesFaltantes/";
      var llegada = envioFormularioMessageSync(url,arr,'POST');
      var correosTotales="";
      var enviadoTotal=0;
      var pendientesEnvio = "";
      $.each(llegada, function(x , y)
      {
        if(x=="message")
        {
          $.each(y, function(alfa , beta)
          {              
              pendientesEnvio += beta+",";
              enviadoTotal++;
          });
        }
      });
      enviocorreovotacion("app.copropiedad.co", pendientesEnvio.substring(0, pendientesEnvio.length-1), $('#mensaje').val(), $('#fechaFin').val(), obtenerTerminoLenguage('ma','50') +$('#asunto').val(), traerDireccion()+"render-encuesta/",retornado);
      sessionStorage.setItem("cenvios",'<div class="alert alert-dismissable alert-info" style="height:10px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> '+obtenerTerminoLenguage('ale','43')+ enviadoTotal +obtenerTerminoLenguage('ale','44')+$('#asunto').val()+'</div>');
      var pagina="index.php";
      setTimeout(refreshWindow(pagina),8000);
      });

    $(document).renderme('en');
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