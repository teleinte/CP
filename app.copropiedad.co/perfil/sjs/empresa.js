$(document).ready(function(){
	$(document).renderme("pe");

	var update = traerDatosEmpresa();
	//console.log(update);
	
	$("#empresa_form").submit(function(event){
		event.preventDefault();
		$('input[type=submit]').attr('disabled',true);
		if(!update)
		{
			var arr = 
			{
			  token:sessionStorage.getItem('token'),
			  body:
			  {
			  	id_copropiedad: sessionStorage.getItem('cp'),
			    tipo_documento:'infoempresa',
			    nombre_empresa : $('#nombre_empresa').val(),
			    nit : $('#nit').val(),
			    direccion : $('#direccion').val(),
			    ciudad : $('#ciudad').val(),
			    telefono : $('#telefono').val(),
			    sitio_web : $('#sitio_web').val(),
			    email : $('#email').val(),
			    regimen : $('#regimen').val(),
			    logo : $('#filepath').val()
			  }
			};
			//console.warn(arr);
			var url = "contabilidad/infoempresa";
			var response = envioFormularioSync(url,arr,'POST');
			//console.warn(response);
		}
		else
		{
			var arr = 
			{
			  token:sessionStorage.getItem('token'),
			  body:
			  {
			  	idcopropiedad: sessionStorage.getItem('cp'),
			  	id:$("#mongoid").val(),
			    tipo_documento:'infoempresa',
			    nombre_empresa : $('#nombre_empresa').val(),
			    nit : $('#nit').val(),
			    direccion : $('#direccion').val(),
			    ciudad : $('#ciudad').val(),
			    telefono : $('#telefono').val(),
			    sitio_web : $('#sitio_web').val(),
			    email : $('#email').val(),
			    regimen : $('#regimen').val(),
			    logo : $('#filepath').val()
			  }
			};
			var url = "contabilidad/infoempresa/edit/";
			var response = envioFormularioSync(url,arr,'PUT');
		}
		if(response)
    	{
    	  setTimeout(refreshWindow(traerDireccion() + 'inicio/'),1000);
    	}
    	else
    	{
    	  $("#alertas").html('<div class="alert alert-dismissable alert-error" teid="ale:html:16"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:1"></strong></div>');
    	}
	});
	
	$("#cancelar").click(function(){
		window.location = traerDireccion() + "inicio/";
	});

	$(document).renderme("pe");
	$(".ttip").addClass("tooltip-boton");

    $( ".tooltip-boton[title!='']" ).qtip({
      position: {
        my: 'top center',
            at: 'bottom center',
            viewport: $(window), //para correr el tooltip si no cabe en la pantalla
        adjust: {
          method: 'flip invert' //método de ajuste si no cabe en la pantalla
        }
          },
      style: {
            tip: {
                corner: false
            }
        }
    });
});