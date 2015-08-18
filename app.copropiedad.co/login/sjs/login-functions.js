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

function doLoginAs(user, actualurl)
{
	var userdata = {};
	var sessiondata = "?";
	var res = false;
	if(user != null || user != undefined)
	{
	    $.each(user, function(x , y) 
	    {                     
	        sessionStorage.setItem(x, y);
	        userdata[x] = y;
	        sessiondata = sessiondata + x + "=" + y + "&";
	        res = sessiondata;
	    });
	    var url2 = "api/activacion/";
	    envioFormularioURLMessageSync(actualurl + '/' + url2,userdata,'PUT');
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

function getLoginTokenSA(actualURL, usuario, password)
{
	var rnd = generateUUID();
	var arr = {body:{autkey:"cp-" + usuario.toLowerCase(),user:btoa(String(rnd) + password)}};
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


function doLoginSA(actualurl)
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
			res = JSON.stringify(response);
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

 function isSA(url, usuario)
{
	var arr = {token:"notoken",body:{email:usuario.toLowerCase()}};
	var datos = envioFormularioURLMessageSync(url,arr,'POST');
	var res = false;
	if(datos)
	{
		var msgDividido = JSON.stringify(datos);
		var mensaje =  JSON.parse(msgDividido);
		var msgDivididoDos = JSON.stringify(mensaje.message);
        var response = JSON.parse(msgDivididoDos);
        var userdata = {};
		if (mensaje.status)
        {
        	//console.warn(JSON.stringify(mensaje.message.admins));
			if(mensaje.message.isSA)
				res = mensaje.message.admins;
			else
				res = false;
		}
		else
		{
			$("#alertas").html('<div class="alert alert-error">Error al intentar validar los perfiles asociados a su cuenta.</div>');
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

function listarPerfiles(perfiles)
{
	if(perfiles != null || perfiles != undefined)
		$.each(perfiles, function(k,v){
			$("#message_cp").append('<input class="btn loginas" style="clear:both;" type="button" value="' + v["nombreCompleto"] + '" userdata="' + btoa(JSON.stringify(v)) + '" /><br/><br/><br/>');
		});
}