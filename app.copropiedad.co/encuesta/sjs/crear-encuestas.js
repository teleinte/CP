$(document).ready(function() {
    $(document).renderme('en');

    var iCnt = 0;
    // CREATE A "DIV" ELEMENT AND DESIGN IT USING JQUERY ".css()" CLASS.
    var container = $(document.createElement('div')).css({
        padding: '0', margin: '0 0 10px 0', width: '100%', border: 'none'
    });

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

    $('#btAdd').click(function() {
        if (iCnt <= 19) {
            iCnt = iCnt + 1;
            // ADD TEXTBOX.
            $(container).append('<div id="pregunta' + iCnt + '" class="clearfix" style="padding: 10px 10px 0; border:2px solid #aaa; margin-bottom:10px; background-color:#eee;"><table><tr><td width="33%"></td><td width="34%"></td><td width="33%"></td></tr> <tr> <td> <label for="enunciado-pregunta' + iCnt + '" teid="en:html:17"></label> <input type=text class="input" id="enunciado-pregunta' + iCnt + '" name="enunciado-pregunta' + iCnt + '" required/></td><td><label for="tipo-pregunta' + iCnt + '" teid="en:html:18"></label> <select id="tipo-pregunta' + iCnt + '" name="tipo-pregunta' + iCnt + '"> <option value="seleccion_multiple_unica_respuesta" teid="en:html:19"></option> <option value="seleccion_multiple_multiple_respuesta" teid="en:html:20"></option> <option value="abierta" teid="en:html:21"></option> </select> </td> <td class="opciones"> <label for="obligatoria' + iCnt + '" teid="en:html:22"></label> <input id="obligatoria' + iCnt + '" type="checkbox" checked><span teid="en:html:23"></span></td> </tr> <tr> <td colspan="3"> <label for="opciones-pregunta' + iCnt + '" teid="en:html:24"></label> <textarea id="opciones-pregunta' + iCnt + '" rows="4" required></textarea> </td> </tr> </table></div>');
            $('#btAdd').attr('class', 'btn icono agregar ttip positivo'); 
            $('#btRemove').attr('class', 'btn icono agregar ttip'); 
            $('#pregunta0').after(container);   // ADD BOTH THE DIV ELEMENTS TO THE "main" CONTAINER.
            $("#tipo-pregunta" + iCnt).change(function(){
                if($(this).val() == "abierta"){
                    $("#opciones-pregunta" + iCnt).attr('required',false);
                    $("#opciones-pregunta" + iCnt).removeAttr('minlength');
                }
                else{
                    $("#opciones-pregunta" + iCnt).attr('required',true);
                    $("#opciones-pregunta" + iCnt).attr('minlength','3');
                }
            });
            $('textarea:required').attr('minlength','3');
            $(document).renderme('en');
        }
        else {      // AFTER REACHING THE SPECIFIED LIMIT, DISABLE THE "ADD" BUTTON. (20 IS THE LIMIT WE HAVE SET)
            $(container).append('<label class="limite-preg" teid="en:html:28"></label>'); 
            $('#btAdd').attr('class', 'btn icono agregar disabled ttip'); 
            $('#btAdd').attr('disabled', 'disabled');
            $(document).renderme('en');
        }
    });

    $('#btRemove').click(function() {   // REMOVE ELEMENTS ONE PER CLICK.
        if (iCnt != 0) 
        {
            $('#pregunta' + iCnt).remove(); 
            iCnt = iCnt - 1; 
            $('.limite-preg').remove();
            $('#btAdd').attr('class', 'btn icono agregar ttip positivo'); 
            $('#btRemove').attr('class', 'btn icono agregar ttip'); 
        }
        
        if (iCnt == 0) 
        { 
            $(container).empty(); 
            $(container).remove();
            $('#btAdd').attr('class', 'btn icono agregar ttip positivo'); 
            $('#btRemove').attr('class', 'btn icono agregar ttip'); 
        }
        
        if (iCnt <= 20) 
        {
            $('#btAdd').removeAttr('disabled');
            $('#btAdd').attr('class', 'btn icono agregar ttip positivo');
        }
    });

    $('#tipo-pregunta0').change(function(){
        if($(this).val() == "abierta"){
            $("#opciones-pregunta0").attr('required',false);
            $("#opciones-pregunta0").removeAttr('minlength');
        }
        else{
            $("#opciones-pregunta0").attr('required',true);
            $("#opciones-pregunta0").attr('minlength','3');
        }
    });

    $("#form-encuesta").submit(function(event){
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
                    tipo:obtenerTerminoLenguage('en','29'),
                    fecha_fin:new Date($("#datepicker").val()).toISOString(),
                    nombre:$('#nombre').val(),
                    descripcion:$('#descripcion').val(),
                    estado:obtenerTerminoLenguage('en','35'),
                    invitados:"",
                    invitados_externos:""
                }
            };
        //alert(JSON.stringify(arr));    
        var url = "encuestas/encuesta";
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
            if($('#tipo-pregunta'+j).val()!="Abierta")
            {
                for (i in partido) 
                {
                    resultado+=letras[i]+"|"+partido[i]+","                    
                } 
            }
            var obligatorio;
            if($('#obligatoria'+j).is(':checked')){
                obligatorio=obtenerTerminoLenguage('en','30');
            } else {                        
                obligatorio=obtenerTerminoLenguage('en','31');
            }
            arrPregunta = 
            {
                token:sessionStorage.getItem('token'),
                body:
                {
                    id_encuesta:retornado,
                    pregunta:$('#enunciado-pregunta'+j).val(),
                    tipo:$('#tipo-pregunta'+j).val(),
                    opciones:resultado,
                    obligatorio:obligatorio
                    //opciones:[{"A":"si"},{"B":"no"}]
                }
            }
            $(document).renderme('en');
            var url = "encuestas/encuesta/pregunta";
            //alert(JSON.stringify(arrPregunta))
            envioFormularioSync(url,arrPregunta,'POST');
        }

        var pagina="enviar-encuesta.php?idt="+retornado;
        setTimeout(refreshWindow(pagina),1000);
  });

    $('textarea:required').attr('minlength','3');

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