$(document).ready(function(){

  var elem = JSON.parse(sessionStorage.getItem("acelem"));
  if(elem['tipo'] == obtenerTerminoLenguage('cl','39'))
  {
    $("#mongoid").val(elem['id']);
    $("#fecha_creacion").val(elem['fecha_creacion']);
    $('#nombre').val(elem['nombre']);
    $('#estado').val(elem['estado']);
    $('#datepicker2').val(elem['deadline'].split('COT')[0]);
    $('#notas').val(elem['notas']);
    $('#frecuencia').val(elem['frecuencia']);

    $('#comongoid').val(elem['id']);
    $('#cocreacion').val(elem['fecha_creacion']);
    $('#conombre').val(elem['nombre']);
    $('#codeadline').val(elem['deadline'].split('COT')[0]);
    $('#cofrecuencia').val(elem['frecuencia']);
    $('#conotas').val(elem['notas']);
  }

  // Traer los datos de la tarea a eliminar
 	var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})      
 	var arr = { token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp'),tipo:obtenerTerminoLenguage('tar','33')}};
 	var datos = traerDatosSync("tareas/getlistFilter", arr, sessionStorage.getItem('cp'));
  
  // Popula los datos en los campos del formulario para cambiarlos
  popularDatosModificables(datos);

  $(document).renderme('tar');  

$("#tarea_form_editar").submit(function(event){
    event.preventDefault();
    var ParamFecha=fecha();
    var fechaFinal="";
    $('input[type=submit]').attr('disabled',true);
    
    var arr = 
    {
      token:sessionStorage.getItem('token'),
      body:
      {
        id:params['idt'],
        id_copropiedad : sessionStorage.getItem('cp'),
        creador: sessionStorage.getItem('id_crm'),
        fecha_creacion:$('#fecha_creacion').val(),
        tipo:"tarea",
        nombre:$('#nombre').val(),
        estado:$('#estado').val(),
        responsable:$('#responsable').val(),
        fecha_fin:fechaFinal,
        prioridad:$('#prioridad').val(),
        deadline:$('#datepicker2').val(),
        notas:$('#notas').val(),
        frecuencia:$('#frecuencia').val(),
        frecordatorio:$('#datepicker').val(),
        recordatorio_mail:$('#recordatorio_mail').is(':checked'),
        recordatorio_cp:$('#recordatorio_cp').is(':checked'),
        compartir_mail:$('#compartir_mail').val()                        
      }
    };  
        
    var url = "tareas/list";
    var response = envioFormularioSync(url,arr,'PUT');
    if(response)
    {
      setTimeout(window.location = 'index.php',1000);
    }
    else
    {
      $("#creartarea").dialog("close");
      $("#alertas").html('<div class="alert alert-dismissable alert-error" teid="tar:html:14"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="tar:html:1"></strong></div>');
      $(document).renderme('tar');
    }
  });
  $(document).renderme('tar');
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
  