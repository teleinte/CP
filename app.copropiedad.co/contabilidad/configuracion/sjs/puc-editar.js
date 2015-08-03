$(document).ready(function(){
//$("#selcopropiedades").prop('disabled', true);
$('.selector-copropiedad').html("<span class=titulo-cop><strong>"+ sessionStorage.getItem('ncp') +"</strong></span>");
  var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
 $('#cuentaAnterior').html(params['idt']+"  "+decodeURIComponent(params['n']));
 $('#nuevaCuenta').html(params['idt']+' + <input type="text" id="cuenta" name="cuenta" style="width:20px;height:15px" maxlength="2">');
  
  $(document).renderme('ctp');

  $("#editaCuenta").submit(function(event)
  { 
  	event.preventDefault();
	var arr = 
	  {
	    token:sessionStorage.getItem('token'),
	    body:
	    {
	      mongoid:params["idm"],
	      id_copropiedad : sessionStorage.getItem('cp'),
	      tipo_documento:"puc",
	      base:params["base"],
	      cuenta:params["idt"],
	      nombre:$("#nombreCuenta").val(),
	    }
	  }; 
	  var datos = envioFormularioSync("contabilidad/puc", arr,"PUT");
	  if(datos)
	  {
	  	var pagina="modificar-puc.php";
        setTimeout(refreshWindow(pagina),1000);
	  }

	});
});