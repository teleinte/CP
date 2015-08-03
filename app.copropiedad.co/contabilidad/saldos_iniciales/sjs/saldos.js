$(document).ready(function() 
{
  $(document).renderme('co');
  $('.selector-copropiedad').html("<span class=titulo-cop><strong>"+ sessionStorage.getItem('ncp') +"</strong></span>");

  var iCnt = 0;
  var cuenta = 0;
  
  var container = $(document.createElement('div')).css(
  {
      padding: '0', margin: '0 0 20px 0', width: '100%', border: 'none'
  });

  popularBasicos();
  
  $('#btAdd').click(function() 
  {
    if (iCnt <= 999) 
    {
      iCnt = iCnt + 1;
      $(container).append('<div id="fila' + iCnt + '" class="opciones" style="padding: 20px 1.5% 0; border:1px solid #eee; margin-bottom:0;"><table><tr><td width="20%"><select id="dc_fila' + iCnt + '" name="dc_fila' + iCnt + '" style="width:100%;" tabindex="4" class="chosen-select-no-single" cpid="' + iCnt + '" required><option value="">Seleccione tipo de movimiento</option><option value="debito"> Débito</option><option value="credito">Crédito</option></select></td><td width="20%"><select data-placeholder="Buscar en cuentas contables" class="chosen-select" id="categoria_fila' + iCnt + '" name="categoria_fila' + iCnt + '" style="width:100%;" tabindex="4" required><option value=""></option></select></td><td  width="20%" class="center"><input type=text class="input debitos" id="debitos_fila' + iCnt + '" name="debitos_fila' + iCnt + '" cpid="' + iCnt + '" disabled style="text-align: right;"/></td></td><td width="20%"><input type=text class="input creditos" style="text-align: right;" id="creditos_fila' + iCnt + '" name="creditos_fila' + iCnt + '" cpid="' + iCnt + '" disabled/></td></td></tr></table></div>');
      $(document).renderme('co');
      $('#agregar_campos').after(container);   

      $('#categoria_fila' + iCnt).append(FormatearCategoriasContables());

      $('#debitos_fila' + iCnt).change(function()
      {
        var this_id= $(this).attr("cpid");
        $("#totaldebito").html(totalizarDebitos(iCnt));
        $('#creditos_fila' + this_id).prop('disabled', true);
        $('#creditos_fila' + this_id).val(0);
        var totaldebito2 = $("#totaldebito").html();
        var totalcredito2 = $("#totalcredito").html();
        $("#total").html(Number(totaldebito2) - Number(totalcredito2));               
      });

      $('#creditos_fila' + iCnt).change(function()
      {
        var this_id = $(this).attr('cpid');
        $("#totalcredito").html(totalizarCreditos(iCnt));
        $('#debitos_fila' + this_id).prop('disabled', true);
        $('#debitos_fila' + this_id).val(0);
        var totaldebito2 = $("#totaldebito").html();
        var totalcredito2 = $("#totalcredito").html();
        $("#total").html(Number(totaldebito2) - Number(totalcredito2));
      });

      $('#dc_fila' + iCnt).change(function()
      {
        var option = $("option:selected",this);
        if(option.val() == "credito")
        {
          var actualid = $(this).attr('cpid');
          $('#debitos_fila' + actualid).prop('disabled', true);
          $('#debitos_fila' + actualid).val(0);
          $('#creditos_fila' + actualid).prop('disabled', false);
          $('#creditos_fila' + actualid).val(0);
          $('#creditos_fila' + actualid).prop('required', true);
          $('#debitos_fila' + actualid).prop('required', false);
          $("#totalcredito").html(totalizarCreditos(iCnt));
          $("#totaldebito").html(totalizarDebitos(iCnt));
          var totaldebito2 = $("#totaldebito").html();
          var totalcredito2 = $("#totalcredito").html();
          $("#total").html(Number(totaldebito2) - Number(totalcredito2));
        }
        else
        {
          var actualid = $(this).attr('cpid');
          $('#debitos_fila' + actualid).prop('disabled', false);
          $('#debitos_fila' + actualid).val(0);
          $('#creditos_fila' + actualid).prop('disabled', true);
          $('#creditos_fila' + actualid).val(0);
          $('#debitos_fila' + actualid).prop('required', true);
          $('#creditos_fila' + actualid).prop('required', false);
          $("#totalcredito").html(totalizarCreditos(iCnt));
          $("#totaldebito").html(totalizarDebitos(iCnt));
          var totaldebito2 = $("#totaldebito").html();
          var totalcredito2 = $("#totalcredito").html();
          $("#total").html(Number(totaldebito2) - Number(totalcredito2));
        }
      });

      var config = 
      {
        '.chosen-select'           : {},
        '.chosen-select-deselect'  : {allow_single_deselect:true},
        '.chosen-select-creation'  : {create_option: true, skip_no_results: true},
        '.chosen-select-no-single' : {disable_search_threshold:10},
        '.chosen-select-no-results': {no_results_text:'No se encuentra'},
        '.chosen-select-width'     : {width:"95%"}
      }
      for (var selector in config) 
      {
        $(selector).chosen(config[selector]);
      }
    }
    else 
    { 
      $(container).append('<label class="limite-fila" teid="co:html:58"></label>');
      $(document).renderme('co'); 
      $('#btAdd').attr('class', 'btn icono agregar disabled ttip'); 
      $('#btAdd').attr('disabled', 'disabled');
    }
  });

  $('#btRemove').click(function() 
  {   
    if (iCnt != 0) 
    { 
      //iCnt = iCnt - 1; 
      var this_debito = $('#debitos_fila' + (iCnt)).val();
      var totalactual_debito = $("#totaldebito").html();
      

      var this_credito = $('#creditos_fila' + (iCnt)).val();
      var totalactual_credito = $("#totalcredito").html();

      $('#fila' + iCnt).remove();
      iCnt = iCnt - 1; 
      $('.limite-fila').remove();

      $("#totaldebito").html(totalizarDebitos(iCnt));
      $("#totalcredito").html(totalizarCreditos(iCnt));
      
      var totaldebito2 = $("#totaldebito").html();
      var totalcredito2 = $("#totalcredito").html();
      $("#total").html(Number(totaldebito2) - Number(totalcredito2));

      $('#dc_fila' + iCnt).change(function()
      {
        var option = $("option:selected",this);
        if(option.val() == "credito")
        {
          var actualid = $(this).attr('cpid');
          $('#debitos_fila' + actualid).prop('disabled', true);
          $('#debitos_fila' + actualid).val(0);
          $('#creditos_fila' + actualid).prop('disabled', false);
          $('#creditos_fila' + actualid).val(0);
          $("#totalcredito").html(totalizarCreditos(iCnt));
          $("#totaldebito").html(totalizarDebitos(iCnt));
          var totaldebito2 = $("#totaldebito").html();
          var totalcredito2 = $("#totalcredito").html();
          $("#total").html(Number(totaldebito2) - Number(totalcredito2));
        }
        else
        {
          var actualid = $(this).attr('cpid');
          $('#debitos_fila' + actualid).prop('disabled', false);
          $('#debitos_fila' + actualid).val(0);
          $('#creditos_fila' + actualid).prop('disabled', true);
          $('#creditos_fila' + actualid).val(0);
          $("#totalcredito").html(totalizarCreditos(iCnt));
          $("#totaldebito").html(totalizarDebitos(iCnt));
          var totaldebito2 = $("#totaldebito").html();
          var totalcredito2 = $("#totalcredito").html();
          $("#total").html(Number(totaldebito2) - Number(totalcredito2));
        }
      });
    
    }
    if (iCnt == 0) 
    { 
      $(container).empty(); 
      $(container).remove();
    }
	  if (iCnt <= 1000) 
    {
       $('#btAdd').removeAttr('disabled');
    }
  });
  
  $('#reload').click(function() 
  {
    window.location.reload();
  });




  $('#form_saldos').submit(function(event){
    event.preventDefault();
    $("#cpImportando").show();
    $("input[type=submit]").attr('disabled',true);
    $("#messi").attr('disabled',true);
    $("#anosi").attr('disabled',true);


      var arr = "";
      //console.warn(JSON.parse(sessionStorage.getItem('si')));
      //console.warn(sessionStorage.getItem('si'));

      if($("#importado").attr('esimportado') == "si")
      {
        //console.warn('importado');
        arr = {
                token:sessionStorage.getItem('token'),
                body:
                {
                  id_copropiedad: sessionStorage.getItem('cp'),
                  tipo_documento:'saldosiniciales',
                  mes:$("#messi").val(),
                  ano:$("#anosi").val(),
                  cuentas : JSON.parse(sessionStorage.getItem('si'))
                }
              };
      }
      else
      {
        //console.warn('manual');
        var arr_cuentas =[];
        for (j=1;j<99999;j++)
        {                    
          if (!$('#dc_fila'+j).val())
          {
            break;
          }

          if($('#debitos_fila'+j).val() != 0)
          {
            var montoo= $('#debitos_fila'+j).val();
          }
          else
          {
            var montoo= $('#creditos_fila'+j).val();
            montoo= -montoo;
          }
              
          arr_cuentas.push(
          {
            cuenta_puc:$('#categoria_fila'+j).val(),
            monto : montoo,
            tipo:"SI"
          });
        }
        arr = {
                token:sessionStorage.getItem('token'),
                body:
                {
                  id_copropiedad: sessionStorage.getItem('cp'),
                  tipo_documento:'saldosiniciales',
                  mes:$("#messi").val(),
                  ano:$("#anosi").val(),
                  cuentas : arr_cuentas
                }
              };
      }
      var url = "contabilidad/saldosiniciales";
      alert(JSON.stringify(arr));
      var response = envioFormularioSync(url,arr,'POST');
      if(response)
      {
        sessionStorage.removeItem('si');
        $("#cpImportando").show();
        window.location.reload()
      }
      else
      {
        $("#alertas").html('<div class="alert alert-error" teid="ale:html:23"></div>');
        $(document).renderme('co');
        $("input[type=submit]").attr('disabled',false);
      }
  });
  
  var saldos = obtenerSaldos();
  if(saldos)
  {
    $("#agregar_campos").show();
    popularSaldos(saldos);
  }

  $("#descargarwindows").click(function(){
      window.location = "plantilla/plantillasiwindows.csv";
  });

  $("#descargarmac").click(function(){
      window.location = "plantilla/plantillasimac.csv";
  });

  $("#cargar").change(function() {
      //console.warn(this.files[0])
      $("#agregar_campos").show();
      $("#guardar").show();
      $("#reload").show();
      uploadFileSI(this.files[0]);
  });

  $("#alertame").html('<div class="alert alert-dismissable alert-info" style="width:520px; height:180px; overflow:auto;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h2 style="text-align:center"><strong><p teid="ale:html:128"></p><p teid="ale:html:117"></p></strong></h2><p teid="ale:html:68"></p><p teid="ale:html:69"></p><p teid="ale:html:70"></p><p teid="ale:html:71"></p><p teid="ale:html:86"></p><p teid="ale:html:87"></p><p teid="ale:html:118"></p><p teid="ale:html:119"></p><p teid="ale:html:120"></p><p teid="ale:html:121"></p></div>');

  $(document).renderme('co');
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