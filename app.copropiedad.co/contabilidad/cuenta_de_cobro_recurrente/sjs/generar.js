$(document).ready(function(){

  $(document).renderme('co');
  $('.selector-copropiedad').html("<span class=titulo-cop><strong>"+ sessionStorage.getItem('ncp') +"</strong></span>");
  //$("#selcopropiedades").prop('disabled', true);
  var arr2 = { token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp')}};
  var datos2 = traerDatosSync("contabilidad/obtener/cargos", arr2);
  //popularCargos(datos2);
  //console.warn(datos2);

  $.each(datos2,function(x,y){
    if(y['Activo_Pasivo'] == "editar esta cuenta" || y['cuenta_ingreso'] == "editar esta cuenta" || y['Activo_Pasivo'] == null || y['cuenta_ingreso'] == null)
    {
      $("#alertas").append('<div class="alert alert-dismissable alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Advertencia: </strong><span teid="co:html:274">&nbsp;</span>' + y['cargo'] + '<span teid="co:html:275"></span></div>');
    }
  });

  var arr3 = { token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp')}};
  var datos3 = traerDatosSync("cartera/obtener/inmuebles", arr3);
  sessionStorage.setItem('facturables',JSON.stringify(datos3));

  $('#iccp').append(FormatearCategoriasContables());
  $('#icci').append(FormatearCategoriasContables());
  $('#anticipos_cuenta').append(FormatearCategoriasContables());
  $('#anticipos_cuentasxcobrar').append(FormatearCategoriasContables());
  $('#anticipos_descuentos').append(FormatearCategoriasContables());

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

  $("#interes").on("input",function(){
    if(Number($(this).val()) > 100)
      $("#porcint").html("$");
    else
      $("#porcint").html("%");
  });

  $("#interes").click(function(){
    $(this).val('');
  });

  $("#descuento_admin").on("input",function(){
    if(Number($(this).val()) > 100)
      $("#porcadmin").html("$");
    else
      $("#porcadmin").html("%");
  });

  $("#descuento_admin").click(function(){
    $(this).val('');
  });

  $("#recargo").on("input",function(){
    if(Number($(this).val()) > 100)
      $("#porcrec").html("$");
    else
      $("#porcrec").html("%");
  });

  $("#recargo").click(function(){
    $(this).val('');
  });

  $("#nuevoGenerador").submit(function(event){
    event.preventDefault();
    var arr = 
    {
        token:sessionStorage.getItem('token'),
        body : 
      {
           id_copropiedad : sessionStorage.getItem('cp'),
           id_crm_persona : sessionStorage.getItem('id_crm'),
           year : $('#datepicker1').val().split("-")[0],
           month : $('#datepicker1').val().split("-")[1],
           corte : $('#datepicker1').val(),
           interes_cuenta : $('#iccp').val(),
           interes_contra : $('#icci').val(),
           interes: $('#interes').val(),
           interes_redondeo :$('#redondeo_interes').val(),
           descuento_admin : $('#descuento_admin').val(),
           descuento_admin_dia : $('#descuento_admin_dia').val(),
           descuento_redondeo : $('#descuento_redondeo').val(),
           recargo : $('#recargo').val(),
           recargo_dia : $('#recargo_dia').val(),
           recargo_redondeo : $('#recargo_redondeo').val(),
           anticipos_cuenta : $('#anticipos_cuenta').val(),
           anticipos_descuentos : $('#anticipos_descuentos').val(),
           sancion : $('#sancion').val(),
           notas : $('#notas').val()
      }
    }

    console.warn(arr);
    sessionStorage.setItem('ccrecurrentes',JSON.stringify(arr));
    location.href = "verificar.php";
  });

  $("#sancion").change(function(){
    if($(this).val() == "descuento")
    {
      $("#recargo_dia").attr("disabled",true);
      $("#recargo").attr("disabled",true);
      $("#recargo_redondeo").attr("disabled",true);
      $("#descuento_admin_dia").attr('disabled', false);
      $("#descuento_admin").attr("disabled",false);
      $("#descuento_redondeo").attr("disabled",false);
      $("#descuento_admin").attr("required",true);
      $("#recargo").attr("required",false);
    }

    if($(this).val() == "recargo")
    {
      $("#recargo_dia").attr("disabled",false);
      $("#recargo").attr("disabled",false);
      $("#recargo_redondeo").attr("disabled",false);
      $("#descuento_admin_dia").attr('disabled', true);
      $("#descuento_admin").attr("disabled",true);
      $("#descuento_redondeo").attr("disabled",true);
      $("#recargo").attr("required",true);
      $("#descuento_admin").attr("required",false);
    }
  });

  $("#sancion").change();

  $(document).renderme('co');
});