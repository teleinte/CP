$(document).ready(function() {
    $(document).renderme('vo');
    
    $("#opciones-pregunta0").attr('minlength','3');
      if(!Modernizr.inputtypes.date){
        $("#datepicker").datepicker({
          minDate: 0,
          dateFormat: 'yy-mm-dd'
        });
    }
    else
    {
      var d = new Date();
      var da = d.toISOString().split("T")[0];
      $('input[type=date]').attr('min',da);
    }

    $("#form-votacion").submit(function(event){
     event.preventDefault();
     var ParamFecha=fecha();
      
      var arr = 
            {
                token:sessionStorage.getItem('token'),
                body:
                {
                    id_copropiedad:sessionStorage.getItem('cp'),
                    id_crm_persona:sessionStorage.getItem('id_crm'),
                    fecha_creacion:ParamFecha,
                    tipo:"votacion",
                    fecha_fin:new Date($("#datepicker").val()).toISOString(),
                    nombre:$('#nombre').val(),
                    descripcion:$('#descripcion').val(),
                    estado:"1",
                    invitados:"",
                    invitados_externos:""
                }
            };
        //alert(JSON.stringify(arr));    
        var url = "votacion/encuesta";
        response= envioFormularioMessageSync(url,arr,'POST');
        
        var msgDividido = JSON.stringify(response);
        var mensaje =  JSON.parse(msgDividido);
        var response = JSON.stringify(mensaje.message);
        $.each(mensaje.message, function(x , y){ retornado=y;});
        //alert(retornado);

        var letras = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"];                
        for (j=0;j<20;j++)
        {                    
            if (!$('#enunciado-pregunta'+j).val())
            {
                //alert("No hay nada mijo");
                break;
            }
            var partido = [];
            var arrPregunta={};
            partido = $('#opciones-pregunta'+j).val().split("\n");
            var resultado = "";
            
            for (i in partido) 
            {
                resultado+=letras[i]+"|"+partido[i]+","                    
            } 
            
            
           
            arrPregunta = 
            {
                token:sessionStorage.getItem('token'),
                body:
                {
                    id_encuesta:retornado,
                    pregunta:$('#enunciado-pregunta'+j).val(),
                    tipo:"seleccion_multiple_unica_respuesta",
                    opciones:resultado,
                    obligatorio:"SI"
                    //opciones:[{"A":"si"},{"B":"no"}]
                }
            }
            var url = "votacion/encuesta/pregunta";
            //alert(JSON.stringify(arrPregunta))
            envioFormularioSync(url,arrPregunta,'POST');
        }
        var pagina="enviar-votacion.php?idt="+retornado;
        setTimeout(refreshWindow(pagina),1000);
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