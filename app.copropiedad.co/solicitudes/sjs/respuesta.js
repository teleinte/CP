$(document).ready(function(){
  $(document).renderme('sp');
  
  var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})      
  var arr = { token:sessionStorage.getItem('token'),body:{_id: sessionStorage.getItem('mongoid'), item_type:"solicitudes"}};
  var datos = traerDatosSync("frontdesk/getlist/filter", arr, 'params');
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
         id_copropiedad:$('#id_copropiedad').val(),
         usuario: $('#id_crm_cliente').val(),
         fecha_creacion:$('#fecha_creacion_guardar').val(),
         solicitud:$('#caso_cliente').html(),
         estado:"completada",
         notas:$('#notas_cliente').html(),
         fecha_cierre:"",
         usuario_nombre: $('#cliente_nombre').html(),
         usuario_correo: $('#cliente_correo').html(),
         respuesta: $('#respuesta_caso').val(),
         usuario_admin:sessionStorage.getItem('email').split('cp-')[1],
         item_type:"solicitudes"
        }
    };
    var url = "frontdesk/list";
    //alert(JSON.stringify(arr));
    var response = envioFormularioMessageSync(url,arr,'PUT');
    if(response)
    {
        var cliente = $('#cliente_correo').html();
        if(document.respuesta_caso_form.copia.checked)
          cliente = sessionStorage.getItem('email').split('cp-')[1]+', '+cliente;
        var txt_caso = '<div style="border:2px solid #aaa; padding: 5px 5px 5px; background-color:#fff;-webkit-border-radius: 5px; -moz-border-radius: 5px;border-radius: 5px; "><pre style="font-family:Arial,Helvetica,sans-serif; white-space: pre-wrap; ">'+ $('#caso_cliente').html() +'</pre></div>';
        var txt_notas = '<div style="border:2px solid #aaa; padding: 5px 5px 5px; background-color:#fff;-webkit-border-radius: 5px; -moz-border-radius: 5px;border-radius: 5px; "><pre style="font-family:Arial,Helvetica,sans-serif; white-space: pre-wrap;">'+ $('#notas_cliente').html() +'</pre></div>';
        var txt_respuesta = '<div style="border:2px solid #aaa; padding: 5px 5px 5px; background-color:#fff;-webkit-border-radius: 5px; -moz-border-radius: 5px;border-radius: 5px; "><pre style="font-family:Arial,Helvetica,sans-serif; white-space: pre-wrap;">'+ $('#respuesta_caso').val() +'</pre></div>';
        var body = '<p><strong>Referencia (ID Solicitud): </strong>'+ $('#id_caso').html()+'<br><br>Sr(a) residente, <br>A continuación la respuesta a la solicitud en referencia. <br><br><strong>Copropiedad: </strong> '+ sessionStorage.getItem('ncp') +' <br><br><strong>Solicitud enviada: </strong><br>'+ txt_caso +'<br><strong>Notas complementarias enviadas: </strong><br>'+ txt_notas +'<br><strong>Respuesta: </strong><br>'+txt_respuesta+' </p>Atentamente,<br><br><strong> '+ sessionStorage.getItem('nombreCompleto') +' </strong>';
        var subject = "Respuesta a solicitud - Referencia: "+$('#id_caso').html();
        var email = cliente;
        enviocorreosolicitud(body, subject, email);
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