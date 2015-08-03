$(document).ready(function(){
	//alert('encontre');
	var d = fecha();
	$('#datepicker2').attr('title', obtenerTerminoLenguage('val','11'));
	$('#datepicker3').attr('title', obtenerTerminoLenguage('val','11'));
	$('#datepicker4').attr('title', obtenerTerminoLenguage('val','11'));
	$('#odestinatario').attr('title', obtenerTerminoLenguage('val','12'));
	$('#datepicker2').removeAttr('min');
	$('#datepicker3').removeAttr('min');
	$('#datepicker4').removeAttr('min');
	$('#nombre').attr('title', obtenerTerminoLenguage('val','14'));
	
	$(document).renderme('tar');

	var elem = JSON.parse(sessionStorage.getItem("acelem"));
	if(elem['tipo'] == "tarea")
	{
		$("#mongoid").val(elem['id']);
		$("#fecha_creacion").val(elem['fecha_creacion']);
		$('#nombre').val(elem['nombre']);
		$('#estado').val(elem['estado']);
		$('#datepicker2').val(elem['deadline'].split('COT')[0]);
		$('#notas').val(elem['notas']);
		$('#frecuencia').val(elem['frecuencia']);
		$('#comongoid').val(elem['id']);
		$('#cocreacion').val(elem['fecha_creacion']);
		$('#conombre').val(elem['nombre']);
		$('#codeadline').val(elem['deadline'].split('COT')[0]);
		$('#cofrecuencia').val(elem['frecuencia']);
		$('#conotas').val(elem['notas']);
	}
	else
	{
		fechainicio = elem['fecha_inicio'].split("T")[0];
		fechafin = elem['fecha_fin'].split("T")[0];
		horainicio = elem['fecha_inicio'].split("T")[1].replace("+00:00",'');
		horainicio = horainicio.replace(":00:00",":00").replace(":30:00",":30");
		horafin = elem['fecha_fin'].split("T")[1].replace("+00:00",'');
		horafin = horafin.replace(":00:00",":00").replace(":30:00",":30");;

		$("#mongoid").val(elem['id']);
		$("#fecha_creacion").val(elem['fecha_creacion']);
		$('#nombree').val(elem['nombre']);
		$('#datepicker3').val(fechainicio);
		$('#datepicker4').val(fechafin);
		$('#starttimee').val(horainicio);
		$('#endtimee').val(horafin);
		$('#invitados').val(elem['compartir_invitados']);
		$('#odestinatario').val(elem['compartir_otros']);
		$('#frecuenciae').val(elem['frecuencia']);
		$('#ver_copropiedade').val(elem['cal_copropiedad']);
		$('#notase').val(elem['notas']);
	}


	$('#error').dialog({
		resizable: false,
		autoOpen: false,
		width: 400,
		title: obtenerTerminoLenguage('cl','35'),
		buttons:{
			"Aceptar" : function(){
				$(this).dialog("close");
			}
		}
	});
	

	$("#tarea_editar_form").submit(function(event){
		//alert('entro');
		event.preventDefault();
		$('input[type=submit]').attr('disabled',true);
        var arr = 
		    {
		      token:sessionStorage.getItem('token'),
		      body:
		      {
		        id:$("#comongoid").val(),
		        id_copropiedad : sessionStorage.getItem('cp'),
		        creador: sessionStorage.getItem('id_crm'),
		        fecha_creacion:$("#cocreacion").val(),
		        tipo: 'tarea',
		        nombre:$('#nombre').val(),
		        estado:$('#estado').val(),
		        fecha_fin:"",
		        deadline:$('#datepicker2').val(),
		        notas:$('#notas').val(),
		        frecuencia:$('#frecuencia').val()
		      }
		    }; 
		    //alert(JSON.stringify(arr));
        var url = "tareas/list";
		var response = envioFormularioSync(url,arr,'PUT');
		if(response)
		{
		  setTimeout(refreshWindow(sessionStorage.getItem('referer')),1000);
		}
		else
		{
		  $("#alertas").html('<div class="alert alert-dismissable alert-error" teid="ale:html:11"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:1"></strong></div>');
		  $(document).renderme('cl');
		}
	});
	
	$("#evento_editar_form").submit(function(event){
		event.preventDefault();
		if($("#odestinatario").val() == "" && $("#invitados").val() == "ninguno")
		{
			$("#error").html(obtenerTerminoLenguage('cl','36'));
			$("#error").dialog('open');
		}
		else
		{
			var inicio = $("#datepicker3").val() + "T" + $("#starttimee").val() + ":00";
			var fin = $("#datepicker4").val() + "T" + $("#endtimee").val() + ":00";
			
			eventoEdit($("#mongoid").val(),$("#fecha_creacion").val(),$("#nombree").val(),inicio,fin,$("#invitados").val(),$("#odestinatario").val(),$("#frecuenciae").val(),$("#ver_copropiedade").val(),$("#notase" ).val());
		}
	});

	$("#cancelar").click(function(){window.location = sessionStorage.getItem('referer')});

	$("#completar_tarea_calendario").click(function(){
	  $("#dialog_completar").dialog("open");
	});

	$("#btnr_eliminar_evento").click(function()
	{
		$("#dialog_eliminare").dialog("open");
		/*var inicio = $("#datepicker3").val() + "T" + $("#starttimee").val() + ":00";
		var fin = $("#datepicker4").val() + "T" + $("#endtimee").val() + ":00";
		eventoDelete($("#mongoid").val(),$("#fecha_creacion").val(),$("#nombree").val(),inicio,fin,$("#invitados").val(),$("#odestinatario").val(),$("#frecuenciae").val(),$("#ver_copropiedade").val(),$("#notase" ).val());*/
	});
	$("#dialog_eliminare").dialog(
	{
	    resizable: false,
	    autoOpen: false,
	    width: 400,
	    modal: true,
	    title: obtenerTerminoLenguage('tar','39'),
	    buttons:
	    {
	      "Cancelar" : function()
	      {
	        $(this).dialog("close");
	      },
	      "Aceptar" : function()
	      {
	        var inicio = $("#datepicker3").val() + "T" + $("#starttimee").val() + ":00";
			var fin = $("#datepicker4").val() + "T" + $("#endtimee").val() + ":00";
			eventoDelete($("#mongoid").val(),$("#fecha_creacion").val(),$("#nombree").val(),inicio,fin,$("#invitados").val(),$("#odestinatario").val(),$("#frecuenciae").val(),$("#ver_copropiedade").val(),$("#notase" ).val());
			console.warn($("#mongoid").val(),$("#fecha_creacion").val(),$("#nombree").val(),inicio,fin,$("#invitados").val(),$("#odestinatario").val(),$("#frecuenciae").val(),$("#ver_copropiedade").val(),$("#notase" ).val());

	        $(this).dialog("close");
	      }
	    }
	});
	 $(".btnr_eliminar_tarea").click(function()
	 {
    	$("#dialog_eliminar").dialog("open");
     });
	$("#dialog_eliminar").dialog({
    resizable: false,
    autoOpen: false,
    width: 400,
    modal: true,
    title: obtenerTerminoLenguage('tar','39'),
    buttons:{
      "Cancelar" : function(){
        $(this).dialog("close");
      },
      "Aceptar" : function(){
        tareaDelete($("#comongoid").val(),$("#cocreacion").val(),$("#conombre").val(),$("#codeadline").val(),$("#cofrecuencia").val(),$("#conotas").val());
        $(this).dialog("close");
        //alert($("#comongoid").val(),$("#cocreacion").val(),$("#conombre").val(),$("#codeadline").val(),$("#cofrecuencia").val(),$("#conotas").val());
      }
    }
  });

	$('#dialog_completar').dialog({
	  resizable: false,
	  autoOpen: false,
	  width: 400,
	  modal: true,
	  title: obtenerTerminoLenguage('tar','39'),
	  buttons:{
	    "Cancelar" : function(){
	      $(this).dialog("close");
	    },
	    "Aceptar" : function(){
	      tareaCompletar($("#comongoid").val(),$("#cocreacion").val(),$("#conombre").val(),$("#codeadline").val(),$("#cofrecuencia").val(),$("#conotas").val());
	      $(this).dialog("close");
	    }
	    
	  }
	});
	$(".ttip").addClass("tooltip-boton");

    $( ".tooltip-boton[title!='']" ).qtip(
    {
      position: 
      {
        my: 'top center',
            at: 'bottom center',
            viewport: $(window), //para correr el tooltip si no cabe en la pantalla
        adjust: 
        {
          method: 'flip invert' //método de ajuste si no cabe en la pantalla
        }
      },
      style: 
      {
            tip: 
            {
                corner: false
            }
       }
    });
	$(document).renderme('tar');
});