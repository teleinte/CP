$(document).ready(function(){
  	var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})      
  	var arr = { token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp'),tipo:obtenerTerminoLenguage('tar','33')}};
 	var datos = traerDatosSync("tareas/getlist", arr, sessionStorage.getItem('cp'));

 	popularDatosEliminables(datos);

	$(document).renderme('tar');
	$("#tarea_form_editar").submit(function(event){
    event.preventDefault();
    $('input[type=submit]').attr('disabled',true);
    
    var ParamFecha=fecha();
    var fechaFinal=ParamFecha;
    
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
        estado:"eliminada",
        responsable:$('#responsable').val(),
        fecha_fin:fechaFinal,
        prioridad:$('#prioridad').val(),
        deadline:$('#datepicker2').val(),
        notas:$('#notas').val(),
        frecuencia:$('#frecuencia').val(),
        //frecordatorio:$('#frecordatorio').val(),
        recordatorio_mail:$('#recordatorio_mail').val(),
        recordatorio_cp:$('#recordatorio_cp').val(),                        
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
      $("#alertas").html('<div class="alert alert-dismissable alert-error" teid="tar:html:9"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="tar:html:1"></strong></div>');
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