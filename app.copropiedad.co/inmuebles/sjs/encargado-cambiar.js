	$(document).ready(function(){

  $(document).renderme('ct');

  // Traer los datos de los contactos a eliminar
  var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
  var arr = {token:sessionStorage.getItem('token'),body:{_id:params['idt']}};
  var datos = traerDatosSync("admin/copropiedad/usuario/personaid", arr);
  // Popula los datos en los campos del formulario para cambiarlos
  popularDatosUsuario(datos);

// envia los datos a eliminaral WS
$("#usuario_form_cambiar").submit(function(event){ 
  event.preventDefault();
  var ParamFecha=fecha();  
  $('input[type=submit]').attr('disabled',true);
  if($('#opcion').val()=="NO"){var pagina="inmueble-editar.php?idt="+params['rg'];setTimeout(refreshWindow(pagina),1000);return false;}

  //traer el usuario encargado actual para modificarlo

	var arr = {token:sessionStorage.getItem('token'),body:{unidad:params['rg']}};
	var datos = traerDatosSync("admin/copropiedad/usuario/copropiedad/encargado/", arr);
	if(JSON.stringify(datos)=="null")
	{
		var arrNuevo = {token:sessionStorage.getItem('token'),body:{mongoid:params['idt'],principal:true}};
		var response2 = envioFormularioMessageSync("admin/copropiedad/usuario/copropiedad/encargadomodificar/",arrNuevo,'POST');
		if(response2)
		{
			var arrNuevo = {token:sessionStorage.getItem('token'),body:{mongoid:params['idt'],principal:true}};
			var response2 = envioFormularioMessageSync("admin/copropiedad/usuario/copropiedad/encargadomodificar/",arrNuevo,'POST');
			var pagina="inmueble-editar.php?idt="+params['rg'];
			setTimeout(refreshWindow(pagina),1000);
		}
	}
	var response="";
  	$.each(datos, function(x , y)
	{
	   nombreLlegada=y['_id'];
	   $.each(nombreLlegada, function(z , k)
		{
		  	nombreSalida=k;		  	
		  	var arr = {token:sessionStorage.getItem('token'),body:{mongoid:nombreSalida,principal:"false"}};
			response = envioFormularioMessageSync("admin/copropiedad/usuario/copropiedad/encargadomodificar/",arr,'POST');  
		});
	});
  	if(response)
	{
		var arrNuevo = {token:sessionStorage.getItem('token'),body:{mongoid:params['idt'],principal:true}};
		var response2 = envioFormularioMessageSync("admin/copropiedad/usuario/copropiedad/encargadomodificar/",arrNuevo,'POST');
		if(response2)
		{
			var arrNuevo = {token:sessionStorage.getItem('token'),body:{mongoid:params['idt'],principal:true}};
			var response2 = envioFormularioMessageSync("admin/copropiedad/usuario/copropiedad/encargadomodificar/",arrNuevo,'POST');
			var pagina="inmueble-editar.php?idt="+params['rg'];
			setTimeout(refreshWindow(pagina),1000);
		}
	}
  });

  $(document).renderme('in');
});