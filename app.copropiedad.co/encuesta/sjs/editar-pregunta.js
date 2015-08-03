$(document).ready(function() {
    $(document).renderme('en');
    var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
    var arr = {token:sessionStorage.getItem('token'),body:{_id:params['idt']}};
    var response = traerDatosSync("encuestas/encuesta/pregunta/filtro",arr);
    traerPreguntasModificables(response);


    $("#form-edita-pregunta").submit(function(event){
          event.preventDefault();
          var ParamFecha=fecha();
          var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
          var letras = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"];
          var resultado = "";
          var partido = [];
          var arrPregunta={};
          partido = $('#opciones_pregunta0').val().split("\n");
          if($('#tipo_pregunta0').val()!="Abierta")
          {
              for (i in partido) 
              {
                  resultado+=letras[i]+"|"+partido[i]+","                    
              } 
          }
          var obligatorio;
          if($('#obligatoria0').is(':checked')){
              obligatorio=obtenerTerminoLenguage('en','30');
          } else {                        
              obligatorio=obtenerTerminoLenguage('en','31');
          }
          var arrPregunta = 
          {                        
              token:sessionStorage.getItem('token'),
              body:
              {
                  id:params['idt'],
                  id_encuesta:$('#id_encuesta').val(),
                  pregunta:$('#enunciado_pregunta0').val(),
                  tipo:$('#tipo_pregunta0').val(),
                  opciones:resultado,
                  obligatorio:obligatorio
              }
          };

          
          response= envioFormularioSync("encuestas/encuesta/pregunta",arrPregunta,'PUT');
          if(response)
          {
              var pagina="encuesta-editar.php?idt="+$('#id_encuesta').val();
              setTimeout(refreshWindow(pagina),1000); 
          }

                 
      });

      $("#form-elmina-pregunta").submit(function(event){
          event.preventDefault();
          var ParamFecha=fecha();
          var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
          
          if ($('#opcion').val()==obtenerTerminoLenguage('en','31'))
          {
              var pagina= 'encuesta-editar.php?idt='+$('#id_encuesta').val();
              setTimeout(refreshWindow(pagina),1000); 
          }
          var arr = {token:sessionStorage.getItem('token'),body:{id_pregunta:params['idt']}};
          //alert(JSON.stringify(arr));
          var url = "encuestas/encuesta/pregunta";
          
          response= envioFormularioSync("encuestas/encuesta/pregunta",arr,'DELETE');
          if(response)
          {
              var pagina="encuesta-editar.php?idt="+$('#id_encuesta').val();
              setTimeout(refreshWindow(pagina),1000); 
          }

                 
      });

      $('#tipo_pregunta0').change(function(){
          if($(this).val() == "abierta"){
              $("#opciones_pregunta0").attr('required',false);
              $("#opciones_pregunta0").removeAttr('minlength');
          }
          else{
              $("#opciones_pregunta0").attr('required',true);
              $("#opciones_pregunta0").attr('minlength','3');
          }
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