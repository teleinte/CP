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
				$('#tVencidas').append('<tr><td colspan = "2">Las siguientes copropiedades se encuentran desactivadas por fin de vigencia:</td></tr>')
				$('#tVencidas').append('<tr><td>COPROPIEDAD</td><td>FECHA FIN VIGENCIA</td></tr>')
				$.each(vencidas,function(k,v){
					var partirVencidos=v.split("@@@");
					$('#tVencidas').append('<tr><td>'+partirVencidos[1]+'</td><td>'+partirVencidos[2]+'</td></tr>')
				});
			}
			else
			{
				$('#vencidas').hide();
			}

			if(otros.length > 0)
			{
				var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;});
				var tk = params['token'];
				$('#tIngreso').append('<tr><td><a class="btn" href="../inicio/">Ingresar como Administrador</a><br/></td><tr><td><br/><a class="btn" id="residente" tk="' + tk +'">Ingresar como Residente</a></td><tr></tr>');
			}
			else
			{
				idcp = admin[0].split("@@@")[0];
				sessionStorage.setItem('cp',idcp);
				location.href = "../inicio/";
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
			location.href = "https://mi.copropiedad.co/inicio/index.php?token=" + params['token'];
		}
		else
		{
			alert('z');
			checkUserFlow(actualURL);
			location.href = "../inicio/";	
		}

		$("#residente").click(function(){
			sessionStorage.clear();
			location.href = 'https://mi.copropiedad.co/inicio/index.php?token=' + $(this).attr('tk');
		});
	}
}); 