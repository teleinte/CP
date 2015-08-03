function popularTabla(datos)
{
	var puc = formatPuc(sessionStorage.getItem('puc'));
	var idx = 1;
	$.each(datos,function(x,y){
		key = y.split("@")[0];
		value = y.split("@")[1];
		defaultv = 1;
		var actual = Number(value);
		var convertido = '$ ' + actual.toLocaleString('es-CO', { style: 'currency', currency:'COP'});
		var newvalue = (Number(value) * Number(defaultv)/100) + Number(value);
		var newconvertido = '$ ' + newvalue.toLocaleString('es-CO', { style: 'currency', currency:'COP'});
		$("#presupuesto").append('<tr><td class="tcpresupuesto">' + key + '</td><td class="tcpresupuesto">' + puc[key] + '</td><td class="tcpresupuesto">' + convertido + '</td><td class="tcpresupuesto"><span class="newvaluepresupuesto" id="new' + idx + '" oldvalue="' + value + '" idx="' + idx + '">' + newconvertido + '</span></td><td><input type="number" min="0" max="10" step="0.1" value="' + defaultv + '" id="incremento' + idx + '" class="incrementofino" idx="' + idx + '"> %</td>');
		idx = idx + 1;
	});
}

function ajustarBalance(balance)
{
	var out = new Array();
	$.each(balance,function(key, value){
		$.each(value,function(k,v){
			$.each(v,function(x,y){
				$.each(y,function(a,b){
					if(a.length == 6)
						out.push(a + "@" + b);
				});
			});
		});
	});
	//console.log(out);
	return out;
}

function traerBalance()
{
	var rutaAplicativo = "https://app.copropiedad.co/api/contabilidad/balance/prueba/";      
	var metodo = "POST";
	var res = "";
	var arr = 
	{
		token:sessionStorage.getItem('token'),
		body:
		{
			//id_copropiedad:sessionStorage.getItem('cp'),
			id_copropiedad:"5511995bbbc118d03fbd2191",
			nivel:"5"
		}
	};

	$.ajax(
	{
		url: rutaAplicativo,
		type: metodo,
		data: JSON.stringify(arr),
		contentType: 'application/json; charset=utf-8',
		dataType: 'json',
		async: false,
		success: function(msg) 
		{
			var msgDividido = JSON.stringify(msg);
			var mensaje =  JSON.parse(msgDividido); 
			res = mensaje.message;         
		}
	});  

	//console.log(res);
	return res;
}

function formatPuc(puc)
{
	var out = new Array;
	$.each(JSON.parse(puc),function(x,y){
		out[y["cuenta"]] = y["nombre"];
	});
	return out;
}