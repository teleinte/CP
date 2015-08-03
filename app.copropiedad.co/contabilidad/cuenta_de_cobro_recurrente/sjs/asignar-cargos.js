$(document).ready(function(){

  $(document).renderme('co');
  $('.selector-copropiedad').html("<span class=titulo-cop><strong>"+ sessionStorage.getItem('ncp') +"</strong></span>");
  //$("#selcopropiedades").prop('disabled', true);
  if(sessionStorage.getItem('imporresult') != null || sessionStorage.getItem('imporresult') != undefined){
    $("#alertas").html('<div class="alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong > ' + sessionStorage.getItem('imporresult') + '</strong></div>');
    $("#bodyapp").append('<div class="botones-form"><a class="btn ttip" href="generar.php">Generar cuentas de cobro</a></div>');
    sessionStorage.removeItem('imporresult');    
  }

// Proceso para traer los datos de los inmuebles creados
  var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
  var arr = {token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp')}};
  var datos = traerDatosSync("unidad/unidad/copropiedad/", arr);
  popularSelect(datos);

  var arr2 = { token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp')}};
  var datos2 = traerDatosSync("contabilidad/obtener/cargos", arr2);
  popularCargos(datos2);
  //console.warn(datos2);

  var arr3 = { token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp')}};
  var datos3 = traerDatosSync("cartera/obtener/inmuebles", arr3);
  sessionStorage.setItem('facturables',JSON.stringify(datos3));
  //console.warn(datos3);

  $.each(datos2,function(x,y){
    if(y['Activo_Pasivo'] == "editar esta cuenta" || y['cuenta_ingreso'] == "editar esta cuenta" || y['Activo_Pasivo'] == null || y['cuenta_ingreso'] == null)
    {
      $("#alertas").append('<div class="alert alert-dismissable alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:74"> </strong><span teid="co:html:274">&nbsp;</span>' + y['cargo'] + '<span teid="co:html:275"></span></div>');
    }
  });

  $("#alertas").append('<div class="alert alert-dismissable alert-info" style="width:520px; height:180px; overflow:auto;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h2 style="text-align:center"><strong><p teid="ale:html:128"></p></strong></h2><p teid="ale:html:127"></p><p teid="ale:html:88"></p><p teid="ale:html:62"></p><p teid="ale:html:63"></p><p teid="ale:html:64"></p><p teid="ale:html:65"></p><p teid="ale:html:66"></p><p teid="ale:html:67"></p><p teid="ale:html:122"></p><p teid="ale:html:123"></p><p teid="ale:html:124"></p><p teid="ale:html:125"></p><p teid="ale:html:126"></p></div>');

  $("#inmueble").change(function(){
    var elem = $(this).val().split('|')[1];
    var fact = JSON.parse(sessionStorage.getItem('facturables'));
    var carg = sessionStorage.getItem('cargos').split(',');
    var thiselem = "";

    if(fact != null)
    $.each(fact,function(k,v){
      if(elem == v['id_inmueble'])
      {
        thiselem = fact[k];
      }
    });

    if(thiselem != "")
    {
      var cargos = thiselem['cargos'].split(',');
      $.each(cargos,function(x,y){
        $("#" + y.split('|')[0]).val(y.split('|')[4]);
      });
      $("#accion").val(obtenerTerminoLenguage('co','150'));
      $("#accion").attr("method","PUT");
      $("#accion").attr("mongoid",thiselem["_id"]["$id"]);
    }
    else
    {
      if(fact != null)
      $.each(carg,function(a,b){
        $("#" + b.split('|')[0]).val(0);
      });
      $("#accion").val(obtenerTerminoLenguage('co','80'));
      $("#accion").attr("method","POST");
      $("#accion").attr("mongoid","none");
    }
  });

  $("#inmueble").change();

  $("#asignar-cargo").submit(function(event)
  {
    event.preventDefault();
    var inmueble_partido=$("#inmueble").val().split("|");
    var nombre_inmueble=inmueble_partido[0];
    var id_inmueble=inmueble_partido[1];
    var id_crm_persona=sessionStorage.getItem('id_crm');
    var fecha_creacion=fecha();
    // /usuario/copropiedad/principal
    var arrinmueble=  {token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp'), unidad:id_inmueble}};
    var datosInmueble = traerDatosSync("admin/copropiedad/usuario/copropiedad/principal", arrinmueble);
    var responsable = ""; 
    $.each(datosInmueble, function(x , y) 
    {
        responsable = y['nombre'];
    });
    var cargador="";
    var cargostotales=sessionStorage.getItem('cargos');
    var cargostotales=cargostotales.split(",");
    //alert(cargostotales+cargostotales.length);
    for (var i = 0; i < cargostotales.length; i++)
    {
      //alert($("#"+cargostotales[i]).val())
      cargador+=sessionStorage.getItem(cargostotales[i])+"|"+$("#"+cargostotales[i]).val()+","
    };
    var cargos =cargador.substring(0, cargador.length-1);

    if($("#accion").attr('method') == "POST")
    {
      var arr =  
      {
        token:sessionStorage.getItem('token'),
        body:
        {
          id_copropiedad:sessionStorage.getItem('cp'),
          responsable: responsable,
          nombre_inmueble:nombre_inmueble,
          id_crm_persona:id_crm_persona,
          fecha_creacion:fecha_creacion,
          id_inmueble:id_inmueble,
          cargos:cargos
        }
      };
    }
    else
    {
      var arr =  
      {
        token:sessionStorage.getItem('token'),
        body:
        {
          id_copropiedad:sessionStorage.getItem('cp'),
          responsable: responsable,
          nombre_inmueble:nombre_inmueble,
          id_crm_persona:id_crm_persona,
          fecha_creacion:fecha_creacion,
          id_inmueble:id_inmueble,
          cargos:cargos,
          id:$("#accion").attr('mongoid')
        }
      };
    }
    
    var result = envioFormularioSync("cartera/inmueble/cargos",arr,$("#accion").attr('method'));
    
    if(result)
    {
      //$("#alertas").html('<div class="alert alert-dismissable alert-success">Cargos asignados con exito</div>');
      location.reload();
    }
    else
    {
      $("#alertas").html('<div class="alert alert-dismissable alert-error" teid="ale:html:4"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:1"></strong></div>');
       $(document).renderme('co');
    }
  });

  $("#descargar").click(function(){
    console.warn(datos, datos3, datos2);
    var out = generarPlantilla(datos, datos3, datos2);
    var arr = {content: out, idcp: sessionStorage.getItem('cp')};
    $.ajax(
    {
        url: 'archivo.php',
        type: 'POST',
        data: arr,
        async: true,
        success: function(msg)
        {

          window.location = msg;
        }
    });
  });

  $("#descargarmac").click(function(){
    console.warn(datos, datos3, datos2);
    var out = generarPlantillaMac(datos, datos3, datos2);
    var arr = {content: out, idcp: sessionStorage.getItem('cp')};
    $.ajax(
    {
        url: 'archivo.php',
        type: 'POST',
        data: arr,
        async: true,
        success: function(msg)
        {

          window.location = msg;
        }
    });
  });

  $("#cargar").change(function() {
      //$("#alertas").html('<div class="alert alert-dismissable alert-info" > <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong teid="ale:html:28"></strong> <span teid="ale:html:29"></span> <br/> <span teid="ale:html:30"></span></div>'); 
      //$("#alertas").append('<div class="alert alert-dismissable alert-info"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><p teid="ale:html:88"></p><p teid="ale:html:62"></p><p teid="ale:html:63"></p><p teid="ale:html:64"></p><p teid="ale:html:65"></p><p teid="ale:html:66"></p><p teid="ale:html:67"></p></div>');
       $(document).renderme('co');
      uploadFileCargos(this.files[0], datos2);
  });

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