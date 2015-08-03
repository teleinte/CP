$(document).ready(function(){
	$(document).renderme('co');
	//$("#selcopropiedades").prop('disabled', true);
	$('.selector-copropiedad').html("<span class=titulo-cop><strong>"+ sessionStorage.getItem('ncp') +"</strong></span>");
    var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
	  '.chosen-select-creation'  : {create_option: true, skip_no_results: true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'No se encuentra'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
    $('#Activo_Pasivo').append(FormatearCategoriasContables());
    $('#cuenta_ingreso').append(FormatearCategoriasContables());
    var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
    var arr = { 
      token:sessionStorage.getItem('token'),body:
      {
        id_copropiedad:sessionStorage.getItem('cp'),
        id:params['idt']
      }};
    var datos = traerDatosSync("contabilidad/obtener/cargosid", arr);
    traerCargosModificable(datos);


$("#modificarCargo").submit(function(event){
    event.preventDefault();
    var ParamFecha=fecha();
    //  crear el inmueble de la copropiedad
    $('input[type=submit]').attr('disabled',true);

	var arr = 
	  {
	    token:sessionStorage.getItem('token'),
	    body:
	    {
	      
	      id_copropiedad : sessionStorage.getItem('cp'),
	      id:params['idt'],
	      tipo_documento: "cargos_"+sessionStorage.getItem('cp'),
	      estado: 1,
	      cargo: $("#cargo").val(),
	      Activo_Pasivo: $("#Activo_Pasivo").val(),
	      cuenta_ingreso: $("#cuenta_ingreso").val(),
	      identificador:$("#indicesfinales").val()
	    }
	  };
	  //alert(JSON.stringify(arr));
	  var result=envioFormularioSync("contabilidad/modificarbancos/",arr,'POST');

	  if(result)
	  {
		var pagina="cargos.php";
    	setTimeout(refreshWindow(pagina),1000);  	
	  }
    
  });

$("#eliminarCargo").submit(function(event){
    event.preventDefault();
    var ParamFecha=fecha();
    //  crear el inmueble de la copropiedad
    $('input[type=submit]').attr('disabled',true);

    if($("#opcion").val()=='no')
	  {
	      var pagina="cargos.php";
    	  setTimeout(refreshWindow(pagina),1000); 
	      return;
	  }
	var arr = 
	  {
	    token:sessionStorage.getItem('token'),
	    body:
	    {
	      	
	      id_copropiedad : sessionStorage.getItem('cp'),
	      id:params['idt'],
	      tipo_documento: "cargos_"+sessionStorage.getItem('cp'),
	      estado: 2,
	      cargo: $("#cargo").val(),
	      Activo_Pasivo: $("#Activo_Pasivo").val(),
	      cuenta_ingreso: $("#cuenta_ingreso").val(),
	      identificador:$("#indicesfinales").val()
	    }
	  };
	  //alert(JSON.stringify(arr));
	  var result=envioFormularioSync("contabilidad/modificarbancos/",arr,'POST');

	  if(result)
	  {
		var pagina="cargos.php";
    	setTimeout(refreshWindow(pagina),1000);  	
	  }
  });
	$(document).renderme('co');
});




















