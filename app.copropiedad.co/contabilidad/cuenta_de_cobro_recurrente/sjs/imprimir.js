$(document).ready(function(){
	$(document).renderme('ge');
	//$("#selcopropiedades").prop('disabled', true);
	$('.selector-copropiedad').html("<span class=titulo-cop><strong>"+ sessionStorage.getItem('ncp') +"</strong></span>");
	var recibos = JSON.parse(sessionStorage.getItem('recibos'));
	if(recibos.length > 0)
	$.each(recibos,function(k,v){
		var cargos = ""
		$.each(v['cargos'],function(x,y){
			cargos += '<tr style="text-align:right"><td>' + x + '</td><td>' + accounting.formatMoney(y, "$ ", 0) + '</td></tr>';
		});

		var display = '<div id="recibo' + v['consecutivo'] + '" class="recibo mitad" style="border:1px solid #aaa; background-color:#eee; padding:5px; margin:5px auto;">';
		var print = '<div id="recibo' + v['consecutivo'] + '" class="recibo mitad" style="padding:5px; margin:5px auto; border-bottom:1px dotted #eee;">';
		var code = '<table><tr><td width="33%"></td><td width="34%"></td><td width="33%"></td></tr><tr><td colspan="2"><h3>' + v['nombre_copropiedad'] + '</h3></td><td><h2><span teid="co:html:180"></span><span>' + v['consecutivo'] + '</span></h2></td></tr><tr><td colspan="2"><h3 ><span teid="co:html:181"></span><span>' + v['tercero'] + '</span></h3></td><td><h3 ><span teid="co:html:182"></span><span>' + v['inmueble'] + '</span></h3></td></tr><tr><td colspan="3"><h4 ><span teid="co:html:183"></span><span>' + v['concepto'] + '</span></h4></td></tr><tr><td colspan="3" style="margin-bottom:0px;"><h4 style="margin-bottom:0px;" ><span teid="co:html:184"></span></h4></td></tr><tr><td colspan="3"><table width="100%"><tr><td width="50%"></td><td width="50%"></td></tr>' + cargos + '</table></tr>';

		if(v["diaadmin"] != undefined || v["diaadmin"] != null){
			code += '<tr style="text-align:right"><td colspan="2"><h4>' + v['diaadmin'] + '</h4></td><td>' + accounting.formatMoney(accounting.toFixed(v['descadmin'],1), "$ ", 0) + '</td></tr>';
			code += '<tr style="text-align:right"><td colspan="2"><h4>Para pago despues de esta fecha: </h4></td><td>' + accounting.formatMoney(accounting.toFixed(v['thispago'],1), "$ ", 0) + '</td></tr>';
		}

		if(v["diarecargo"] != undefined || v["diarecargo"] != null)
			code += '<tr style="text-align:right"><td colspan="2"><h4>' + v['diarecargo'] + '</h4></td><td>' + accounting.formatMoney(accounting.toFixed(v['recargo'],1), "$ ", 0) + '</td></tr>';

		if(v["cartera"] != undefined || v["cartera"] != null)
			code += '<tr style="text-align:right"><td colspan="2"><h4  teid="co:html:185"></h4></td><td>' + accounting.formatMoney(accounting.toFixed(v['cartera'],1), "$ ", 0) + '</td></tr>';

		if(v["mora"] != undefined || v["mora"] != null)
		{
			code += '<tr style="text-align:right"><td colspan="2"><h4">+ Mora</h4></td><td>' + accounting.formatMoney(accounting.toFixed(v['cartera'],1), "$ ", 0) + '</td></tr>';
			code += '<tr style="text-align:right"><td colspan="2"><h4">+ Int. Mora</h4></td><td>' + accounting.formatMoney(accounting.toFixed(v['mora'],1), "$ ", 0) + '</td></tr>';
		}

		if(v["anticipos"] != undefined || v["anticipos"] != null)
			code += '<tr style="text-align:right"><td colspan="2"><h4">- Anticipos</h4></td><td>' + accounting.formatMoney(accounting.toFixed(v['anticipos'],1), "$ ", 0) + '</td></tr>';

		code += '<tr style="text-align:right"><td colspan="2"><h4 teid="co:html:186"></h4></td><td>' + accounting.formatMoney(accounting.toFixed(v['totalapagar'],1), "$ ", 0) + '</td></tr><tr><td colspan="3"><h4 teid="co:html:187"></h4>'+ v['notas'] +'</td></tr></table></div>';
		$(document).renderme('co');
		$("#recibos").append(display + code);
		$("#recibosprint").append(print + code);
	});

	$("#imprimir").click(function(){
		printDiv("recibosprint");
	});

	if(recibos.length > 0)
		$("#cantidad").html("Se han generado " + recibos.length + " cuentas de cobro.");
	else
		$("#cantidad").html("Se han generado 0 cuentas de cobro.");


	$(document).renderme('co');
});