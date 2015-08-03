$(document).ready(function(){
	$(document).renderme('co');
	var today = new Date();
	$('.selector-copropiedad').html("<span class=titulo-cop><strong>"+ sessionStorage.getItem('ncp') +"</strong></span>");
	//$("#selcopropiedades").prop('disabled', true);
	t = Number(today.getMonth()) + 1;
	r = Number(today.getMonth()) + 2;
		if(t < 10)
			t = String("0") + t;
		if(r < 10)
			r = String("0") + r;
	s = Number(today.getFullYear());
	$("#mesi").val(String(t));
	$("#mesf").val(String(r));
	
    $("#generar").click(function(){    	
      var link ="informes/index.php?id=" + btoa(sessionStorage.getItem('token') + "^r^" + sessionStorage.getItem('cp') + "^" + traerDireccion() + "^"+$("#nivel").val()+"^pdf^" + sessionStorage.getItem('ncp') + "^" + $("#mesi").val() + "^" + $("#anoi").val() + "^" + $("#mesf").val() + "^" + $("#anof").val());
      window.open(link,'_blank');
 	});
 	$(document).renderme('co');
});