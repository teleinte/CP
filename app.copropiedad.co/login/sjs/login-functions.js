 function doLogin(actualurl)
{
	var arr = {token:"no-token",body:{email:"cp-" + $("#usr").val().toLowerCase(),password:$("#pas").val()}};
	var url = "https://auth.sinfo.co/auth/login";
	var datos = envioFormularioURLMessageSync(url,arr,'POST');
	var res = false;
    var sessiondata = "?";
	if(datos)
	{
		var msgDividido = JSON.stringify(datos);
		var mensaje =  JSON.parse(msgDividido);
		var msgDivididoDos = JSON.stringify(mensaje.message);
        var response = JSON.parse(msgDivididoDos);
        var userdata = {};
		if (mensaje.status)
        {
            $.each(response, function(x , y) 
            {                     
                sessionStorage.setItem(x, y);
                userdata[x] = y;
                sessiondata = sessiondata + x + "=" + y + "&";
                res = sessiondata;
            });
            var url2 = "api/activacion/";
            envioFormularioURLMessageSync(actualurl + '/' + url2,userdata,'PUT');
		}
		else
		{
			$("#alertas").html('<div class="alert alert-error">Usuario o clave invalidos.</div>');
			res = false;
		}
	}
	else
	{
		$("#alertas").html('<div class="alert alert-error"><strong>Ha ocurrido un error en el servicio de autenticacion, comuniquese con soporte tecnico por favor</div>');
		res = false;
	}
	return res;
}

function getLoginToken(actualURL)
{
	var rnd = generateUUID();
	var arr = {body:{autkey:"cp-" + $("#usr").val().toLowerCase(),user:btoa(String(rnd) + $("#pas").val())}};
	var datos = envioFormularioURLMessageSync(actualURL,arr,'PUT');
	var res = false;
	if(datos)
	{
		var msgDividido = JSON.stringify(datos);
		var mensaje =  JSON.parse(msgDividido);
		var msgDivididoDos = JSON.stringify(mensaje.message);
        var response = JSON.parse(msgDivididoDos);
		if (mensaje.status)
        {
            $.each(response, function(x , y) 
            {                     
                sessionStorage.setItem(x, y);
                res = y;
            });
		}
		else
		{
			$("#alertas").html('<div class="alert alert-error">Usuario o clave invalidos.</div>');
			res = false;
		}
	}
	else
	{
		$("#alertas").html('<div class="alert alert-error"><strong>Ha ocurrido un error en el servicio de autenticacion, comuniquese con soporte tecnico por favor</div>');
		res = false;
	}

	return res;
}