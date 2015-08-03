$(document).ready(function(){
	$(document).renderme('re');

	checkRemoteUserFlow(traerDireccion());
	console.warn(sessionStorage.getItem('userflow'));
	sessionStorage.removeItem('reservaFechaRequerida');
	sessionStorage.removeItem('reservaFechaRequeridaFin');
	sessionStorage.removeItem('reservaFechaRequeridaInicio');
	sessionStorage.removeItem('reservaInmueble_id');
	sessionStorage.removeItem('reservaInmueble_text');
	$(document).renderme('re');
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

    if(sessionStorage.getItem('userflow') == 21 || sessionStorage.getItem('userflow') == 22 || sessionStorage.getItem('userflow') == 2 || sessionStorage.getItem('userflow') == 212  || sessionStorage.getItem('userflow') == 1)
    {
    	$(".niveltres").removeAttr('href');
    	$(".niveltres").addClass('notavailable');
    	$("#alertas").html('<div class="alert alert-dismissable alert-info" teid="ale:html:27"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:28"></strong></div>'); 
    }

    $(document).renderme('re');
});