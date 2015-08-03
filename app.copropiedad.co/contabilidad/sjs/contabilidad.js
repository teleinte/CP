$(document).ready(function(){
 $("#selcopropiedades").prop('disabled', true);
 $(document).renderme('co');
 $("#alertas").html('<div class="alert alert-dismissable alert-info"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4 teid="ale:html:93"></h4><br/> <ul><li  teid="ale:html:94"></li> <br/><li  teid="ale:html:95"></li><br/><li  teid="ale:html:96"></li></ul> </div>'); 
 $(document).renderme('ale');
 $('.selector-copropiedad').html("<span class=titulo-cop><strong>"+ sessionStorage.getItem('ncp') +"</strong></span>");
 var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
 
 var arr = { token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp'),tipo_documento:"puc"}}; 
 var datos = traerDatosSync("contabilidad/obtener/puc/", arr);
 buscarPuc(datos);

 var arr2 = { token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp'),tipo_documento:"consecutivos"}};
 var datosCifras = traerDatosSync("contabilidad/obtener/consecutivos/", arr2); 
 buscarCifras(datosCifras);

 var arr3 = { token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp'),tipo_documento:"cargos"}};
 var datosCargos = traerDatosSync("contabilidad/obtener/cargos", arr3); 
 buscarCargos(datosCargos);

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