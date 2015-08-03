$(document).ready(function(){
	$(document).renderme('cl');
	$('#datepicker2').attr('title', obtenerTerminoLenguage('val','11'));
	$('#datepicker3').attr('title', obtenerTerminoLenguage('val','11'));
	$('#datepicker4').attr('title', obtenerTerminoLenguage('val','11'));
	$('#odestinatario').attr('title', obtenerTerminoLenguage('val','12'));
	$('#nombre').attr('title', obtenerTerminoLenguage('val','14'));
	$(document).renderme('cl');
	startdate = sessionStorage.getItem('new-eventStart');
	enddate = sessionStorage.getItem('new-eventEnd');

	if(enddate == null)
	  enddate = startdate;

	var d = fecha();

	$("#datepicker2").val(startdate.split("T")[0]);
	//$("#datepicker2").attr('min',d.split('T')[0]);
	$("#datepicker3").val(startdate.split("T")[0]);
	$("#datepicker3").attr('min',d.split('T')[0]);
	$("#datepicker4").val(enddate.split("T")[0]);
	$("#datepicker4").attr('min',d.split('T')[0]);
	$("#starttimee").val(startdate.split("T")[1].replace(":00+00:00",""));
	$("#endtimee").val(enddate.split("T")[1].replace(":00+00:00",""));
	$("#cancelarcreacion").click(function(){window.location = "index.php";});

	$('#error').dialog({
		resizable: false,
		autoOpen: false,
		width: 400,
		title: obtenerTerminoLenguage('cl','35'),
		buttons:{
			'Aceptar' : function(){
				$(this).dialog("close");
			}
		}
	});
	$(document).renderme('tar');

	$("#tarea_crear_form").submit(function(event){
		event.preventDefault();
		$('input[type=submit]').attr('disabled',true);
		var arr = 
                    {
                      token:sessionStorage.getItem('token'),
                      body:
                      {
                        id_copropiedad : sessionStorage.getItem('cp'),
                        creador: sessionStorage.getItem('id_crm'),
                        fecha_creacion:fecha(),
                        tipo:"tarea",
                        nombre:$('#nombre').val(),
                        estado:"por iniciar",
                        fecha_fin:"",
                        deadline:$('#datepicker2').val(),
                        notas:$('#notas').val(),
                        frecuencia:$('#frecuencia').val()
                      }
                    };
                    //console.log(arr);
        var url = "tareas/list";
		var response = envioFormularioSync(url,arr,'POST');
		if(response)
		{
			var ref = sessionStorage.getItem('referer');
		 	setTimeout(refreshWindow(ref),1000);
		}
		else
		{
		  $("#alertas").html('<div class="alert alert-dismissable alert-error" teid="ale:html:11"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:1"></strong> </div>');
		  $(document).renderme('cl');
		}
	});

	$("#evento_crear_form").submit(function(event){
		event.preventDefault();
		if($("#odestinatario").val() == "" && $("#invitados").val() == "ninguno")
		{
			$("#error").html(obtenerTerminoLenguage('cl','36'));
			$("#error").dialog('open');
		}
		else
		{
			$('input[type=submit]').attr('disabled',true);
			var starttime_final = $('#datepicker3').val() + "T" + $('#starttimee').val() + ":00+00:00";
	        var endtime_final = $('#datepicker4').val() + "T" + $('#endtimee').val() + ":00+00:00";

	        var arr = 
	        {
	          token:sessionStorage.getItem('token'),
	          body:
	          {
	            id_copropiedad : sessionStorage.getItem('cp'),
	            creador: sessionStorage.getItem('id_crm'),
	            fecha_creacion:fecha(),
	            tipo:"evento",
	            nombre:$('#nombree').val(),
	            estado:"Por Iniciar",
	            fecha_inicio:starttime_final,
	            fecha_fin:endtime_final,
	            compartir_invitados:$('#invitados').val(),
	            compartir_otros:$('#odestinatario').val(),                  
	            frecuencia:$('#frecuenciae').val(),
	            cal_copropiedad:$("#ver_copropiedade").val(),
	            notas:$('#notase').val()
	          }
	        }; 
	        var url = "eventos/evento/";
	        var response = envioFormularioSync(url,arr,'POST');
	        if(response)
	        {
	        	var arre = 
	        	{
	        	  token:sessionStorage.getItem('token'),
	        	  body:
	        	  {
	        	    idcopropiedad : sessionStorage.getItem('cp'),
	        	    grupo: $('#invitados').val()
	        	  }
	        	}; 
	        	var invitados = $('#invitados').val();
	        	$(document).renderme('ma');
    			var body = '<h4 style="color:#666 !important;">'+ sessionStorage.getItem('nombreCompleto') + obtenerTerminoLenguage('ma','1') + sessionStorage.getItem('ncp')+ obtenerTerminoLenguage('ma','30') +$('#nombree').val() +'.</h4><ul style="color:#666 !important;"><li>'+obtenerTerminoLenguage('ma','3')+$('#datepicker3').val()+'</li><li>'+obtenerTerminoLenguage('ma','24')+$('#datepicker4').val()+'</li><li>'+obtenerTerminoLenguage('ma','4')+$('#starttimee').val()+'</li><li>'+obtenerTerminoLenguage('ma','25')+$('#endtimee').val()+'</li></ul></p>';
    			$(document).renderme('ma');
	        	if($("#odestinatario").val().length > 10)   		
	        	{
	        		$(document).renderme('ma');
	        		//enviocorreoAsync($('#odestinatario').val(),  sessionStorage.getItem('nombreCompleto')+ obtenerTerminoLenguage('ma','7') + sessionStorage.getItem('ncp') + obtenerTerminoLenguage('ma','8')+ $('#nombree').val(), body, traerDireccion());
	        		enviocorreoSync($('#odestinatario').val(), obtenerTerminoLenguage('ma','53'), body, traerDireccion());
	        		$(document).renderme('ma');
	        	}
		        if(invitados != 'ninguno')
		        {
	        		var correos = "";
		        	var urle = "eventos/usuario/grupo/";
		        	var responsee = traerDatosSync(urle,arre,'POST');
		        	if(responsee!=null)
		        	{
		        		$.each(responsee,function(k,v)
			        	{
			        		correos = correos + "," + v;
			        	});
			        	$(document).renderme('ma');
			        	//enviocorreoSync(correos.substring(1), sessionStorage.getItem('nombreCompleto')+ obtenerTerminoLenguage('ma','7') + sessionStorage.getItem('ncp') + obtenerTerminoLenguage('ma','8')+ $('#nombree').val(), body, traerDireccion());
			        	enviocorreoSync(correos.substring(1), obtenerTerminoLenguage('ma','53'), body, traerDireccion());
			        	$(document).renderme('ma');
		        	}
		        }
	        	//var responsee = envioFormularioMessageSync(urle,arre,'POST');
	        	//console.warn(responsee);
	          	setTimeout(refreshWindow('index.php'),2000);
	        }
	        else
	        {
	          $("#alertas").html('<div class="alert alert-dismissable alert-error" teid="ale:html:7"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:1"></strong> </div>');
	          $(document).renderme('cl');
	        }
		}
	});
$(document).renderme('cl');
});