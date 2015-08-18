$(document).ready(function() {
    $(document).renderme('co');
    //$("#selcopropiedades").prop('disabled', true);
    $('.selector-copropiedad').html("<span class=titulo-cop><strong>"+ sessionStorage.getItem('ncp') +"</strong></span>");
    var arr={token:sessionStorage.getItem('token'),body:{id_copropiedad : sessionStorage.getItem('cp')}}
    var datos = traerDatosSync("admin/copropiedad/usuario/copropiedad/proveedores",arr);

    contactos = obtenerContactos(datos);
    $("#proveedoresselect").append(contactos);
    $("#proveedoresselect").val('').trigger("chosen:updated");

    popularBasicos();

    var arr={token:sessionStorage.getItem('token'),body:{id_copropiedad : sessionStorage.getItem('cp')}}
    var datos = traerDatosSync("contabilidad/obtener/consecutivos",arr);
    $("#consecutivo").html(obtenerConsecutivos("rc",datos));

    $("#proveedoresselect").change(function(){
      var option = $("#proveedoresselect option:selected");
      $("#cpnomf").html(option.attr("cpnombre"));
      $("#cptel").html(option.attr("cptelefono"));
      $("#cpcel").html(option.attr("cpcelular"));
      $("#cpema").html(option.attr("cpemail"));
      $("#idtercero").val(option.attr("cpidcrm"));
      $("#nomcon").html(option.attr("nit"));
      $("#idnit").val(option.attr("nit"));

    });
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
      var iCnt = 0;
      var container = $(document.createElement('div')).css({
          padding: '0', margin: '0 0 20px 0', width: '100%', border: 'none'
      });

      $('#btAdd').click(function(){
          if (iCnt <= 9) {
              iCnt = iCnt + 1;
              // ADD TEXTBOX.
              $(container).append('<div id=fila' + iCnt + ' class="opciones" style="padding: 20px 1.5% 0; border:1px solid #eee; margin-bottom:0;"><table><tr><td width="20%"><select id=dc_fila' + iCnt + ' name=dc_fila' + iCnt + ' style="width:100%;" tabindex="4" class="chosen-select-no-single" cpid="' + iCnt + '" required><option value="">Movimiento</option><option value="debito">Debito</option><option value="credito">Crédito</option></select></td><td width="20%"><select data-placeholder="Cuentas contables" class="chosen-select" id=categoria_fila' + iCnt + ' style="width:100%;" tabindex="4" required><option value=""></option></select></td><td  width="20%"><input type="number" class="input" style="text-align: right;" id=debitos' + iCnt + ' cpid="' + iCnt + '" disabled required/></td><td width="20%"><input type="number" class="input" style="text-align: right;" id=creditos' + iCnt + ' cpid="' + iCnt + '" disabled required/></td></tr></table></div>');
              $(document).renderme('co');
              $('#agregar-campos').after(container); 
              $('#btAddC').attr('class', 'btn icono agregar ttip positivo');

              var option = $("#proveedoresselect option:selected");
              $("#cpnomc" + iCnt).html(option.attr("cpnombre"));

              $('#categoria_fila' + iCnt).append(FormatearCategoriasContables());
              
              $('#debitos' + iCnt).change(function(){
                var this_id = $(this).attr('cpid');
                $("#totaldebito").html(totalizarDebitos(iCnt));
                $('#creditos' + this_id).prop('disabled', true);
                $('#creditos' + this_id).prop('required', false);
                $('#creditos' + this_id).val(0);
                var totaldebito2 = $("#totaldebito").html();
                var totalcredito2 = $("#totalcredito").html();
                $("#diferencia").html(Number(totaldebito2) - Number(totalcredito2));
              });

              $('#creditos' + iCnt).change(function(){
                var this_id = $(this).attr('cpid');
                $("#totalcredito").html(totalizarCreditos(iCnt));
                $('#debitos' + this_id).prop('disabled', true);
                $('#debitos' + this_id).prop('required', false);
                $('#debitos' + this_id).val(0);
                var totaldebito2 = $("#totaldebito").html();
                var totalcredito2 = $("#totalcredito").html();
                $("#diferencia").html(Number(totaldebito2) - Number(totalcredito2));
              });

              $('#dc_fila' + iCnt).change(function(){
                var option = $("option:selected",this);
                if(option.val() == "credito")
                {
                  var actualid = $(this).attr('cpid');
                  $('#debitos' + actualid).prop('disabled', true);
                  $('#debitos' + actualid).val(0);
                  $('#creditos' + actualid).prop('disabled', false);
                  $('#creditos' + actualid).prop('required', true);
                  $('#creditos' + actualid).val(0);
                  $("#totalcredito").html(totalizarCreditos(iCnt));
                  $("#totaldebito").html(totalizarDebitos(iCnt));
                  var totaldebito2 = $("#totaldebito").html();
                  var totalcredito2 = $("#totalcredito").html();
                  $("#diferencia").html(Number(totaldebito2) - Number(totalcredito2));
                }
                else
                {
                  var actualid = $(this).attr('cpid');
                  $('#debitos' + actualid).prop('disabled', false);
                  $('#debitos' + actualid).val(0);
                  $('#creditos' + actualid).prop('disabled', true);
                  $('#debitos' + actualid).prop('required', true);
                  $('#creditos' + actualid).val(0);
                  $("#totalcredito").html(totalizarCreditos(iCnt));
                  $("#totaldebito").html(totalizarDebitos(iCnt));
                  var totaldebito2 = $("#totaldebito").html();
                  var totalcredito2 = $("#totalcredito").html();
                  $("#diferencia").html(Number(totaldebito2) - Number(totalcredito2));
                }
              });
          }
          else { 
              $(container).append('<label class="limite-fila" teid="co:html:58"></label>'); 
              $(document).renderme('co'); 
              $('#btAdd').attr('class', 'btn icono agregar disabled'); 
              $('#btAdd').attr('disabled', 'disabled');
          }
      });

      $('#btAdd').click(function() {
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

      $('#btRemove').click(function() {
          if (iCnt != 0) 
          { 
            var this_credito = $('#creditos' + iCnt).val();
            var totalactualc = $("#totalcredito").html();
            $('#btAddC').attr('class', 'btn icono agregar ttip positivo');
            
            var this_debito = $('#debitos' + iCnt).val();
            var totalactuald = $("#totaldebito").html();

            $('#fila' + iCnt).remove(); 
            iCnt = iCnt - 1; 
            $('.limite-fila').remove();

            $("#totalcredito").html(totalizarCreditos(iCnt));
            $("#totaldebito").html(totalizarDebitos(iCnt));
            
            var totaldebito2 = $("#totaldebito").html();
            var totalcredito2 = $("#totalcredito").html();
            $("#diferencia").html(Number(totaldebito2) - Number(totalcredito2));

            $('#dc_fila' + iCnt).change(function(){
                var option = $("option:selected",this);
                if(option.val() == "credito")
                {
                  var actualid = $(this).attr('cpid');
                  $('#debitos' + actualid).prop('disabled', true);
                  $('#debitos' + actualid).val(0);
                  $('#creditos' + actualid).prop('disabled', false);
                  $('#creditos' + actualid).prop('required', true);
                  $('#creditos' + actualid).val(0);
                  $("#totalcredito").html(totalizarCreditos(iCnt));
                  $("#totaldebito").html(totalizarDebitos(iCnt));
                  var totaldebito2 = $("#totaldebito").html();
                  var totalcredito2 = $("#totalcredito").html();
                  $("#diferencia").html(Number(totaldebito2) - Number(totalcredito2));
                }
                else
                {
                  var actualid = $(this).attr('cpid');
                  $('#debitos' + actualid).prop('disabled', false);
                  $('#debitos' + actualid).val(0);
                  $('#creditos' + actualid).prop('disabled', true);
                  $('#debitos' + actualid).prop('required', true);
                  $('#creditos' + actualid).val(0);
                  $("#totalcredito").html(totalizarCreditos(iCnt));
                  $("#totaldebito").html(totalizarDebitos(iCnt));
                  var totaldebito2 = $("#totaldebito").html();
                  var totalcredito2 = $("#totalcredito").html();
                  $("#diferencia").html(Number(totaldebito2) - Number(totalcredito2));
                }
              });
          }
          if (iCnt == 0) 
          { 
            $(container).empty(); 
            $(container).remove();
            $('#btAddC').attr('class', 'btn icono agregar ttip positivo');
          }
          if (iCnt <= 10) 
          {
            $('#btAdd').removeAttr('disabled');
            $('#btAdd').attr('class', 'btn icono agregar ttip positivo');
          }
      });

      $('#btnguardardocumento').click(function(){
        var option = $("option:selected",$('#proveedoresselect'));
        var cta = $("option:selected",$('#categoria_fila1'));
        var mov = $("option:selected",$('#dc_fila1_chosen'));
        //console.warn("TEST:", option.val(), cta.val());
        var result = false;
        if(option.val())
        {
          if(cta.val() || cta.val() == undefined)
          {
            if(mov.val() || mov.val() == undefined)
            {
              if(iCnt > 0)
              {
                result = crearDocumento(iCnt, $("#consecutivo").html(), $("#cpnomf").html(), $("#cpema").html(), $("#conceptodoc").val(), "", $("#docext").val(), "RC", $("#idtercero").val(),$("#idnit").val());
                if(result)
                {
                  //$('#alertasop').html('<div class="alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>OK!</strong> Se ha creado el documento con exito</div>');
                  setTimeout(function(){location.reload();},1000);
                }
                else
                {
                  $('#alertasop').html('<div class="alert alert-dismissable alert-error" teid="ale:html:21"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:1"></strong></div>');
                   $(document).renderme('co');
                }
              }
              else
              {  
                $("#alertas").append('<div class="alert alert-dismissable alert-error" teid="ale:html:25"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:1"></strong></div>');
                 $(document).renderme('co');
              }
            }
            else
            {
              $("#alertas").append('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:1"></strong> Debe seleccionar un movimiento contable para crear el documento.</div>');
               $(document).renderme('co');
            }
          }
          else
          {
            $("#alertas").append('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:1"></strong> Debe seleccionar una cuenta contable para crear el documento.</div>');
             $(document).renderme('co');
          }
        }
        else
        {
          $("#alertas").append('<div class="alert alert-dismissable alert-error" teid="ale:html:26"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:1"></strong></div>');
           $(document).renderme('co');
        }
      });

      $('#btncancelardocumento').click(function(){
        window.location = '../index.html';
      });

      $('#btnanulardocumento').click(function(){
        anularDocumento();
      });

      $('#btnimprimirdocumento').click(function(){
        var option = $("option:selected",$('#proveedoresselect'));
        var cta = $("option:selected",$('#categoria_fila1'));
        var mov = $("option:selected",$('#dc_fila1_chosen'));
        //console.warn("TEST:", option.val(), cta.val());
        var result = false;
        if(option.val())
        {
          if(cta.val() || cta.val() == undefined)
          {
            if(mov.val() || mov.val() == undefined)
            {
              if(iCnt > 0)
              {
                result = crearDocumento(iCnt, $("#consecutivo").html(), $("#cpnomf").html(), $("#cpema").html(), $("#conceptodoc").val(), "", $("#docext").val(), "RC", $("#idtercero").val());

                if(result)
                {
                  //$('#alertasop').html('<div class="alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>OK!</strong> Se ha creado el documento con exito</div>');
                  $("#imprimible").append('</br><div style="width:200px; margin:0px auto;"><h2 teid="co:html:125"></h2></div> <form> <table id="form-factura"> <tr> <td width="25%"><label teid="co:html:108"></label> <h3>' + $("#datepicker1").val() + '</h3></td> <td colspan="2"><label teid="co:html:109"></label> <h4>' + $("#comprador").html() + '</h4></td> <td width="25%"><label teid="co:html:110"></label> <h3 style="color:red;">' + $("#consecutivo").html() + '</h3></td> </tr> <tr> <td> <label teid="co:html:112"></label> <h4>' + $("#cpnomf").html() + '</h4> </td> <td><label teid="co:html:113"></label> <h4>' + $("#cptel").html() + '</h4></td> <td><label teid="co:html:122"></label> <h4>' + $("#cpcel").html() + '</h4></td> <td><label teid="co:html:114"></label> <h4>' + $("#cpema").html() + '</h4></td> </tr> <tr> <td colspan="2"> <label teid="co:html:115"></label> <h4>' + $("#conceptodoc").val() + '</h4> </td> <td colspan="2"> <label teid="co:html:116"></label> <h4>' + $("#docext").val() + '</h4> </td> </tr> </table>');

                  var res = '<table id="agregar-campos"> <tr> <td width="20%" class="titulo-campos" teid="co:html:48"></td> <td width="20%" class="titulo-campos" teid="co:html:49"></td> <td width="20%" class="titulo-campos" teid="co:html:129"></td> <td width="20%" class="titulo-campos" teid="co:html:50"></td> <td width="20%" class="titulo-campos" teid="co:html:51"></td> </tr>';
                  $(document).renderme('co');
                            
                  for (var i = 1; i <= iCnt; i++) 
                  {
                    var optioncd = $("option:selected",$("#dc_fila" + i));
                    var optioncta = $("option:selected",$("#categoria_fila" + i));
                    res = res + '<tr><td width="20%">' + optioncd.text() + '</td><td width="20%">' + optioncta.text() + '</td><td width="20%">' + $("#cpnomf").html() + '</td><td width="20%">' + $("#debitos" + i).val() + '</td><td width="20%">' + $("#creditos" + i).val() + '</td></tr>';
                  }

                  res = res + '</table>';            
                  $("#imprimible").append(res);
                  $("#imprimible").append('</br><div style="float:right; margin-right:70px;"><table><tr><td colspan="2"></td><td style="text-align: right;" teid="co:html:52"></td><td><h4 style="text-align: right;">'+obtenerTerminoLenguage('co','123') + $("#totaldebito").html() + '</h4></td><td><h4 style="text-align: right;">'+obtenerTerminoLenguage('co','124') + $("#totalcredito").html() + '</h4></td></tr><tr><td colspan="3"></td><td style="text-align: right;" teid="co:html:53"></td><td colspan="2"><h3 style="text-align: right;">' + $("#diferencia").html() + '</h3></td></tr></table></div></form>'); 
                  printDiv("imprimible");
                  $(document).renderme('co'); 
                  $("#imprimible").html('');
                  setTimeout(function(){location.reload();},1000);
                }
                else
                {
                  $('#alertasop').html('<div class="alert alert-dismissable alert-error" teid="ale:html:21"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:1"></strong></div>');
                   $(document).renderme('co');
                }
              }
              else
              {  
                $("#alertas").append('<div class="alert alert-dismissable alert-error" teid="ale:html:25"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:1"></strong></div>');
                 $(document).renderme('co');
              }
            }
            else
            {
              $("#alertas").append('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:1"></strong> Debe seleccionar un movimiento contable para crear el documento.</div>');
               $(document).renderme('co');
            }
          }
          else
          {
            $("#alertas").append('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:1"></strong> Debe seleccionar una cuenta contable para crear el documento.</div>');
             $(document).renderme('co');
          }
        }
        else
        {
          $("#alertas").append('<div class="alert alert-dismissable alert-error" teid="ale:html:26"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:1"></strong></div>');
           $(document).renderme('co');
        }
      });

  var today = new Date().toISOString();
  today = today.split('T')[0];
  //console.warn(today);
  $("#datepicker1").val(today);
  $(document).renderme('co');
  });