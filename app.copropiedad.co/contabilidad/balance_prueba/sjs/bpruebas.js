$(document).ready(function(){
	$(document).renderme('co');
	$('.selector-copropiedad').html("<span class=titulo-cop><strong>"+ sessionStorage.getItem('ncp') +"</strong></span>");
	//$("#selcopropiedades").prop('disabled', true);
	var today = new Date();
	
	t = Number(today.getMonth()) + 1;
	r = Number(today.getMonth()) + 2;
		if(t < 10)
			t = String("0") + t;
		if(r < 10)
			r = String("0") + r;
	$("#mesi").val(String(t));
	$("#mesf").val(String(r));
	
    $("#generar").click(function(){    	
      var link ="informes/index.php?id=" + btoa(sessionStorage.getItem('token') + "^p^" + sessionStorage.getItem('cp') + "^" + traerDireccion() + "^"+$("#nivel").val()+"^pdf^" + sessionStorage.getItem('ncp') + "^" + $("#mesi").val() + "^" + $("#anoi").val() + "^" + $("#mesf").val() + "^" + $("#anof").val());
      window.open(link,'_blank');
 	});
 	$(document).renderme('co');
});