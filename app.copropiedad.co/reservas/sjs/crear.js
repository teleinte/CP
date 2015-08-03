$(document).ready(function(){
    $(document).renderme('re');
	$("#unidad_form").submit(function(event){
		event.preventDefault();
		$('input[type=submit]').attr('disabled',true);
		var dias = new Array();
        if($("#lunes").is(":checked"))
            dias.push(parseInt($("#lunes").val()));
        if($("#martes").is(":checked"))
            dias.push(parseInt($("#martes").val()));
        if($("#miercoles").is(":checked"))
            dias.push(parseInt($("#miercoles").val()));
        if($("#jueves").is(":checked"))
            dias.push(parseInt($("#jueves").val()));
        if($("#viernes").is(":checked"))
            dias.push(parseInt($("#viernes").val()));
        if($("#sabado").is(":checked"))
            dias.push(parseInt($("#sabado").val()));
        if($("#domingo").is(":checked"))
            dias.push(parseInt($("#domingo").val()));

        var arr = 
        {
			token:sessionStorage.getItem('token'),
			body:
			{
				id_copropiedad: sessionStorage.getItem("cp"),
				nombre: $("#nombre").val(),
				tiempo_reserva: $("#tiempo_reserva").val(),
				hora_inicio_reserva: $("#hora_inicio_reserva").val(),
				hora_fin_reserva: $("#hora_fin_reserva").val(),
				dias_reserva: dias.toString()
			}
        }

        var url = "reservas/reserva/inmueble/";
        var response = envioFormularioSync(url,arr,'POST');
        if(response)
        {
          setTimeout(refreshWindow('inmuebles-reservables.php'),1000);
        }
        else
        {
          $("#crearsolicitud").dialog("close");
          $("#alertas").html('<div class="alert alert-dismissable alert-error" teid="ale:html:21"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:1"></strong></div>');
          $(document).renderme('re');
        }
	});

	$("#semana").change(function(){
		if(this.checked)
		{
            $('.chkdias').each(function() { 
                this.checked = true;
            });
		}
		else
		{
			$('.chkdias').each(function() { 
			    this.checked = false;
			});
		}
	});

    $("#hora_fin_reserva").val("18:00");
    $("#hora_inicio_reserva").val("06:00");

    $("#cancelar").click(function(){window.location = 'inmuebles-reservables.php'});

	$(document).renderme('re');
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