$(document).ready(function(){
  var arr = {token:sessionStorage.getItem('token'),body:{_id:sessionStorage.getItem('cp')}};
  var datos = traerDatosSync("admin/copropiedad/copropiedad/getlistFilter", arr)[0];
  //console.warn(datos);
  //console.warn(datos["pagosonline"]);
  if((sessionStorage.getItem('userflow') == "21") || (sessionStorage.getItem('userflow') == "23") || (sessionStorage.getItem('userflow') == "2") || (sessionStorage.getItem('userflow') == "213"))
  {
    $(document).renderme('pa');
    $(".aplicaciones").show();
    $("#cuerpoaplicacion").hide();
    $("#alertas").html('<div class="alert alert-dismissable alert-info"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4 teid="ale:html:33"></h4><p teid="ale:html:34"></p></div> ');

    $(document).renderme('pa');
  }
  else
  {
    //console.warn(datos["pagosonline"]);
    if(Boolean(datos["pagosonline"]) == true)
    {
       $(".niveldos").hide();
       $(document).renderme('pa');

       // Proceso para traer los datos de los inmuebles creados
       var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
       var arr = {token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp')}};
       var datos = traerDatosSync("payu/pagosonline/getlist/", arr);

       // Parámetros de las tablas de inmuebles
       $('#pagostable').DataTable( {
         responsive: {
           details: {
                     type: 'column'
                 }
         },
         columnDefs: [ {
                 className: 'control',
                 orderable: false,
                 targets:   0
             } ],
             order: [ 1, 'asc' ],
         "dom": '<"toolbar">lfCrtip',
         "colVis": {
           "buttonText": obtenerTerminoLenguage('ta','20'),
             exclude: [ 0, 1 ]
           },
         "language": {
           "sProcessing":     obtenerTerminoLenguage('ta','2'),
           "sLengthMenu":     obtenerTerminoLenguage('ta','3'),
           "sZeroRecords":    obtenerTerminoLenguage('ta','4'),
           "sEmptyTable":     obtenerTerminoLenguage('ta','5'),
           "sInfo":           obtenerTerminoLenguage('ta','6'),
           "sInfoEmpty":      obtenerTerminoLenguage('ta','7'),
           "sInfoFiltered":   obtenerTerminoLenguage('ta','8'),
           "sInfoPostFix":    obtenerTerminoLenguage('ta','9'),
           "sSearch":         obtenerTerminoLenguage('ta','10'),
           "sUrl":            obtenerTerminoLenguage('ta','11'),
           "sInfoThousands":  obtenerTerminoLenguage('ta','12'),
           "sLoadingRecords": obtenerTerminoLenguage('ta','13'),
           "oPaginate": {
             "sFirst":    obtenerTerminoLenguage('ta','14'),
             "sLast":     obtenerTerminoLenguage('ta','15'),
             "sNext":     obtenerTerminoLenguage('ta','16'),
             "sPrevious": obtenerTerminoLenguage('ta','17')
           },
           "oAria": {
             "sSortAscending":  obtenerTerminoLenguage('ta','18'),
             "sSortDescending": obtenerTerminoLenguage('ta','19')
           }
         }
       });

       popularTabla(datos);

       $(document).renderme('pa');
    }
    else
    {
      $(document).renderme('pa');
      $(".botones-form").hide();
      $(".aplicaciones").show();
      $("#cuerpoaplicacion").hide();
      $("#alertas").html('<div class="alert alert-dismissable alert-info" ><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:28"></strong><h4 teid="ale:html:36"></h4></div> ');
      $(document).renderme('pa');
    }
  }
});