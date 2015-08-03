$(document).ready(function(){
	sessionStorage.removeItem("pasador");
	$('.selector-copropiedad').html("<span class=titulo-cop><strong>"+ sessionStorage.getItem('ncp') +"</strong></span>");
	$(document).renderme('co');
	$("#alertas").html('<div class="alert alert-dismissable alert-info"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4 teid="co:html:282"></h4></div>'); 	
  	var arr = { token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp'),tipo_documento:"puc"}}; 
  	var datos = traerDatosSync("contabilidad/obtener/puc/", arr);
  	popularPuc(datos);
  	$("#envio_caso").click(function()
	{
		sessionStorage.setItem("pasador","puc");
		window.location="../../casos-soporte/";
	});	
  	$(document).renderme('co');
});