$(document).ready(function(){
	setTimeout(function(){$("#indicador").fadeOut(2000)},3000);
	if(sessionStorage.getItem('hello') != null || sessionStorage.getItem('hello') != undefined)
		sessionStorage.removeItem('hello');

	var update = actualizarLenguage();
	var dateupdate = new Date(update);
	var today = new Date();

	if(localStorage.getItem('lastupdate') != null || localStorage.getItem('lastupdate') != undefined)
	{
		last = localStorage.getItem('lastupdate');
	}
	else
	{
		localStorage.setItem('lastupdate',today);
		last = today;
	}	
	if(Date.parse(dateupdate) > Date.parse(last))	
	{
		if(localStorage.getItem(sessionStorage.getItem('idioma')) == null || localStorage.getItem(sessionStorage.getItem('idioma')) == undefined)
		{
			var lang = obtenerLenguaje();
			localStorage.setItem('lastupdate',dateupdate);
		}
		else
		{
			localStorage.removeItem(sessionStorage.getItem('idioma'));
			var lang = obtenerLenguaje();
			localStorage.setItem('lastupdate',dateupdate);
		}
	}
	else
	{
		if(localStorage.getItem(sessionStorage.getItem('idioma')) == null || localStorage.getItem(sessionStorage.getItem('idioma')) == undefined)
		{
			var lang = obtenerLenguaje();
			localStorage.setItem('lastupdate',dateupdate);
		}	
	}
	
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

	switch (Number(sessionStorage.getItem('userflow')))
	{
		case 0:
			$("#alertas").html('<div class="alert alert-dismissable alert-info"  teid="ale:html:77"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); 
			$(document).renderme('sl');
		break;
		case 1:			
			$("#alertas").html('<div class="alert alert-dismissable alert-info" teid="ale:html:80"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); 
			$(document).renderme('sl');
		break;
		/*case 2:
			$("#alertas").html('<div class="alert alert-dismissable alert-info" teid="ale:html:83"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h3 teid="ale:html:81"></h3><strong teid="ale:html:82"></strong></div>'); 
			$(document).renderme('sl');
		break;*/
		default: 
		break;
	}
});