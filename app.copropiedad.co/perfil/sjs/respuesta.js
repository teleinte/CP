$(document).ready(function()
    {
    	$(document).renderme('pa');

      $("#alertas").html('<div class="alert alert-dismissable alert-info"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong>Información: </strong> La(s) nueva(s) vigencia(s) en su(s) copropiedad(es) se verán reflejada(s) antes de 24 horas a partir de esta confirmación. </div>');
      
	    $("#btnprint").click(function()
	    {
	        $("#consolidado-print").prepend('<div class="logo" id="printlogo" style="width:100%; height:70px;"><h1 style="display:inline-block; float:left; width:500px; margin:30px 0px 0px 20px;" teid="pa:html:41"></h1><div style="width:350px; margin: 0px auto;"><h2 teid="pa:html:18"></h2><table><tr><td teid="pa:html:19"></td><td>'+$('#estadoTx').html()+'</td></tr><tr><td teid="pa:html:20"></td><td>'+$('#transactionId').html()+'</td></tr><tr><td teid="pa:html:21"></td><td>'+$('#reference_pol').html()+'</td></tr><tr><td teid="pa:html:22"></td><td>'+$('#referenceCode').html()+'</td></tr><tr><td teid="pa:html:25">Valor total</td><td>$'+$('#TX_VALUE').html()+'</td></tr><tr><td teid="pa:html:26"></td><td>'+$('#currency').html()+'</td></tr><tr><td teid="pa:html:27"></td><td>'+$('#extra1').html()+'</td></tr><tr><td teid="pa:html:28"></td><td>'+$('#lapPaymentMethod').html()+'</td></tr></table></div></div><div style="clear:both;></div>"');
	       	$(document).renderme('pa');
	        $("#consolidado-print").print();

	    });
  		$(document).renderme('pa');
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