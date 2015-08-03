$(document).ready(function() {
    $(document).renderme('vo');
    var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
    var arr = {token:sessionStorage.getItem('token'),body:{_id:params['idt']}};
    var response = traerDatosSync("votacion/encuesta/pregunta/filtro",arr);
    traerPreguntasModificables(response);

    $("#opciones-pregunta0").attr('minlength','3');
    
    $("#form-edita-pregunta").submit(function(event){
          event.preventDefault();
          var ParamFecha=fecha();
          var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
          var letras = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"];
          var resultado = "";
          var partido = [];
          var arrPregunta={};
          partido = $('#opciones_pregunta0').val().split("\n");
          for (i in partido) 
          {
              resultado+=letras[i]+"|"+partido[i]+","                    
          } 
          var arrPregunta = 
          {                        
              token:sessionStorage.getItem('token'),
              body:
              {
                  id:params['idt'],
                  id_encuesta:$('#id_encuesta').val(),
                  pregunta:$('#enunciado_pregunta0').val(),
                  tipo:"seleccion_multiple_unica_respuesta",
                  opciones:resultado,
                  obligatorio:"SI"
              }
          };
          response= envioFormularioSync("votacion/encuesta/pregunta",arrPregunta,'PUT');
          if(response)
          {
              var pagina="votacion-editar.php?idt="+$('#id_encuesta').val();
              setTimeout(refreshWindow(pagina),1000); 
          }     
      });

      $("#form-elmina-pregunta").submit(function(event){
          event.preventDefault();
          var ParamFecha=fecha();
          var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
          
          if ($('#opcion').val()=="NO")
          {
              var pagina= 'encuesta-editar.php?idt='+$('#id_encuesta').val();
              setTimeout(refreshWindow(pagina),1000); 
          }
          var arr = {token:sessionStorage.getItem('token'),body:{id_pregunta:params['idt']}};
          //alert(JSON.stringify(arr));
          var url = "votacion/encuesta/pregunta";
          
          response= envioFormularioSync("votacion/encuesta/pregunta",arr,'DELETE');
          if(response)
          {
              var pagina="encuesta-editar.php?idt="+$('#id_encuesta').val();
              setTimeout(refreshWindow(pagina),1000); 
          }                
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