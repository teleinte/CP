function traerDireccion()
{
    return "https://appdes.copropiedad.co/";
}

$(window).load(function(){
  $('#cpLoading').fadeOut(1000);
  $('html').addClass('no-js');
});

$(document).ready(function(){
  	//var tokenval = checkTokenValidity();

  	var initDatepicker = function() {
  	    $('input[type=date]').each(function() {
  	        var $input = $(this);
  	        $input.datepicker({
  	            //minDate: 0,
  	            dateFormat: 'yy-mm-dd'
  	        });
  	        $(this).val().replace('-','/');
  	    });
  	};
  	 
  	if(!Modernizr.inputtypes.date){
  	    $(document).ready(initDatepicker);
  	};

  	//alert(navigator.userAgent);

  	/*if (/Windows\s([\d.]+)/.test(navigator.userAgent)) {
  	    alert("pfff");
  	}*/


  	/*if(!tokenval)
  	{
  		window.location = '../login';
  		sessionStorage.clear();
  		sessionStorage.setItem('message','Su sesion ha caducado, por favor ingrese de nuevo');
  	}*/
	
	//$('#nusuario').append("&nbsp;" + sessionStorage.getItem('email').replace('cp-','') + " - " + sessionStorage.getItem('nombreCompleto') + '<i class="fa fa-caret-down fa-fw"></i>');
	$('#nusuario').append("&nbsp;" + sessionStorage.getItem('nombreCompleto') + '<i class="fa fa-caret-down fa-fw"></i>');
	
	$('#logoprincipal').attr('href',traerDireccion() + 'inicio');
	
	$('#mispagos').attr('href',traerDireccion() + 'perfil/index.php?#cuenta');
	
	$(".modal").dialog({
	  autoOpen: false,
	  modal: true,
	  width: 600
	});

	$(".tutorial").dialog({
	  autoOpen: true,
	  modal: true,
	  width: 600
	});

	$(".tutorial").dialog({
	  autoOpen: true,
	  modal: true,
	  width: 600
	});

	//$(".boton-regresar").click(function(){window.history.back();})

	/*$("#selcopropiedades").attr('title','Seleccione la copropiedad con la que desea trabajar');
	$("#selcopropiedades").addClass('ttip');*/

	$("#micuenta").attr('href',traerDireccion() + 'perfil/');
	$("#mispagos").attr('href',traerDireccion() + 'perfil/mis-pagos.php');
	$("#miempresa").attr('href',traerDireccion() + 'perfil/mi-empresa.php');
	$("#logout").attr('href',traerDireccion() + "login/logout.php");

	var urlpaginaactual = window.location.href;
	var urlescritorio = traerDireccion() + 'inicio';
	var urladmincps = traerDireccion() + 'admin';
	if(trim(urlpaginaactual,"/") != trim(urlescritorio,"/"))
	{
		if(trim(urlpaginaactual,"/") == trim(urladmincps,"/"))
		{
			$('.trescolumas, .ultima').css('font-size','16px');
		}
		else
		{
			if(sessionStorage.getItem('ncp')==null || sessionStorage.getItem('ncp')==undefined || sessionStorage.getItem('ncp')=="undefined")
			{
				$('.trescolumas, .ultima').html('<h4 style="display:inline; font-size:16px; font-weigth:700;" class="ttip" title="'+ obtenerTerminoLenguage('ms','6') +'"><span>'+obtenerTerminoLenguage('ms','5')+'</span><span style="color:#f51e7c; font-weight:bold;">Sin copropiedades</span></h4>').css('margin-top','15px').css('text-align','center');	
			}
			else
			{
				$('.trescolumas, .ultima').html('<h4 style="display:inline; font-size:16px; font-weigth:700;" class="ttip" title="'+ obtenerTerminoLenguage('ms','6') +'"><span>'+obtenerTerminoLenguage('ms','5')+'</span><span style="color:#f51e7c; font-weight:bold;">' + sessionStorage.getItem('ncp')+'</span></h4>').css('margin-top','15px').css('text-align','center');
			}
			
			$('.trescolumas, .ultima h4').css('margin-top','15px');
		}
	}
	else
	{
		checkRemoteUserFlow(traerDireccion());
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

		$('.trescolumas, .ultima').css('font-size','16px');
	}

	$("#contabilidadmenu").click(function(event){
		if((sessionStorage.getItem('userflow') == "22") || (sessionStorage.getItem('userflow') == "23") || (sessionStorage.getItem('userflow') == "2") || (sessionStorage.getItem('userflow') == "223") )
		{
			event.preventDefault();
			$("#alertas").html('<div class="alert alert-dismissable alert-info"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4>Advertencia: </h4><p>Debe crear al menos un proveedor para usar el modulo de contabilidad.</p></div> ');
		}
	});
	
	switch (Number(sessionStorage.getItem('userflow')))
	{
		case 0:
			$("#selcopropiedades").hide();
			$("#pendientes").hide();
			$("#indicador").hide();
			$(".niveluno, .niveldos, .niveltres").removeAttr('href');
			$(".niveluno, .niveldos, .niveltres").addClass('notavailable');
			$(".titulo-cop").hide();
			$("#pendientes").hide();
			if(sessionStorage.getItem('ncp') == undefined || sessionStorage.getItem('ncp') == null || sessionStorage.getItem('ncp') == "undefined")
				$('.trescolumas, .ultima').html('<h4 style="display:inline; font-size:16px; font-weigth:700;" class="ttip" title="'+ obtenerTerminoLenguage('ms','6') +'"><span>'+obtenerTerminoLenguage('ms','5')+'</span><span style="color:#f51e7c; font-weight:bold;">Sin copropiedades</span></h4>').css('margin-top','15px').css('text-align','center');
		break;
		case 1:			
			$(".niveldos, .niveltres").removeAttr('href');
			$(".niveldos, .niveltres").addClass('notavailable');
			
			var cps = checkPerfiles(traerDireccion());
			setupIngreso(sessionStorage.getItem('estadoCP'),cps)
			traerDatosHoy();

			$("#selcopropiedades").change(function(){
				if($(this).val() != "nueva")
				{
					sessionStorage.setItem('cp',$(this).val());
					location.reload();
				}
				else
				{
					location.href = "https://appdes.copropiedad.co/admin/copropiedad_nuevo.php";
				}
			});
			listarCopropiedades();
			$("#pendientes").hide();
		break;
		case 2:
			//setupIngreso(checkVigencia(traerDireccion()),checkPerfiles(traerDireccion()));
			$(".niveltres").removeAttr('href');
			$(".niveltres").addClass('notavailable');
			//$('[name="contabilidad"]').attr('title','Recuerde que debe crear al menos un proveedor para utilizar este modulo.');
			traerDatosHoy();
			if((sessionStorage.getItem('userflow') == "22") || (sessionStorage.getItem('userflow') == "23") || (sessionStorage.getItem('userflow') == "2") || (sessionStorage.getItem('userflow') == "223") )
			{
				$(".niveltres").addClass('notavailable');
			}

			$("#selcopropiedades").change(function(){
				if($(this).val()!= "nueva")
				{
					sessionStorage.setItem('cp',$(this).val());
					location.reload();
				}
				else
				{
					location.href = "https://appdes.copropiedad.co/admin/copropiedad_nuevo.php";
				}
			});
			listarCopropiedades();

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
		break;
		default:
			traerDatosHoy();

			$("#selcopropiedades").change(function(){
				if($(this).val() != "nueva")
				{
					sessionStorage.setItem('cp',$(this).val());
					location.reload();
				}
				else
				{
					location.href = "https://appdes.copropiedad.co/admin/copropiedad_nuevo.php";
				}
			});
			listarCopropiedades();
		break;
	}
});