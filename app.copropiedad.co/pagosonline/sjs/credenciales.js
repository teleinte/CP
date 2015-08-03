$(document).ready(function(){

  $(document).renderme('pa');
  $(document).renderme('ale');

  	// Proceso para traer los datos de los inmuebles creados
  	var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
	var arr = 
    {
      token:sessionStorage.getItem('token'),
      body:
      {
        id_copropiedad:sessionStorage.getItem('cp'),
      }
    };  
    var datos = traerDatosSync("payu/consulta/copropiedad/pagosonline", arr);
    popularCredenciales(datos);

    $("#pagos_info_form").submit(function(event)
    {
	    event.preventDefault();
	    $('input[type=submit]').attr('disabled',true);
	    var ParamFecha=fecha();
	    var arr = 
        {
          token:sessionStorage.getItem('token'),
          body:
          {
            id_copropiedad : sessionStorage.getItem('cp'),
            id_pago: Number(sessionStorage.getItem('id_crm'))+100000,
            id_crm_persona: sessionStorage.getItem('id_crm'),
            fecha_last_change:ParamFecha,
            nombre:$('#nombre').val(),                   
            apikey:$('#apikey').val(),
            apikey_login:$("#apikey_login").val(),
            llave_publica:$("#llave_publica").val(),
            merchantId:$("#merchantId").val(),
            accountId:$("#accountId").val()
          }
        };
        var url = "payu/copropiedad/pagosonline";
         //alert(JSON.stringify(arr));
        var metodo = '';
        if($('#tipo').val()==0)
        {
          metodo='POST';
        }
        else 
        {
        	metodo='PUT';
        }
	    var response = envioFormularioMessageSync(url,arr,metodo);
      console.warn(response);
	    if(response.status)
	    {
        $(document).renderme('ma');
        var body = '<h3 style="color:#666 !important;">' +  obtenerTerminoLenguage('ma','44') + '</h3><h4 style="color:#666 !important;">' +  obtenerTerminoLenguage('ma','45') + '</h4><h4>' +  obtenerTerminoLenguage('ma','46') + '</h4>';
        $(document).renderme('ma');

        var to = sessionStorage.getItem('email').replace('cp-','');
        $(document).renderme('ma');
        var response = enviocorreoSync(to, obtenerTerminoLenguage('ma','47'), body, traerDireccion());
        $(document).renderme('ma');
        var response2 = enviocorreoSync("copropiedad.co@gmail.com",obtenerTerminoLenguage('ma','48'), JSON.stringify(arr), traerDireccion());
        $(document).renderme('ma');

        if(response && response2)
	       setTimeout(refreshWindow('index.php'),1000);
       else
          $("#alertas").html('<div class="alert alert-dismissable alert-error" teid="ale:html:3"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:1"></strong></div>');
	    }
	    else
	    {
        $(document).renderme('ale');
	      $("#alertas").html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:1"></strong><span id="alertapagos"></span></div>');
        //console.warn(response.message);
        if(response.message == "ingresadas" )
          $("#alertapagos").html(obtenerTerminoLenguage('pa','64'));
        else
          $("#alertapagos").html(obtenerTerminoLenguage('ale','3'));

        $('input[type=submit]').attr('disabled',false);
        $(document).renderme('ale');
	    }
	});
	$(document).renderme('pa');
	$(document).renderme('ale');
});