$(document).ready(function()
{
	$('.selector-copropiedad').html("<span class=titulo-cop><strong>"+ sessionStorage.getItem('ncp') +"</strong></span>");
	$(document).renderme('co');
	var arr = { token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp'),tipo_documento:"puc"}}; 
	var datos = traerDatosSync("contabilidad/obtener/puc/", arr);
	popularPuc(datos);
	$(document).renderme('co');
  
});