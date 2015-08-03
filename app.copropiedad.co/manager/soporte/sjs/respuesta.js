$(document).ready(function(){
  $(document).renderme('sp');
  
  var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})      
  var arr = { token:sessionStorage.getItem('token'),body:{_id: sessionStorage.getItem('mongoid'), item_type:"casos-soporte"}};
  var datos = traerDatosSync("managercp/casos/getlist/", arr, 'params');
  $('#caso_cliente').removeAttr('maxlength');
  $('#notas_cliente').removeAttr('maxlength');
   $('#respuesta_caso').removeAttr('maxlength');
  //alert(JSON.stringify(datos));
  $(document).renderme('sp');

  $('#casos-soporte').DataTable({
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
      exclude: [ 0, 8 ]
    },
    "language": {
      "sProcessing":     obtenerTerminoLenguage('ta','2'),
      "spengthMenu":     obtenerTerminoLenguage('ta','3'),
      "sZeroRecords":    obtenerTerminoLenguage('ta','4'),
      "sEmptyTable":     obtenerTerminoLenguage('ta','5'),
      "sInfo":           obtenerTerminoLenguage('ta','6'),
      "sInfoEmpty":      obtenerTerminoLenguage('ta','7'),
      "sInfoFiltered":   obtenerTerminoLenguage('ta','8'),
      "sInfoPostFix":    obtenerTerminoLenguage('ta','9'),
      "sSearch":         obtenerTerminoLenguage('ta','10'),
      "sUrl":            obtenerTerminoLenguage('ta','11'),
      "sInfoThousands":  obtenerTerminoLenguage('ta','12'),
      "spoadingRecords": obtenerTerminoLenguage('ta','13'),
      "oPaginate": {
        "sFirst":    obtenerTerminoLenguage('ta','14'),
        "spast":     obtenerTerminoLenguage('ta','15'),
        "sNext":     obtenerTerminoLenguage('ta','16'),
        "sPrevious": obtenerTerminoLenguage('ta','17')
      },
      "oAria": {
        "sSortAscending":  obtenerTerminoLenguage('ta','18'),
        "sSortDescending": obtenerTerminoLenguage('ta','19')
      }
        }
  });
	
  popularRespuestaCaso(datos);

  $("#respuesta_caso_form").submit(function(event){
    event.preventDefault();
    $('input[type=submit]').attr('disabled',true);
    var arr = {
     token:sessionStorage.getItem('token'),
     body:{
         id: sessionStorage.getItem('mongoid'),
         id_copropiedad:$('#id_copropiedad_cliente').html(),
         usuario: $('#id_crm_cliente').val(),
         fecha_creacion:$('#fecha_creacion_caso').html(),
         caso:$('#caso_cliente').html(),
         estado:"Cerrado",
         notas:$('#notas_cliente').html(),
         fecha_cierre:"",
         usuario_nombre: $('#cliente_nombre').html(),
         usuario_email: $('#cliente_correo').html(),
         respuesta: $('#respuesta_caso').val(),
         usuario_soporte:sessionStorage.getItem('email').split('cp-')[1],
         item_type:"casos-soporte"
        }
    };
    var url = "managercp/casos/listar";
    //alert(JSON.stringify(arr));
    var response = envioFormularioMessageSync(url,arr,'PUT');
    if(response)
    {
        var cliente = $('#cliente_correo').html();
        var txt_caso = '<div style="border:2px solid #aaa; padding: 5px 5px 5px; background-color:#fff;-webkit-border-radius: 5px; -moz-border-radius: 5px;border-radius: 5px; "><pre style="font-family:Arial,Helvetica,sans-serif; white-space: pre-wrap; ">'+ $('#caso_cliente').html() +'</pre></div>';
        var txt_notas = '<div style="border:2px solid #aaa; padding: 5px 5px 5px; background-color:#fff;-webkit-border-radius: 5px; -moz-border-radius: 5px;border-radius: 5px; "><pre style="font-family:Arial,Helvetica,sans-serif; white-space: pre-wrap;">'+ $('#notas_cliente').html() +'</pre></div>';
        var txt_respuesta = '<div style="border:2px solid #aaa; padding: 5px 5px 5px; background-color:#fff;-webkit-border-radius: 5px; -moz-border-radius: 5px;border-radius: 5px; "><pre style="font-family:Arial,Helvetica,sans-serif; white-space: pre-wrap;">'+ $('#respuesta_caso').val() +'</pre></div>';
        var body = '<p> Sr(a) '+ $('#cliente_nombre').html() +', <br>A continuación la respuesta al caso de soporte enviado. <br><br><strong> ID: </strong>'+ $('#id_caso').html()+'<br><strong>Caso: </strong><br>'+ txt_caso +'<br><strong>Notas: </strong><br>'+ txt_notas +'<br><strong>Respuesta: </strong><br>'+txt_respuesta+' </p>Gracias por ayudarnos a mejorar.<br><br><strong> Equipo de soporte Copropiedad.co </strong>';
        var subject = "Respuesta soporte Copropiedad.co - ID: " + $('#id_caso').html();
        var email = "soporte.copropiedad@teleinte.com,"+ cliente;
        
        enviocorreosoporte(body, subject, email);
        setTimeout(refreshWindow('index.php'),1000);
    }
    else
    {
//      $("#crearcaso").dialog("close");
      $("#alertas").html('<div class="alert alert-dismissable alert-error" teid="ale:html:4"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:1"></strong></div>');
      $(document).renderme('sp');
    }
  });

  $(document).renderme('sp');
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