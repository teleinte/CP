$(document).ready(function(){
	$(document).renderme('co');
	$('.selector-copropiedad').html("<span class=titulo-cop><strong>"+ sessionStorage.getItem('ncp') +"</strong></span>");
	//$("#selcopropiedades").prop('disabled', true);
	var arr = { token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp')}};
	var datos = traerDatosSync("cartera/estado/cartera", arr);
	console.warn(datos);
	console.warn(arr);
	popularCartera(datos);

	$("#print").click(function(){
		printDiv("carteraprint");
	});

	$(document).renderme('co');
});