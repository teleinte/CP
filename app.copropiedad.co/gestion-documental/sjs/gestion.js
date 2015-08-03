$(document).ready(function(e) {  
  $(document).renderme('gd');

  var arr = { token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp'),tipo:"todos"}};
  var datos = traerDatosSync("documentos/getlist",arr); 

  $('#documentos').DataTable( {
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

if(datos)
  popularTablaDocumentos(datos);

  $("div.toolbar").html('<a href="cargar-archivo.php" class="btn ttip positivo" teid="gd:html:23, gd:title:15" id ="open-crearsolicitud"></a> ');

  $("div.toolbar").append('&nbsp;&nbsp;<select id="filtro"><option value="" teid="gd:html:24"></option><option value="acta" teid="gd:html:18"></option><option value="documentos" teid="gd:html:25"></option><option value="facturas" teid="gd:html:20"></option><option value="cotizaciones" teid="gd:html:21"></option><option value="otros" teid="gd:html:22"></option><option value="informes" teid="gd:html:37"></option></select>');
  $(document).renderme('gd');

  $("#filtro").change(function(){
    var t = $("#documentos").DataTable();
    t.search($(this).val()).draw();
  });

  $(".btnborrar").click(function(event){
    $("#dialog_eliminar").dialog("open");
    $("#elmongoid").val($(this).attr('mongoid'));
  });

  $("#dialog_eliminar").dialog({
    resizable: false,
    autoOpen: false,
    width: 400,
    modal: true,
    title: obtenerTerminoLenguage('gd','28'),
    buttons:{
      "Cancelar" : function(){
        $(this).dialog("close");
      },
      "Aceptar" : function(){
        $(this).dialog("close");
        var arr = { token:sessionStorage.getItem('token'),body:{id:$("#elmongoid").val()}};
        var datos = envioFormularioSync("documentos/list/",arr,'PUT');
        if(datos) 
        {
          refreshWindow('index.php');
        }
        else
        {
          $('#alertas').html('<div class="alert alert-error" teid="ale:html:21"></div>');
           $(document).renderme('gd');
        }
      }
    }
  });

  $(document).renderme('gd');
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