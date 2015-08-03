$(document).ready(function() {
    $(document).renderme('vo');
    var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
    var arr = {token:sessionStorage.getItem('token'),body:{_id:params['idt']}};
    var response = traerDatosSync("votacion/encuesta/copropiedad/filtro",arr);
    traerDatosEliminables(response);

    $("#encuesta_form_eliminar").submit(function(event){
          event.preventDefault();
          var ParamFecha=fecha();
          var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
          if ($('#opcion').val()=="NO")
          {
              var pagina="index.php";
              setTimeout(refreshWindow(pagina),1000);
              return false;
          }
          var arr = 
          {
              token:sessionStorage.getItem('token'),
              body:
              {
                  id:params['idt'],
                  id_copropiedad:$('#id_copropiedad').val(),
                  id_crm_persona:$('#id_crm_persona').val(),
                  fecha_creacion:$('#fecha_creacion').val(),
                  tipo:"votacion",
                  fecha_fin:$('#fecha_fin').val(),
                  nombre:$('#nombre').val(),
                  descripcion:$('#descripcion').val(),
                  estado:(3).toString(),
                  invitados:$('#invitados').val(),
                  invitados_externos:$('#invitados_externos').val()
              }
          };
          //alert(JSON.stringify(arr));
                    
          response= envioFormularioSync("votacion/encuesta",arr,'PUT');
          if(response)
          {
              var pagina="index.php";
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