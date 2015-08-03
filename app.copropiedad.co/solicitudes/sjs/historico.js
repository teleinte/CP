$(document).ready(function(){
  $(document).renderme('sl');

  
  var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})      
  var arr = { token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp'),item_type:"solicitudes"}};
  var datos = traerDatosSync("frontdesk/getlist/completada", arr, sessionStorage.getItem('cp'));
  
  $(document).renderme('sl');

  $('#solicitudes').DataTable({
    columnDefs: [{
            className: 'control',
            orderable: false,
            targets:   0
        }],
    responsive: {
      details: {
                type: 'column'
      }
    },
    order: [ 1, 'asc' ],
    "dom": '<"toolbar">lfCrtip',
    "colVis": {
      "buttonText": obtenerTerminoLenguage('ta','20'),
      exclude: [ 0, 1 ],
      exclude: [ 0, 5 ]
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

  popularTablaHistorico(datos);

  $("div.toolbar").html('<a href="index.php" class="btn ttip positivo" id ="open-crearsolicitud" style="margin-right:5px;" teid="sl:html:34, sl:title:35"></a>');

  
  
  $(document).renderme('sl');
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