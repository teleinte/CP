$(document).ready(function(){
  $(document).renderme('sp');

  
  var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})      
  var arr = { token:sessionStorage.getItem('token'),body:{item_type:"casos-soporte"}};
  var datos = traerDatosSync("managercp/casos/listar", arr, 'params');
  // alert(JSON.stringify(datos));
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
    "drawCallback": function( settings ) {
      $(".completar").click(function(event){
        event.preventDefault();
        //$("#dialog_eliminar").dialog("open");
        sessionStorage.setItem('mongoid', $(this).attr('mongoid'));
        window.location="respuesta.php";
      });
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
	
  popularTabla(datos);

  //$("div.toolbar").html('<a href="crear.php" class="btn ttip positivo" id ="open-crearcaso" style="margin-right:5px;" teid="sp:html:11, sp:title:12"></a>');

  $("#caso_form").submit(function(event){
    event.preventDefault();
    $('input[type=submit]').attr('disabled',true);
    var arr = {
     token:sessionStorage.getItem('token'),
     body:{
         id_copropiedad:sessionStorage.getItem('cp'),
         usuario:sessionStorage.getItem('id_crm'),
         fecha_creacion:$('#fecha_creacion_caso').html(),
         caso:$('#caso').val(),
         estado:"Abierto",
         notas:$('#notas').val(),
         fecha_cierre:fecha(),
         usuario_nombre:sessionStorage.getItem('nombreCompleto'),
         item_type:"casos-soporte"
        }
    };
    var url = "casos-soporte/insertar";
    //alert(JSON.stringify(arr));
    var response = envioFormularioMessageSync(url,arr,'POST');
    if(response)
    {
        var cliente = sessionStorage.getItem('email').split('cp-')[1];
        var txt_caso = '<div style="border:2px solid #aaa; padding: 5px 5px 5px; background-color:#fff;-webkit-border-radius: 5px; -moz-border-radius: 5px;border-radius: 5px; "><pre style="font-family:Arial,Helvetica,sans-serif; white-space: pre-wrap; ">'+ $('#caso').val() +'</pre></div>';
        var txt_notas = '<div style="border:2px solid #aaa; padding: 5px 5px 5px; background-color:#fff;-webkit-border-radius: 5px; -moz-border-radius: 5px;border-radius: 5px; "><pre style="font-family:Arial,Helvetica,sans-serif; white-space: pre-wrap;">'+ $('#notas').val() +'</pre></div>';
        var body = '<p> Sr(a) <strong>'+sessionStorage.getItem('nombreCompleto')+'</strong>, gracias por enviarnos su caso de soporte:<br><br> Copropiedad: '+sessionStorage.getItem('ncp')+'<br> <strong> ID: </strong>'+ (response.message.$id).substring(18,25) +'<br> <strong>Caso: </strong>'+ txt_caso +' <br> <strong>Notas: </strong>'+ txt_notas +'<br> Le enviaremos la respuesta al correo electrónico '+ cliente +' dentro de las siguientes 24 horas.</p> <strong> Equipo de soporte Copropiedad.co </strong></p>';
        var subject = "Soporte Copropiedad.co";
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

  /*$(".completar").click(function(event){
    event.preventDefault();
    //$("#dialog_eliminar").dialog("open");
    sessionStorage.setItem('mongoid', $(this).attr('mongoid'));
    window.location="respuesta.php";
  });*/

  $("#dialog_eliminar").dialog({
    resizable: false,
    autoOpen: false,
    width: 400,
    modal: true,
    title: obtenerTerminoLenguage('sp','17'),
    buttons:{
      "Cancelar" : function(){
        $(this).dialog("close");
      },
      "Aceptar" : function(){
        $(this).dialog("close");
        var arr = {token:sessionStorage.getItem('token'),body:{id:$("#elmongoid").val()}};
        var url = "casos-soporte/list";
        var response = envioFormularioSync(url,arr,'DELETE');
        if(response)
        {
          setTimeout(refreshWindow('index.php'),1000);
        }
        else
        {
          $("#crearcaso").dialog("close");
          $("#alertas").html('<div class="alert alert-dismissable alert-error" teid="ale:html:4"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><p teid="ale:html:1"></p></div>');
          $(document).renderme('sp');
        }
      }
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