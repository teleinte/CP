function popularTablaEncuestas(datos)
{
	if(datos.length > 0)
		$.each(datos, function(x , y){
		    var idmongo= JSON.stringify(y['_id']);
		    var idMongoFinal = JSON.parse(idmongo);
		    var t = $('#encuestasTabla').DataTable();
            //tabla de estados 1. creada sin enviar, 2. creada enviada, 3. eliminada, 
            var arr = {token:sessionStorage.getItem('token'),body:{id_encuesta:idMongoFinal.$id}};            
            var response = traerDatosSync("encuestas/encuesta/VotantesTotales",arr);
            var resultadoContestadas = traerElectoresTabla(response);
            //alert(resultadoContestadas);
           var arr = {token:sessionStorage.getItem('token'),body:{id_encuesta:idMongoFinal.$id}};
           var url = "encuestas/encuesta/VotantesFaltantes/";
           var llegada = envioFormularioMessageSync(url,arr,'POST');           
           var numeroPendientes=0;           
           if(llegada)
           {
               $.each(llegada, function(x , y)
               {
                 if(x=="message" && (y!= "" || y!=0))
                 {
                   $.each(y, function(alfa , beta)
                   {   
                       numeroPendientes++;
                   });
                 }
               }); 
           }
            if(y['estado']=="1")
            {
                if(resultadoContestadas==0)
                {
                    var enlace = '<a class="btn borrar solo inline ttip" teid="en:title:11" href="encuesta-borrar.php?idt='+idMongoFinal.$id+'"></a><a class="btn enviar solo inline ttip" teid="en:title:9" id="open-enviar-encuesta" href="enviar-encuesta.php?idt='+idMongoFinal.$id+'"></a><a class="btn editar solo inline ttip" teid="en:title:8" href="encuesta-editar.php?idt='+idMongoFinal.$id+'"></a>';    
                }
                else
                {
                    var enlace = '<a class="btn borrar solo inline ttip" teid="en:title:11" href="encuesta-borrar.php?idt='+idMongoFinal.$id+'"></a><a class="btn resultados solo inline ttip" teid="en:title:10" href="resultado-encuesta.php?idt='+idMongoFinal.$id+'"></a><a class="btn enviar solo inline ttip" teid="en:title:9" id="open-enviar-encuesta" href="enviar-encuesta.php?idt='+idMongoFinal.$id+'"></a><a class="btn editar solo inline ttip" teid="en:title:8" href="encuesta-editar.php?idt='+idMongoFinal.$id+'"></a>';
                }                
            }
            if(y['estado']=="2")
            {
                if(numeroPendientes==0)
                {
                    var enlace = '<a class="btn resultados solo inline ttip" teid="en:title:10" href="resultado-encuesta.php?idt='+idMongoFinal.$id+'"></a><a class="btn enviar solo inline ttip" teid="en:title:9" id="open-enviar-encuesta" href="enviar-encuesta.php?idt='+idMongoFinal.$id+'"></a>';
                }
                else if(resultadoContestadas==0)
                {
                    var enlace = '<a class="btn enviar solo inline ttip" teid="en:title:9" id="open-enviar-encuesta" href="enviar-encuesta.php?idt='+idMongoFinal.$id+'"></a><a class="btn regresar solo inline ttip" id="open-enviar-encuesta" teid="en:title:9" href="enviar-encuesta-recordatorio.php?idt='+idMongoFinal.$id+'"></a>';    
                }
                else
                {
                    var enlace = '<a class="btn resultados solo inline ttip" teid="en:title:10" href="resultado-encuesta.php?idt='+idMongoFinal.$id+'"></a><a class="btn enviar solo inline ttip" teid="en:title:9" id="open-enviar-encuesta" href="enviar-encuesta.php?idt='+idMongoFinal.$id+'"></a><a class="btn regresar solo inline ttip" id="open-enviar-encuesta" teid="en:title:9" href="enviar-encuesta-recordatorio.php?idt='+idMongoFinal.$id+'"></a>';    
                }
            }
		        t.row.add([
		        '',                            
		        y['nombre'],
		        y['descripcion'],
		        y['fecha_fin'],
                resultadoContestadas,
                numeroPendientes,
                enlace
		    ] ).draw();		        
            $(document).renderme('en');                  
		});
}

function crearEncuesta()
{
	var arr = 
	    {
	        token:sessionStorage.getItem('token'),
	        body:
	        {
	            id_copropiedad:sessionStorage.getItem('cp'),
	            id_crm_persona:sessionStorage.getItem('id_crm'),
	            fecha_creacion:fecha(),
	            tipo:obtenerTerminoLenguage('en','29'),
	            fecha_fin:$('#datepicker').val(),
	            nombre:$('#nombre').val(),
	            descripcion:$('#descripcion').val(),
	            estado:"1",
	            invitados:"",
	            invitados_externos:""
	        }
	    };
	var url = "encuestas/encuesta";
	envioFormularioEncuestas(url,arr,'POST');
	var retornado;
	retornado=sessionStorage.getItem("insertado")
	var letras = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"];                
	for (j=0;j<20;j++)
	{                    
	    if (!$('#enunciado-pregunta'+j).val())
	    {
	        break;
	    }
	    var partido = [];
	    var arrPregunta={};
	    partido = $('#opciones-pregunta'+j).val().split("\n");
	    var resultado = "";
	    if($('#tipo-pregunta'+j).val()!="Abierta")
	    {
	        for (i in partido) 
	        {
	            resultado+=letras[i]+"|"+partido[i]+","                    
	        } 
	    }
	    var obligatorio;
	    if($('#obligatoria'+j).is(':checked')){
	        obligatorio=obtenerTerminoLenguage('en','30');
	    } else {                        
	        obligatorio=obtenerTerminoLenguage('en','31');
	    }
	    arrPregunta = 
	    {
	        token:sessionStorage.getItem('token'),
	        body:
	        {
	            id_encuesta:retornado,
	            pregunta:$('#enunciado-pregunta'+j).val(),
	            tipo:$('#tipo-pregunta'+j).val(),
	            opciones:resultado,
	            obligatorio:obligatorio
	        }
	    }
	    var url = "encuestas/encuesta/pregunta";
	    envioPregunta(arrPregunta,url,'POST');
	}
	notificador();
}
function envioFormularioEncuestas(arr,url,metodo,parametros)
{
        rutaAplicativo = traerDireccion()+"api/";
        $.ajax(
        {
            url: rutaAplicativo+url,
            type: metodo,
            data: JSON.stringify(arr),
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            async: false,
            success: function(msg) 
            {
                var msgDividido = JSON.stringify(msg);
                var mensaje =  JSON.parse(msgDividido);
                var msgDivididoDos = JSON.stringify(mensaje.message);
                if(mensaje.message=="Token invalido")
                {
                    $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>');
                    $(document).renderme('en'); 
                    window.location = '../../index.php';
                }
                if(mensaje.status)
                {
                    if(metodo=="PUT" || metodo=="DELETE")
                    {                        
                        $('#alertas').html('<div class="alert alert-dismissable alert-success" style="height:10px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Cambio satisfactorio.</div>');
                        $(document).renderme('en');                         
                        window.location='encuesta-editar.php?idt='+parametros["idt"];                        
                        return false;
                    }
                    else
                    {
                        $.each(mensaje.message, function(x , y) 
                        {
                            sessionStorage.setItem("insertado",y);
                        });
                    }
                }
                else {$('#resultado').html(mensaje.error);}
            }
        });
}


function traerCabecerasModificables(datos){
    //Consulta para cargar la Cabecera de la encuesta
    var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
    $.each(datos, function(x , y) {               
        var idmongo= JSON.stringify(y['_id']);
        var idMongoFinal = JSON.parse(idmongo);               
            if(idMongoFinal.$id==params['idt'])
        {
            $('#id_copropiedad').val(y['id_copropiedad']);
            $('#id_crm_persona').val(y['id_crm_persona']);
            $('#fecha_creacion').val(y['fecha_creacion']);
            $('#tipo').val(y['tipo']);
            $('#datepicker').val(y['fecha_fin']);
            $('#nombre').val(y['nombre']);
            $('#labelnombre').text(y['nombre']);
            $('#descripcion').val(y['descripcion']);
            $('#estado').val(y['estado']);
            $('#invitados').val(y['invitados']);
            $('#odestinatario').val(y['invitados_externos']);
        }                    
    })
}

function traerPreguntas(datos)
{
    $.each(datos, function(x , y) 
    {
        var idmongo= JSON.stringify(y['_id']);
        var idMongoFinal = JSON.parse(idmongo);
        var t = $('#tablaPreguntas').DataTable();
        var opciones=""
        if (y['tipo']=="abierta")
        { 
            opciones="";
        } 
        else 
        {                            
            for(i=0; i<y['opciones'].length; i++) 
            {
                opciones+=(y['opciones'].charAt(i)).replace("|",": ")
            }
        }
        if(y['tipo']==="seleccion_multiple_multiple_respuesta")
        {
            var tipejo=obtenerTerminoLenguage('en','20');
        }
        if(y['tipo']==="seleccion_multiple_unica_respuesta")
        {
            var tipejo=obtenerTerminoLenguage('en','19');
        }
        if(y['tipo']==="abierta")
        {
            var tipejo=obtenerTerminoLenguage('en','45');
        }
        t.row.add([
        '',                            
        y['pregunta'],
        tipejo,                        
        opciones,
        y['obligatorio'],
        '<a class="btn borrar solo inline ttip" teid="en:title:11" href="pregunta-borrar.php?idt='+idMongoFinal.$id+'"></a><a class="btn editar solo inline ttip" teid="en:title:8" href="pregunta-editar.php?idt='+idMongoFinal.$id+'"></a>'
        //'<a id="open-editarcopripiedad" class="btn editar solo inline" href="tarea-editar.php?idt='+idMongoFinal.$id+'"></a><a class="btn completar solo inline" href="tarea-completar.php?idt='+idMongoFinal.$id+'"></a><a class="btn borrar solo inline" href="tarea-eliminar.php?idt='+idMongoFinal.$id+'"></a>'
        ] ).draw();                        
        //$('#example tr:last').after('<tr><td>'+y['nombre']+'</td><td>'+y['direccion']+'</td><td>'+y['telefono']+'</td><td>'+y['nit']+'</td><td><a class="btn editar solo inline" href="copropiedad-editar.html?idt='+idMongoFinal.$id+'"></a><a class="btn borrar solo inline" href="copropiedad-eliminar.html?idt='+idMongoFinal.$id+'"></a></td></tr>')                        
    });
}

function traerPreguntasModificables(datos){
    //Consulta para cargar la Cabecera de la encuesta
    var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})  
    $.each(datos, function(x , y) {               
        var idmongo= JSON.stringify(y['_id']);
        var idMongoFinal = JSON.parse(idmongo);
        if(idMongoFinal.$id==params['idt'])
        {
            if(y['tipo']!="abierta")
            {
                var newStr = y['opciones'].substring(0, y['opciones'].length-1);
                var varios = newStr.split(",");
                var opciones="";
                for(i in varios)
                {                                    
                    var otro=varios[i].split("|");
                    opciones+="\n"+otro[1];
                }

                var opciones = opciones.replace("\n", "");                                
            }
            else
            {
                var opciones= "";
            }
            
            if (y['obligatorio']==obtenerTerminoLenguage('en','30')){ $('#obligatoria0').prop("checked","checked");}
            $('#id_encuesta').val(y['id_encuesta']);
            $('#enunciado_pregunta0').val(y['pregunta']);
            $('#nombremostrar').append(" "+y['pregunta']+"?");
            $('#tipo_pregunta0').val(y['tipo']);
            $('#opciones_pregunta0').val(opciones);
            $('#regresador').attr('href', 'encuesta-editar.php?idt='+y['id_encuesta']);                        
        }                    
    });
}


function traerDatosEliminables(datos){
    //Consulta para cargar la Cabecera de la encuesta
    var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
    $.each(datos, function(x , y) {               
        var idmongo= JSON.stringify(y['_id']);
        var idMongoFinal = JSON.parse(idmongo);               
        if(idMongoFinal.$id==params['idt'])
        {
            $('#id_copropiedad').val(y['id_copropiedad']);
            $('#id_crm_persona').val(y['id_crm_persona']);
            $('#fecha_creacion').val(y['fecha_creacion']);
            $('#tipo').val(y['tipo']);
            $('#fecha_fin').val(y['fecha_fin']);
            $('#nombre').val(y['nombre']);
            $('#nombremostrar').append(" "+y['nombre']+"?");
            $('#descripcion').val(y['descripcion']);
            $('#estado').val(y['estado']);
            $('#invitados').val(y['invitados']);
            $('#invitados_externos').val(y['invitados_externos']);
        }                    
    })
}

function traerCabecerasEnvio(datos){
    //Consulta para cargar la Cabecera de la encuesta
    var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
    $.each(datos, function(x , y) {               
        var idmongo= JSON.stringify(y['_id']);
        var idMongoFinal = JSON.parse(idmongo);               
        if(idMongoFinal.$id==params['idt'])
        {
            $('#id_copropiedad').val(y['id_copropiedad']);
            $('#id_crm_persona').val(y['id_crm_persona']);
            $('#fecha_creacion').val(y['fecha_creacion']);
            $('#asunto').val(y['nombre']);
            $('#id_encuesta').val(idMongoFinal.$id);                            
            $('#tipo').val(y['tipo']);
            $('#fechaFin').val(y['fecha_fin']);
            $('#nombre').val(y['nombre']);
            $('#labelnombre').text(y['nombre']);
            $('#descripcion').val(y['descripcion']);
            $('#estado').val(y['estado']);                            
        }                    
    });
}

function traerEnvio(datos){
    //Consulta para cargar la Cabecera de la encuesta
    $.each(datos, function(x , y) {
        var idmongo= JSON.stringify(y['_id']);
        var idMongoFinal = JSON.parse(idmongo);
        $('#id_encuesta').val(y['id_encuesta']);
        $('#id_copropiedad').val(y['id_copropiedad']);
        $('#invitados').val(y['invitados']);
        $('#odestinatario').val(y['invitados_externos']);
        $('#asunto').val(y['asunto']);
        $('#mensaje').val(y['mensaje']); 
        $('#metodo').val("PUT");        
    });
}

function traerElectores(datos){
    var msgDividido = JSON.stringify(datos);
    var mensaje =  JSON.parse(msgDividido);
    var msgDivididoDos = JSON.stringify(mensaje.message);
    $('#totalEncuestados').html(obtenerTerminoLenguage('en','46')+JSON.stringify(datos));
}

function traerElectoresTabla(datos){
    var msgDividido = JSON.stringify(datos);
    var mensaje =  JSON.parse(msgDividido);
    var msgDivididoDos = JSON.stringify(mensaje.message);
    return JSON.stringify(datos);
}

function traerCabecerasRersultados(datos){
    //Consulta para cargar la Cabecera de la encuesta
    $.each(datos, function(x , y) {               
        var idmongo= JSON.stringify(y['_id']);
        var idMongoFinal = JSON.parse(idmongo);
        $('#tituloEncuesta').html(obtenerTerminoLenguage('en','47')+y['nombre']);
        $('#id_copropiedad').val(y['id_copropiedad']);
        $('#id_crm_persona').val(y['id_crm_persona']);
        $('#fecha_creacion').val(y['fecha_creacion']);
        $('#tipo').val(y['tipo']);
        $('#datepicker').val(y['fecha_fin']);
        $('#nombre').val(y['nombre']);                            
        $('#descripcion').val(y['descripcion']);
        $('#estado').val(y['estado']);
        $('#invitados').val(y['invitados']);
        $('#odestinatario').val(y['invitados_externos']);
    });
}

function traerPreguntasResultado(datos){    
    var contador = 1;
    if(datos != null)
    $.each(datos, function(x , y) 
    {
        var muestra=x.split("|")
        var t = $('#res-encuesta').DataTable();                        
        t.row.add([
        '',
        y,
        muestra[1],
        '<a href="#" class="btn ver solo inline ttip" title="Pulse para ver resultados" id="pregunta'+contador+'"></a>'
        ] ).draw();
        $('#pregunta'+contador).click(function(){            
            $('#'+muestra[0]).removeClass("sinver");
            $('#'+muestra[0]).show();                            
            $(".sinver").hide();
            $('#'+muestra[0]).addClass("sinver");
        });
        contador++;                                               
    });
}


function traerElectantes(datos){    
    var correostotales="";
    $.each(datos[0], function(x , y){        
        if(x=="correostotales")
        {        
            correosTotales=y;
        }
    });
    correosTotales = correosTotales.split(",");
    $('#totalInvitados').html(obtenerTerminoLenguage('en','48')+" "+JSON.stringify(correosTotales.length));
}

function traerSetPreguntas(datos){    
    $.each(datos, function(x , y) {                        
        sessionStorage.setItem("idp",y);
    });
}

function enviocorreoencuesta(actualurl, email, mensaje, fechafin, titulo, direccionEncuesta,tokenencuesta) //--OK
{
  var mailpartido= email.split(",");  

  for (var i=0; i<mailpartido.length; i++) 
  {
      var urlfinal = direccionEncuesta+"index.php?tp=3&stk="+tokenencuesta+"&usr="+btoa(mailpartido[i]);
      $(document).renderme('ma');
      var body = '<p>'+ obtenerTerminoLenguage('ma', '67') +'<strong>'+sessionStorage.getItem('nombreCompleto')+" - "+sessionStorage.getItem('ncp')+'</strong>'+ obtenerTerminoLenguage('ma', '68') +'</p> <p> <strong>'+mensaje+'.</strong><br/><br/><strong>'+ obtenerTerminoLenguage('ma', '69') +fechafin+'.</strong><br/><br/><br/><a href="'+urlfinal+'" style="background:#f51e7c; color:#fff!important; text-decoration: none; padding:5px 10px; border-radius: 3px; font-weight:bold;">'+ obtenerTerminoLenguage('ma', '71') +'</a><br/><br/> <!--Para ver los términos y condiciones aceptados, haga click en el siguiente boton: <br/><a href="http://www.copropiedad.co/terminos-y-condiciones" style="background:#f51e7c; color:#fff!important; text-decoration: none; padding:5px 10px; border-radius: 3px; font-weight:bold;">Términos y condiciones</a>--> </p>';
      $(document).renderme('ma');
      var to = mailpartido[i];
      enviocorreoSync(to, titulo, body);
  }
}


















































// function envioPregunta(arr,url,metodo){
//         rutaAplicativo = traerDireccion()+"api/";
//         $.ajax(
//         {
//             url: rutaAplicativo+url,
//             type: metodo,
//             data: JSON.stringify(arr),
//             contentType: 'application/json; charset=utf-8',
//             dataType: 'json',
//             async: false,
//             success: function(msg) 
//             {                
//                 var msgDividido = JSON.stringify(msg);
//                 var mensaje =  JSON.parse(msgDividido);
//                 var msgDivididoDos = JSON.stringify(mensaje.message);
//                 if(mensaje.message=="Token invalido")
//                 {
//                     $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>')
//                     window.location = '../../index.php';
//                 }
//                 if(mensaje.status)
//                 {                    
//                     $('#alertas').html('<div class="alert alert-dismissable alert-success" style="height:10px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Pregunta creada.</div>');
//                 }
//                 else {$('#resultado').html(mensaje.error);}
//             }
//         })        
// }

/*function envioFormularioEliminar(arr,url,metodo,parametros){    
        rutaAplicativo = traerDireccion()+"api/";
        $.ajax(
        {
            url: rutaAplicativo+url,
            type: metodo,
            data: JSON.stringify(arr),
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            async: false,
            success: function(msg) 
            {
                var msgDividido = JSON.stringify(msg);
                var mensaje =  JSON.parse(msgDividido);
                var msgDivididoDos = JSON.stringify(mensaje.message);
                if(mensaje.message=="Token invalido")
                {
                    $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>');
                    window.location = '../../index.php';
                }
                if(mensaje.status)
                {
                    if(metodo=="PUT")
                    {                        
                        $('#alertas').html('<div class="alert alert-dismissable alert-success" style="height:10px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Cambio satisfactorio.</div>');                        
                        window.location='index.php';
                        return false;
                    }
                    else
                    {
                        $.each(mensaje.message, function(x , y) 
                        {
                            sessionStorage.setItem("insertado",y);
                        });
                    }
                }
                else {$('#resultado').html(mensaje.error);}
            }
        });
}



function GrabaParaEnvio(arr,url,metodo){
    rutaAplicativo = traerDireccion()+"api/";
    $.ajax(
    {
        url: rutaAplicativo+url,
        type: metodo,
        data: JSON.stringify(arr),
        contentType: 'application/json; charset=utf-8',
        dataType: 'json',
        async: false,
        success: function(msg) 
        {
            var msgDividido = JSON.stringify(msg);
            var mensaje =  JSON.parse(msgDividido);
            var msgDivididoDos = JSON.stringify(mensaje.message);
            if(mensaje.message==="Token invalido")
            {
                $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>');
                window.location = '../../index.php';
            }
            if(mensaje.status)
            {
                sessionStorage.setItem("ok","insertado");                
            }
            else {$('#resultado').html(mensaje.error);}
        }
    }); 
}

function enviarCorreoEncuesta(arr,url,metodo){
    rutaAplicativo = traerDireccion()+"api/";    
    $.ajax(
    {
        url: rutaAplicativo+url,
        type: metodo,
        data: JSON.stringify(arr),
        contentType: 'application/json; charset=utf-8',
        dataType: 'json',
        async: false,
        success: function(msg) 
        {
            var msgDividido = JSON.stringify(msg);
            var mensaje =  JSON.parse(msgDividido);
            var msgDivididoDos = JSON.stringify(mensaje.message);
            if(mensaje.message==="Token invalido")
            {
                $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>');
                window.location = '../../index.php';
            }
            if(mensaje.status)
            {
                $('#alertas').html('<div class="alert alert-dismissable alert-success" style="height:10px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Se ha enviado la encuesta correctamente.</div>');                        
                window.location='index.php';
            }
            else {$('#resultado').html(mensaje.error);}
        }
    }); 
}

function borraEnvio(arr,url,metodo){
    rutaAplicativo = traerDireccion()+"api/";
    $.ajax(
    {
        url: rutaAplicativo+url,
        type: metodo,
        data: JSON.stringify(arr),
        contentType: 'application/json; charset=utf-8',
        dataType: 'json',
        async: false,
        success: function(msg) 
        {
            var msgDividido = JSON.stringify(msg);
            var mensaje =  JSON.parse(msgDividido);
            var msgDivididoDos = JSON.stringify(mensaje.message);
            if(mensaje.message==="Token invalido")
            {
                $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>');
                window.location = '../../index.php';
            }
            if(mensaje.status)
            {
                
            }
            else {$('#resultado').html(mensaje.error);}
        }
    }); 
}

function envioFormulario(arr,url,metodo,parametros){
        rutaAplicativo = traerDireccion()+"api/";
        $.ajax(
        {
            url: rutaAplicativo+url,
            type: metodo,
            data: JSON.stringify(arr),
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            async: false,
            success: function(msg) 
            {
                var msgDividido = JSON.stringify(msg);
                var mensaje =  JSON.parse(msgDividido);
                var msgDivididoDos = JSON.stringify(mensaje.message);
                if(mensaje.message=="Token invalido")
                {
                    $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>');
                    window.location = '../../index.php';
                }
                if(mensaje.status)
                {
                
                    if(metodo=="PUT" || metodo=="DELETE")
                    {                        
                        $('#alertas').html('<div class="alert alert-dismissable alert-success" style="height:10px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Cambio satisfactorio.</div>');                        
                        window.location='encuesta-editar.php?idt='+parametros["idt"];                        
                        return false;
                    }
                    else
                    {
                        $.each(mensaje.message, function(x , y) 
                        {
                            sessionStorage.setItem("insertado",y);
                        });
                    }
                }
                else {$('#resultado').html(mensaje.error);}
            }
        });
}

function SolicitoToken(arr,url,metodo,parametros){
        rutaAplicativo = traerDireccion()+"api/";
        $.ajax(
        {
            url: rutaAplicativo+url,
            type: metodo,
            data: JSON.stringify(arr),
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            async: false,
            success: function(msg) 
            {
                var msgDividido = JSON.stringify(msg);
                var mensaje =  JSON.parse(msgDividido);
                var msgDivididoDos = JSON.stringify(mensaje.message);                
                $.each(mensaje.message, function(x , y) 
                {
                    sessionStorage.setItem("nuevoToken",y);
                });                                
            }
        });
}





function envioPreguntaEliminar(arr,url,metodo,encuesta){
        rutaAplicativo = traerDireccion()+"api/";
        $.ajax(
        {
            url: rutaAplicativo+url,
            type: metodo,
            data: JSON.stringify(arr),
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            async: false,
            success: function(msg) 
            {
                var msgDividido = JSON.stringify(msg);
                var mensaje =  JSON.parse(msgDividido);
                var msgDivididoDos = JSON.stringify(mensaje.message);
                if(mensaje.message=="Token invalido")
                {
                    $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>');
                    window.location = '../../index.php';
                }
                if(mensaje.status)
                {
                    if(metodo=="DELETE")
                    {
                        $('#alertas').html('<div class="alert alert-dismissable alert-success" style="height:10px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Cambio satisfactorio.</div>');                        
                        window.location='encuesta-editar.php?idt='+encuesta;
                        return false;
                    }                    
                }
                else {$('#resultado').html(mensaje.error);}
            }
        });        
}

function envioPregunta(arr,url,metodo){
        rutaAplicativo = traerDireccion()+"api/";
        $.ajax(
        {
            url: rutaAplicativo+url,
            type: metodo,
            data: JSON.stringify(arr),
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            async: false,
            success: function(msg) 
            {                
                var msgDividido = JSON.stringify(msg);
                var mensaje =  JSON.parse(msgDividido);
                var msgDivididoDos = JSON.stringify(mensaje.message);
                if(mensaje.message=="Token invalido")
                {
                    $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>')
                    window.location = '../../index.php';
                }
                if(mensaje.status)
                {                    
                    $('#alertas').html('<div class="alert alert-dismissable alert-success" style="height:10px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Pregunta creada.</div>');
                }
                else {$('#resultado').html(mensaje.error);}
            }
        })        
}

function notificador()
{
    $('#alertas').html('<div class="alert alert-dismissable alert-success" style="height:10px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Encuesta Creada.</div>');
    window.location='index.php';
    return false;
}

function envioPreguntaModificada(arr,url,metodo,encuesta){
        rutaAplicativo = traerDireccion()+"api/";
        $.ajax(
        {
            url: rutaAplicativo+url,
            type: metodo,
            data: JSON.stringify(arr),
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            async: false,
            success: function(msg) 
            {                
                var msgDividido = JSON.stringify(msg);
                var mensaje =  JSON.parse(msgDividido);
                var msgDivididoDos = JSON.stringify(mensaje.message);
                if(mensaje.message=="Token invalido")
                {
                    $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>')
                    window.location = '../../index.php';
                }
                if(mensaje.status)
                {                    
                    $('#alertas').html('<div class="alert alert-dismissable alert-success" style="height:10px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Cambio satisfactorio.</div>');
                    window.location = 'encuesta-editar.php?idt='+encuesta;
                }
                else {$('#resultado').html(mensaje.error);}
            }
        })        
}

function traerDatos(arr,url,params){
    rutaAplicativo = traerDireccion()+"api/";    
    $.ajax(
        {
            url: rutaAplicativo+url,
            type: 'POST',
            data: JSON.stringify(arr),
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            async: true,
            success: function(msg) 
            {
                var msgDividido = JSON.stringify(msg);
                var mensaje =  JSON.parse(msgDividido);
                var msgDivididoDos = JSON.stringify(mensaje.message);
                var datos = JSON.parse(msgDivididoDos);                
                if (datos=="Token invalido")
                {
                    $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>')                  
                    window.location = '../index.html';
                }
                else
                {
                    $.each(datos, function(x , y){
                        var idmongo= JSON.stringify(y['_id']);
                        var idMongoFinal = JSON.parse(idmongo);
                        var t = $('#example').DataTable();
                        if(y['estado']=="Completada")
                        {
                            t.row.add( [
                            '',                            
                            y['nombre'],
                            y['descripcion'],
                            y['fecha_fin'],                            
                            ''
                        ] ).draw();

                        }
                        if(y['estado']!="Cerrada")
                        {
                            t.row.add([
                            '',                            
                            y['nombre'],
                            y['descripcion'],
                            y['fecha_fin'],
                            '<a class="btn editar solo inline" title="Editar" href="encuesta-editar.php?idt='+idMongoFinal.$id+'"></a><a class="btn enviar solo inline" title="Enviar" id="open-enviar-encuesta" href="enviar-encuesta.php?idt='+idMongoFinal.$id+'"></a><a class="btn resultados solo inline" title="Resultados" href="resultado-encuesta.php?idt='+idMongoFinal.$id+'"></a><a class="btn borrar solo inline" title="Borrar" href="encuesta-borrar.php?idt='+idMongoFinal.$id+'"></a>'                            
                        ] ).draw();
                        }                        
                    });
                }                
            }
        });
}



function traerCabecerasModificables(arr,url,params){
    //Consulta para cargar la Cabecera de la encuesta
    rutaAplicativo = traerDireccion()+"api/";    
    $.ajax(
        {
            url: rutaAplicativo+url,
            type: 'POST',
            data: JSON.stringify(arr),
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            async: true,
            success: function(msg) 
            {

                var msgDividido = JSON.stringify(msg);
                var mensaje =  JSON.parse(msgDividido);
                var msgDivididoDos = JSON.stringify(mensaje.message);
                var datos = JSON.parse(msgDivididoDos);                
                if (datos=="Token invalido")
                {
                    $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Tip:</strong> NO PUDO LISTAR POR TOKEN, Solicitando un nuevo token por favor espere.</div>')
                    window.location = '../index.php';
                }
                else
                {
                    $.each(datos, function(x , y) {               
                        var idmongo= JSON.stringify(y['_id']);
                        var idMongoFinal = JSON.parse(idmongo);               
                            if(idMongoFinal.$id==params['idt'])
                        {
                            $('#id_copropiedad').val(y['id_copropiedad']);
                            $('#id_crm_persona').val(y['id_crm_persona']);
                            $('#fecha_creacion').val(y['fecha_creacion']);
                            $('#tipo').val(y['tipo']);
                            $('#datepicker').val(y['fecha_fin']);
                            $('#nombre').val(y['nombre']);
                            $('#labelnombre').text(y['nombre']);
                            $('#descripcion').val(y['descripcion']);
                            $('#estado').val(y['estado']);
                            $('#invitados').val(y['invitados']);
                            $('#odestinatario').val(y['invitados_externos']);
                        }                    
                    })
                }                
            }
        });
}





function traerEnvio(arr,url,params){
    //Consulta para cargar la Cabecera de la encuesta
    rutaAplicativo = traerDireccion()+"api/";    
    $.ajax(
        {
            url: rutaAplicativo+url,
            type: 'POST',
            data: JSON.stringify(arr),
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            async: true,
            success: function(msg) 
            {

                var msgDividido = JSON.stringify(msg);
                var mensaje =  JSON.parse(msgDividido);
                var msgDivididoDos = JSON.stringify(mensaje.message);
                var datos = JSON.parse(msgDivididoDos);                
                if (datos=="Token invalido")
                {
                    $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Tip:</strong> NO PUDO LISTAR POR TOKEN, Solicitando un nuevo token por favor espere.</div>')
                    window.location = '../index.php';
                }
                else
                {                    
                    $.each(datos, function(x , y) {
                        var idmongo= JSON.stringify(y['_id']);
                        var idMongoFinal = JSON.parse(idmongo);               
                            
                        $('#id_encuesta').val(y['id_encuesta']);
                        $('#id_copropiedad').val(y['id_copropiedad']);
                        $('#invitados').val(y['invitados']);
                        $('#odestinatario').val(y['invitados_externos']);
                        $('#asunto').val(y['asunto']);
                        $('#mensaje').val(y['mensaje']); 
                        $('#metodo').val("PUT"); 
                        
                    });
                }                
            }
        });
}


function traerDatosEliminables(arr,url,params){
    //Consulta para cargar la Cabecera de la encuesta
    rutaAplicativo = traerDireccion()+"api/";    
    $.ajax(
        {
            url: rutaAplicativo+url,
            type: 'POST',
            data: JSON.stringify(arr),
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            async: true,
            success: function(msg) 
            {

                var msgDividido = JSON.stringify(msg);
                var mensaje =  JSON.parse(msgDividido);
                var msgDivididoDos = JSON.stringify(mensaje.message);
                var datos = JSON.parse(msgDivididoDos);                
                if (datos=="Token invalido")
                {
                    $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Tip:</strong> NO PUDO LISTAR POR TOKEN, Solicitando un nuevo token por favor espere.</div>')
                    window.location = '../index.php';
                }
                else
                {
                    $.each(datos, function(x , y) {               
                        var idmongo= JSON.stringify(y['_id']);
                        var idMongoFinal = JSON.parse(idmongo);               
                        if(idMongoFinal.$id==params['idt'])
                        {
                            $('#id_copropiedad').val(y['id_copropiedad']);
                            $('#id_crm_persona').val(y['id_crm_persona']);
                            $('#fecha_creacion').val(y['fecha_creacion']);
                            $('#tipo').val(y['tipo']);
                            $('#fecha_fin').val(y['fecha_fin']);
                            $('#nombre').val(y['nombre']);
                            $('#nombremostrar').append(" "+y['nombre']+"?");
                            $('#descripcion').val(y['descripcion']);
                            $('#estado').val(y['estado']);
                            $('#invitados').val(y['invitados']);
                            $('#invitados_externos').val(y['invitados_externos']);
                        }                    
                    })
                }                
            }
        });
}

function TraerUsuarioCopropiedad(arr,url,metodo){
    rutaAplicativo = traerDireccion()+"api/admin/copropiedad/";    
    $.ajax(
        {
            url: rutaAplicativo+url,
            type: 'POST',
            data: JSON.stringify(arr),
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            async: false,
            success: function(msg) 
            {
                var msgDividido = JSON.stringify(msg);
                var mensaje =  JSON.parse(msgDividido);
                var msgDivididoDos = JSON.stringify(mensaje.message);
                var datos = JSON.parse(msgDivididoDos);                
                if (datos=="Token invalido")
                {
                    $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>')                  
                    window.location = '../index.html';
                }
                else
                {
                    $.each(datos, function(x , y) 
                    {
                        var idmongo= JSON.stringify(y['_id']);
                        var idMongoFinal = JSON.parse(idmongo);                        
                        $('#responsable').append('<option value="'+y['email']+'">'+y['nombre']+'</option>')
                        
                        
                    })               
                }
                return false;
            }
        });
}

function refreshWindow(){
    if(sessionStorage.getItem("referer").lenght < 2){window.location = 'index.php'}else{window.location = sessionStorage.getItem("referer");};
}

function TraerModulosCopropiedad(arr,url,metodo){     
    rutaAplicativo = traerDireccion()+"api/admin/copropiedad/";
    $.ajax(
        {
            url: rutaAplicativo+url,
            type: 'POST',
            data: JSON.stringify(arr),
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            async: false,
            success: function(msg) 
            {
                var msgDividido = JSON.stringify(msg);
                var mensaje =  JSON.parse(msgDividido);
                var msgDivididoDos = JSON.stringify(mensaje.message);
                var datos = JSON.parse(msgDivididoDos);                
                if (datos=="Token invalido")
                {
                    $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>')                  
                    window.location = '../index.html';
                }
                else
                {                    
                    $.each(datos, function(x , y) 
                    {
                        var idmongo= JSON.stringify(y['_id']);
                        var idMongoFinal = JSON.parse(idmongo);                       
                        sessionStorage.setItem("cp", idMongoFinal.$id);
                        var datos = JSON.stringify(y['modulos_activos']);
                        sessionStorage.setItem("modulos",y['modulos_activos'])
                        var endata =  JSON.parse(datos);                                                
                        //$('#tableContainer > tbody:last').append('<tr><td>'+y['nombre']+'</td><td>'+y['direccion']+'</td><td>'+y['telefono']+'</td><td>'+y['nit']+'</td><td><a class="btn editar solo inline" href="copropiedad-editar.html?idt='+idMongoFinal.$id+'"></a><a class="btn borrar solo inline" href="copropiedad-eliminar.html?idt='+idMongoFinal.$id+'"></a></td></tr>')
                    })
                }                
            }
        });
}*/

