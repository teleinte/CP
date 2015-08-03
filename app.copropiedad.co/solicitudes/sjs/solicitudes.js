$(document).ready(function(){
  $(document).renderme('sl');

  
  if(sessionStorage.getItem('message') != null || sessionStorage.getItem('message') != undefined){
    $("#alertas").html('<div class="alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + sessionStorage.getItem('message') + '</div>');
    sessionStorage.removeitem('message');
  }

  var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})      
  var arr = { token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp'),item_type:"solicitudes"}};
  var datos = traerDatosSync("frontdesk/getlist/abierta", arr, sessionStorage.getItem('cp'));
  
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

  popularTabla(datos);

  $("div.toolbar").html('<a href="historico.php" class="btn ttip positivo" id ="open-crearsolicitud" style="margin-right:5px;" teid="sl:html:11, sl:title:12"></a>');

  $("#solicitud_form").submit(function(event){
    event.preventDefault();
    $('input[type=submit]').attr('disabled',true);
    var arr = {
     token:sessionStorage.getItem('token'),
     body:{
         id_copropiedad:sessionStorage.getItem('cp'),
         usuario:sessionStorage.getItem('id_crm'),
         usuario_correo:sessionStorage.getItem('email').split('cp-')[1],
         fecha_creacion:fecha(),
         solicitud:$('#solicitud').val(),
         estado:"abierta",
         notas:$('#notas').val(),
         fecha_cierre:"",
         usuario_nombre:sessionStorage.getItem('nombreCompleto'),
         item_type:"solicitudes"
        }
    };
    var url = "frontdesk/list";
    var response = envioFormularioSync(url,arr,'POST');
    if(response)
    {
      sessionStorage.setItem('message','Su solicitud ha sido creada satisfactoriamente.');
      setTimeout(refreshWindow('index.php'),1000);
    }
    else
    {
      //$("#crearsolicitud").dialog("close");
      $("#alertas").html('<div class="alert alert-dismissable alert-error" teid="ale:html:4"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:1"></strong></div>');
      $(document).renderme('sl');
    }
  });

  $(".completar").click(function(event){
    event.preventDefault();
    sessionStorage.setItem('mongoid', $(this).attr('mongoid'));
    window.location="respuesta.php";
  });

  
  
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