$(document).ready(function(){
//$("#selcopropiedades").prop('disabled', true);
$('.selector-copropiedad').html("<span class=titulo-cop><strong>"+ sessionStorage.getItem('ncp') +"</strong></span>");
  var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
  $('#cuentaAnterior').html(params['idt']);
  $('#nuevaCuenta').html(params['idt']+' + <input type="text" id="cuenta" name="cuenta" style="width:35px;height:15px" maxlength="2" required>');
  
  $(document).renderme('ctp');

  $("#crearCuenta").submit(function(event)
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
	      cuenta:params["idt"]+$("#cuenta").val(),
	      nombre:$("#nombreCuenta").val(),
	      editar : true,
	      agregar : true,
	    }
	  };
	  var datos = envioFormularioMessageSync("contabilidad/creaCuenta", arr,"PUT");
	  
	  $.each(datos, function(a , b)
      {
      	if(a=="error" && b=="error")
      	{
      		$('#alertas').html('<div class="alert alert-dismissable alert-error" style="height:10px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>la cuenta ya existe en el PUC.</div>');
			return false;      	
		}
      	else if(a=="error" && b=="null")
      	{      		
      		var pagina="modificar-puc.php";
   		    setTimeout(refreshWindow(pagina),1000);	
      	}
      });
	});




});



