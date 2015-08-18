$(document).ready(function(){
	var actualURL = 'https://appdes.copropiedad.co/';
	var len_vencidas;
	var vencidas;
	var len_admin;
	var admin;
	var len_otros;
	var otros;

	if(sessionStorage.getItem('cp_vencidas') != null || sessionStorage.getItem('cp_vencidas') != undefined)
	{
		len_vencidas = calculateArrayLenght(cleanArray(sessionStorage.getItem('cp_vencidas').split(',')));
		vencidas = cleanArray(sessionStorage.getItem('cp_vencidas').split(','));
	}
	else
	{
		len_vencidas = 0;
		vencidas = Array();
	}

	if(sessionStorage.getItem('cp_admin') != null || sessionStorage.getItem('cp_admin') != undefined)
	{
		len_admin = calculateArrayLenght(cleanArray(sessionStorage.getItem('cp_admin').split(',')));
		admin = cleanArray(sessionStorage.getItem('cp_admin').split(','));
	}
	else
	{
		len_admin = 0;
		admin = Array();
	}
	
	if(sessionStorage.getItem('cp_otros') != null || sessionStorage.getItem('cp_otros') != undefined)
	{
		len_otros = calculateArrayLenght(cleanArray(sessionStorage.getItem('cp_otros').split(',')));
		otros = cleanArray(sessionStorage.getItem('cp_otros').split(','));
	}
	else
	{
		len_otros = 0;
		otros = Array();
	}

	if(parseInt(sessionStorage.getItem('estadoCP')) == 2)
	{
		if(admin.length >= 0)
		{
			if(vencidas.length > 0)
			{
				$('#message_cp').html('<h4>No hemos recibido el pago de renovación del servicio para la(s) siguiente(s) copropiedad(es).</h4>');
				$.each(vencidas,function(k,v){
					var partirVencidos=v.split("@@@");
					$('#tVencidas').append('<tr><td><h4>'+partirVencidos[1]+'</h4></td><td><h4>'+partirVencidos[0]+'</h4></td></tr>');
				});
				$('#advice_cp').html('<i><h4>Para renovar el servicio y activar la(s) copropiedades, ingrese como administrador, de clic sobre su nombre (esquina superior derecha) y seleccione la opción "Mis pagos".</h4></i>');
				if(admin.length == 0)
				{
					checkRemoteUserFlow(actualURL);
				}
				else
				{
					idcp = admin[0].split("@@@")[0];
					nocp = admin[0].split("@@@")[1];
					checkRemoteUserFlow(actualURL);
	                sessionStorage.setItem('cp',idcp);
					sessionStorage.setItem('ncp',nocp);
				}
			}
			else
			{
				$('#vencidas').hide();
			}

			if(otros.length > 0)
			{
				var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;});
				var tk = params['token'];
				$('#tIngreso').append('<a class="btn" href="../inicio/">Ingresar como Administrador</a><br/><br/><br/><a class="btn" id="residente" tk="' + tk +'">Ingresar como Residente</a>');
			}
			else
			{
				if(admin.length == 0)
				{
					checkRemoteUserFlow(actualURL);
					$('#tIngreso').append('<a class="btn" href="../inicio/">Ingresar como Administrador</a><br/><br/><br/>');
				}
				else
				{
					idcp = admin[0].split("@@@")[0];
					sessionStorage.setItem('cp',idcp);
					location.href = "../inicio/";
				}
			}
		}
		else if(otros.length > 0)
		{
			$('#vencidas').hide();
			if(admin.length > 0)
			{
				var idcp = admin[0].split("@@@")[0];
			}
			else
			{
				var idcp = otros[0].split("@@@")[0];
			}
			sessionStorage.clear();
			var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;});
			location.href = "https://mides.copropiedad.co/inicio/index.php?token=" + params['token'];
		}
		else
		{
			checkUserFlow(actualURL);
			location.href = "../inicio/";	
		}

		$("#residente").click(function(){
			sessionStorage.clear();
			location.href = 'https://mides.copropiedad.co/inicio/index.php?token=' + $(this).attr('tk');
		});
	}

	if(parseInt(sessionStorage.getItem('estadoCP')) == 1)
	{
		if(admin.length >= 0)
		{
			if(vencidas.length > 0)
			{
				$('#message_cp').html('<h4>No hemos recibido el pago de renovación del servicio para la(s) siguiente(s) copropiedad(es).</h4>');
				$.each(vencidas,function(k,v){
					var partirVencidos=v.split("@@@");
					$('#tVencidas').append('<tr><td><h4>'+partirVencidos[1]+'</h4></td><td><h4>'+partirVencidos[0]+'</h4></td></tr>');
				});
				$('#advice_cp').html('<i><h4>Para renovar el servicio y activar la(s) copropiedades, ingrese como administrador, de clic sobre su nombre (esquina superior derecha) y seleccione la opción "Mis pagos".</h4></i>');
				$('#tIngreso').append('<a class="btn" href="../inicio/">Continuar</a>');
				$("#titulo-perfil").html('');
				if(admin.length > 0)
				{
					idcp = admin[0].split("@@@")[0];
					nocp = admin[0].split("@@@")[1];
					checkRemoteUserFlow(actualURL);
	                sessionStorage.setItem('cp',idcp);
					sessionStorage.setItem('ncp',nocp);
				}
			}
			else
			{
				$('#vencidas').hide();
			}
		}
		else if(otros.length > 0)
		{
			$('#vencidas').hide();
			if(admin.length > 0)
			{
				var idcp = admin[0].split("@@@")[0];
			}
			else
			{
				var idcp = otros[0].split("@@@")[0];
			}
			//sessionStorage.setItem('cp',idcp);
			sessionStorage.clear();
			var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;});
			//console.warn(atob(params['token']));
			location.href = "https://mides.copropiedad.co/inicio/index.php?token=" + params['token'];
		}
		else
		{
			//alert('z');
			checkUserFlow(actualURL);
			location.href = "../inicio/";	
		}

		$("#residente").click(function(){
			sessionStorage.clear();
			location.href = 'https://mides.copropiedad.co/inicio/index.php?token=' + $(this).attr('tk');
		});
	}
}); 