$(document).ready(function(){

  	$(document).renderme('pa');

    var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
    var arr = {token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp')}};
    var datos = traerDatosSync("payu/pagosonline/listar/pago_nuevo/", arr);
    
    if(datos)
    {
      var arr = {token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp')}};
      var datos1 = traerDatosSync("payu/consulta/copropiedad/pagosonline/", arr);
      //alert(JSON.stringify(datos1));
      popularCredenciales(datos1);
       $(".niveldos").hide();
       $(document).renderme('pa');

       // Proceso para traer los datos de los inmuebles creados

      	var refref='CC'+ Math.floor(Math.random()*1000000000000000000000);
      	$('#mostrarNom').html(sessionStorage.getItem('nombreCompleto'));
    	  $('#mostrarCop').html(sessionStorage.getItem('ncp'));
    	  $('#buyerEmail').val(sessionStorage.getItem('email').split('cp-')[1]);

     	  $("#pagos_form").submit(function(event)
      	{	
    	    $('input[type=submit]').attr('disabled',true);

    		  $("#referenceCode").val(hex_md5(refref));
    		
    	    var calculo=calcularImpuestos(16,$("#amount").val(),true);
    	  	$("#tax").val(0);
    	  	$("#taxReturnBase").val(0);
    	  	//$("#taxReturnBase").val(calculo[0]);

    	  	var ParamFecha=fecha();
    	  	var cpp= $('#apikey').val();
    	  	//var cpp= "170vp0cv81qjt3i8jslpjbunn6";
    	  
    	  	var sstring=cpp+"~"+$("#merchantId").val()+"~"+$("#referenceCode").val()+"~"+$("#amount").val()+"~"+$('#currency').val();
    	  	//alert(sstring);
    	  	$("#signature").val(hex_md5(sstring));

    	    //ARMA PAQUETE QUE SE ENVIA A BD
            var arr = 
            {
                token:sessionStorage.getItem('token'),
                body:
                { 
                  fecha_creacion:ParamFecha,
                  id_copropiedad :sessionStorage.getItem('cp'),
                  id_crm_persona:sessionStorage.getItem('id_crm'),
                  estado:'Pendiente',
                  merchantId:$('#merchantId').val(),
                  apikey:cpp,
                  accountId:$('#accountId').val(),
                  amount:$('#amount').val(),
                  buyerEmail:$('#buyerEmail').val(),
                  referenceCode:$('#referenceCode').val(),
                  description:$('#description').val(),
                  tax:$('#tax').val(),
                  signature:$('#signature').val(),                        
                  currency:$('#currency').val(),
                  test:$('#test').val(),
                  lng:$('#lng').val(),
                  responseUrl:$('#responseUrl').val(),
                  doc: $('#mostrarUni').html(),
                  confirmationUrl:$('#confirmationUrl').val()
                }
            };
          var url = "payu/pagar";
          var response = envioFormularioSync(url,arr,'POST');
          envioFormularioSync(url,arr,'POST')
          if(response)
          {
            //setTimeout(refreshWindow('index.php'),1000);
          }
          else
          {
            $("#alertas").html('<div class="alert alert-dismissable alert-error" "ale:html:2"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:1"></strong></div>');
          $(document).renderme('pa');
          }                
          popularTabla(datos);

        });
    }
    else
    {
      $(document).renderme('pa');
      $(".botones-form").hide();
      $(".aplicaciones").show();
      $("#contenido").hide();
      $("#alertas").html('<div class="alert alert-dismissable alert-info" ><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:28"></strong><h4>Podrá acceder en poco tiempo a este modulo. Su administrador ya empezó con el proceso de habilitar el módulo de pagos en línea para su copropiedad.</h4></div> ');
      $(document).renderme('pa');
    }
	$(document).renderme('ale');
  	$(document).renderme('pa');
});