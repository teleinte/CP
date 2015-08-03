$(document).ready(function(){

  $(document).renderme('co');
  $(document).renderme('ale');
  $('.selector-copropiedad').html("<span class=titulo-cop><strong>"+ sessionStorage.getItem('ncp') +"</strong></span>");
  //$("#selcopropiedades").prop('disabled', true);
  var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})

  var arr = { token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp')}};
  var datos = traerDatosSync("contabilidad/obtener/cargos", arr);
  traerDatosCargos(datos);

  var iCntC = parseInt($('#numeradores').val());
  if (iCntC==0)
  {
      iCntC=1;
  }
    // CREATE A "DIV" ELEMENT AND DESIGN IT USING JQUERY ".css()" CLASS.
    var containers = $(document.createElement('div')).css({padding: '1', margin: '0 0 20px 0', width: '100%', border: 'none'});
    $('#btAddC').click(function() {       
      if (iCntC <= 9) {          
          iCntC += 1;
          // ADD TEXTBOX.
          $(containers).append('<div id=filas' + iCntC + ' class="opciones" style="padding: 20px 1.5% 0; border:2px solid #aaa; background-color:#eee; margin-bottom:5px;"><table><tr><td width="33%"><input type=hidden class="hidden" id=indicesfinales' + iCntC + ' value='+ iCntC +' /><input type=text class="input" id=cargos' + iCntC + ' required/></td><td width="33%"><select data-placeholder="Cuentas contables" class="chosen-select" id=cuentasA' + iCntC + ' style="width:100%;" tabindex="4"><option value=""></option></select></td><td  width="33%"><select data-placeholder="Cuentas contables" class="chosen-select" id=cuentasB' + iCntC + ' style="width:100%;" tabindex="4"><option value=""></option></select></td></tr></table></div>');
          $(document).renderme('co');
          $('#agregar-campos1').after(containers);   // ADD BOTH THE DIV ELEMENTS TO THE "main" CONTAINER.
          $('#cuentasA' + iCntC).append(FormatearCategoriasContables());
          $('#cuentasB' + iCntC).append(FormatearCategoriasContables());
      }
      else {      // AFTER REACHING THE SPECIFIED LIMIT, DISABLE THE "ADD" BUTTON. (20 IS THE LIMIT WE HAVE SET)
          $(containers).append('<label class="limite-fila" teid="co:html:58"></label>'); 
          $(document).renderme('co');
          $('#btAddC').attr('class', 'btn icono agregar disabled ttip'); 
          $('#btAddC').attr('disabled', 'disabled');
      }
    });
    $('#btAddC').click(function() {
      var config = {
        '.chosen-select'           : {},
        '.chosen-select-deselect'  : {allow_single_deselect:true},
        '.chosen-select-creation'  : {create_option: true, skip_no_results: true},
        '.chosen-select-no-single' : {disable_search_threshold:10},
        '.chosen-select-no-results': {no_results_text:'No se encuentra'},
        '.chosen-select-width'     : {width:"95%"}
      }
      for (var selector in config) {
        $(selector).chosen(config[selector]);
      }
    });
        $('#btRemoveC').click(function() {   // REMOVE ELEMENTS ONE PER CLICK.
            if (iCntC != 0) { $('#filas' + iCntC).remove(); iCntC = iCntC - 1; $('.limite-fila').remove();$('#btAddC').attr('class', 'btn icono agregar ttip positivo');}
            if (iCntC == 0) { 
              $(containers).empty(); 
              $(containers).remove();
              $('#btAddC').attr('class', 'btn icono agregar ttip positivo');
            }
      if (iCntC <= 10) {
        $('#btAddC').removeAttr('disabled');
        $('#btAddC').attr('class', 'btn icono agregar ttip positivo');
            }
        });


  $("#nuevoPCuentasCobro").submit(function(event){
    event.preventDefault();
    var ParamFecha=fecha();
    //  crear el inmueble de la copropiedad
    $('input[type=submit]').attr('disabled',true);
    if(parseInt($("#numeradores").val())==0)
    {              
      var recorredores = 2;
    }
    else
    {
       var recorredores =parseInt($("#numeradores").val())+1;
    }
    for (var i = recorredores; i < 21; i++)
    {

        if (!$("#cargos"+i).val())
        {                      
            break;
            return;
        }
        else
        {
          var arr = 
            {
              token:sessionStorage.getItem('token'),
              body:
              {
                mongoid:params["idm"],
                id_copropiedad : sessionStorage.getItem('cp'),
                tipo_documento: "cargos_"+sessionStorage.getItem('cp'),
                estado: 1,
                cargo: $("#cargos"+i).val(),
                Activo_Pasivo: $("#cuentasA"+i).val(),
                cuenta_ingreso: $("#cuentasB"+i).val(),
                identificador:$("#indicesfinales"+i).val()
              }
            }; 
            var url = "contabilidad/crearcargos/";
            envioFormularioSync(url,arr,'POST');                     
        }
    }
    var pagina="cargos.php";
    setTimeout(refreshWindow(pagina),1000);
  });

  $(document).renderme('co');
  $(document).renderme('ale');
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