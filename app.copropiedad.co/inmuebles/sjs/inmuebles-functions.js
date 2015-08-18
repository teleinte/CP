//funcion para popular las tablas
function popularTabla(datos)
{
	if(datos != null || datos != undefined)
	$.each(datos, function(x , y) 
    {
    	$.each(y, function(alfa , beta) {if(alfa=="_id"){$.each(beta, function(uno ,dos){idmongo=dos});}});
        var t = $('#inmuebles').DataTable();                            
        var enlace='<a class="btn borrar solo inline ttip" teid="in:title:35" href="inmueble-eliminar.php?idt='+idmongo+'"></a><a class="btn ver solo inline ttip" title="Ver inmueble" href="ver-contactos.php?idt='+idmongo+'"></a><a class="btn editar solo inline ttip" teid="in:title:5" href="inmueble-editar.php?idt='+idmongo+'"></a>';
        //enlace='<a id="open-editarcopripiedad" class="btn editar solo inline" href="usuario-editar.php?idt='+idMongoFinal.$id+'"></a><a class="btn borrar solo inline" href="usuario-eliminar.php?idt='+idMongoFinal.$id+'"></a>'
        t.row.add( [
        '',                            
        y['nombre_inmueble'],                        
        enlace                            
        ] ).draw();
        //$('#tableContainer > tbody:last').append('<tr><td>'+y['nombre_copropiedad']+'</td><td>'+y['tipo_unidad']+'</td><td>'+y['detalle']+'</td><td><a class="btn editar solo inline" href="inmueble-editar.html?idt='+idMongoFinal.$id+'"></a><a class="btn borrar solo inline" href="inmueble-eliminar.html?idt='+idMongoFinal.$id+'"></a></td></tr>')
    });
}
//funcion para popular la tabla de contactos
function popularTablaContactos(datos)
{
	var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
	$.each(datos, function(x , y) 
    {
    	$.each(y, function(alfa , beta) {if(alfa=="_id"){$.each(beta, function(uno ,dos){idmongo=dos});}});
	    var t = $('#contactos_tabla').DataTable();
	    var enlacee = '<a class="btn editar solo inline ttip" teid="in:title:5" href="contacto-editar.php?idt='+idmongo+'&rg='+params['idt']+'"></a>';
	    var enlaceb = '<a class="btn borrar solo inline ttip" teid="in:title:35" href="contacto-eliminar.php?idt='+idmongo+'&rg='+params['idt']+'"></a><a class="btn completar solo inline ttip" title="Seleccionar como principal" href="usuario-cambiar.php?idt='+idmongo+'&rg='+params['idt']+'"></a><a class="btn editar solo inline ttip" teid="in:title:5" href="contacto-editar.php?idt='+idmongo+'&rg='+params['idt']+'"></a>';
	    //var enlace='<a class="btn editar solo inline" title="Editar" href="usuario-editar.php?idt='+idmongo+'&rg='+params['idt']+'"></a><a class="btn borrar solo inline" title="Borrar" href="usuario-eliminar.php?idt='+idmongo+'&rg='+params['idt']+'"></a><a class="btn completar solo inline" title="Seleccionar como encargado" href="usuario-cambiar.php?idt='+idmongo+'&rg='+params['idt']+'"></a>';
	    //enlace='<a id="open-editarcopripiedad" class="btn editar solo inline" href="usuario-editar.php?idt='+idMongoFinal.$id+'"></a><a class="btn borrar solo inline" href="usuario-eliminar.php?idt='+idMongoFinal.$id+'"></a>'
	    if(y['principal']==true)
	    {
	    	var principales= "SI";
	    }else{principales= "NO"}
	    if(y['principal']==true)
	    {
		    t.row.add( [
		    '',
		    y['nombre'],
		    y['telefono'],
		    y['email'].toLowerCase(),
		    principales,
		    ucfirst(y['grupo']),
		    enlacee,
		    ] ).draw();
	    }
	    else
	    {
	    	t.row.add( [
		    '',
		    y['nombre'],
		    y['telefono'],
		    y['email'].toLowerCase(),
		    principales,
		    ucfirst(y['grupo']),
		    enlaceb,
		    ] ).draw();
	    }
	    //$('#tableContainer > tbody:last').append('<tr><td>'+y['nombre_copropiedad']+'</td><td>'+y['tipo_unidad']+'</td><td>'+y['detalle']+'</td><td><a class="btn editar solo inline" href="inmueble-editar.html?idt='+idMongoFinal.$id+'"></a><a class="btn borrar solo inline" href="inmueble-eliminar.html?idt='+idMongoFinal.$id+'"></a></td></tr>')
    });
}
function popularTablaContactosVer(datos, inmueble)
{
	var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
	$.each(inmueble, function(x , y) 
    {
    	$('#inmueble_name').html(' '+y['nombre_inmueble']);
    });
	$.each(datos, function(x , y) 
    {
    	console.warn(y);
	    $.each(y, function(alfa , beta) {if(alfa=="_id"){$.each(beta, function(uno ,dos){idmongo=dos});}});
	    var t = $('#contactos_tabla').DataTable();
	    //var enlace='<a class="btn editar solo inline" title="Editar" href="usuario-editar.php?idt='+idmongo+'&rg='+params['idt']+'"></a><a class="btn borrar solo inline" title="Borrar" href="usuario-eliminar.php?idt='+idmongo+'&rg='+params['idt']+'"></a><a class="btn completar solo inline" title="Seleccionar como encargado" href="usuario-cambiar.php?idt='+idmongo+'&rg='+params['idt']+'"></a>';
	    //enlace='<a id="open-editarcopripiedad" class="btn editar solo inline" href="usuario-editar.php?idt='+idMongoFinal.$id+'"></a><a class="btn borrar solo inline" href="usuario-eliminar.php?idt='+idMongoFinal.$id+'"></a>'
	    if(y['principal']==true)
	    {
	    	var principales= "SI";
	    }else{principales= "NO"}
	    if(y['principal']==true)
	    {
		    t.row.add( [
		    '',
		    y['nombre'],
		    y['telefono'],
		    y['email'].toLowerCase(),
		    principales,
		    y['grupo'],
		    
		    ] ).draw();
	    }
	    else
	    {
	    	t.row.add( [
		    '',
		    y['nombre'],
		    y['telefono'],
		    y['email'].toLowerCase(),
		    principales,
		    y['grupo'],
		    
		    ] ).draw();
	    }
	    //$('#tableContainer > tbody:last').append('<tr><td>'+y['nombre_copropiedad']+'</td><td>'+y['tipo_unidad']+'</td><td>'+y['detalle']+'</td><td><a class="btn editar solo inline" href="inmueble-editar.html?idt='+idMongoFinal.$id+'"></a><a class="btn borrar solo inline" href="inmueble-eliminar.html?idt='+idMongoFinal.$id+'"></a></td></tr>')
    });
}
//funcion para popular los formulraios modificables
function popularDatosModificables(datos)
{
	var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
	$.each(datos, function(x , y) {               
	    var idmongo= JSON.stringify(y['_id']);
	    var idMongoFinal = JSON.parse(idmongo);               
	    if(idMongoFinal.$id==params['idt'])
	    {                            
	        $('#id_unidad').val(idMongoFinal.$id);
	        $('#id_copropiedad').val(y['id_copropiedad']);
	        $('#id_crm_persona').val(y['id_crm_persona']);
	        $('#tipo_documento').val(y['tipo_documento']);
	        $('#tipo_unidad').val(y['tipo_unidad']);
	        $('#nombre_inmueble').val(y['nombre_inmueble']);
	        $('#nombremostrar').html(y['nombre_inmueble']);
	        $('#estado').val(y['estado']);
	        $('#fecha_creacion').val(y['fecha_creacion']);	        
	    }                    
	});
}
//funcion para popular el formulario de contactos independiente
function popularDatosUsuario(datos, inmueble)
{
	//alert("esta"+JSON.stringify(datos));
	var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
	$.each(inmueble, function(x , y) 
	{
		$('#inmueble_name').html(' del inmueble '+ y['nombre_inmueble']);
	});
	$.each(datos, function(x , y) {               
	    var idmongo= JSON.stringify(y['_id']);
	    var idMongoFinal = JSON.parse(idmongo);               
	    if(idMongoFinal.$id==params['idt'])
	    {                            
	        $('#id_usuario').val(idMongoFinal.$id);
	        $('#unidad').val(y['unidad']);
	        $('#nombre').val(y['nombre']);
	        $('#nombremostrar').text(y['nombre']);
	        $('#nombreEncargado').text(obtenerTerminoLenguage('in','53')+y['nombre']+ obtenerTerminoLenguage('in','54'));
	        $(document).renderme('in');
	        $('#telefono').val(y['telefono']);
	        $('#email').val(y['email'].toLowerCase());	        
	        $('#grupo').val(y['grupo']);	        
	        $('#creado_por').val(y['creado_por']);
	        $('#fecha_creacion').val(y['fecha_creacion']);
	        $('#id_copropiedad').val(y['id_copropiedad']);	        
	        $('#perfil').val(y['perfil']);
	        $('#tipo').val(y['tipo']);
			$('#estado').val(y['estado']);
	        $('#principal').val(y['principal']);
	        $('#id_crm_persona').val(y['id_crm_persona']);        
	    }                    
	});
}
//funcion para popular el formulario de inmuebles independiente
function popularDatosInmueble(datos)
{
	//alert("esta"+JSON.stringify(datos));
	var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
	$.each(datos, function(x , y) {               
	    var idmongo= JSON.stringify(y['_id']);
	    var idMongoFinal = JSON.parse(idmongo);               
	    if(idMongoFinal.$id==params['idt'])
	    {                            
	        $('#_id').val(idMongoFinal.$id);
	        $('#id_copropiedad').val(y['id_copropiedad']);
	        $('#id_crm_persona').val(y['id_crm_persona']);
	        $('#tipo_documento').val(y['tipo_documento']);
	        $('#tipo_unidad').val(y['tipo_unidad']);
	        $('#nombre_inmueble').val(y['nombre_inmueble']);	        
	        $('#estado').val(y['estado']);	        
	        $('#fecha_creacion').val(y['fecha_creacion']);	             
	    }	     
	});
}
function CrearUsuarioLDAP(arr)
{
    var rutaAplicativo = "https://auth.sinfo.co/auth/";    
    
    $.post(rutaAplicativo, JSON.stringify(arr))
    .done(function(data){
        var msgDividido = JSON.stringify(data);
        var mensaje =  JSON.parse(msgDividido);
        var msgDivididoDos = JSON.stringify(mensaje.message);
        if(mensaje.status)
        {
            return true;
        }        
    });
}


function enviocorreobienvenida(actualurl, email, envio,token) //--OK
{   
  var rutaActivacion = actualurl + "/registrese/activar.php?token=";
  var code = btoa(encodeURIComponent(envio));
  var link = rutaActivacion + encodeURIComponent(token) + "&code=" + code+ "&ecp=3";
  var metodo = "POST";  
  var body = '<p> <strong>'+sessionStorage.getItem('nombreCompleto')+' </strong>'+ obtenerTerminoLenguage('ma','75') +'<strong>'+sessionStorage.getItem('ncp')+'</strong>'+ obtenerTerminoLenguage('ma','76') +'<a href="http://www.copropiedad.co/">'+ obtenerTerminoLenguage('ma','77') +'</a> <br><br> '+ obtenerTerminoLenguage('ma','78') +'<a href="http://www.copropiedad.co/">'+ obtenerTerminoLenguage('ma','77') +'</a>'+ obtenerTerminoLenguage('ma','79') +'<strong>'+sessionStorage.getItem('nombreCompleto')+'</strong>'+ obtenerTerminoLenguage('ma','80') +'<br><br><strong>'+ obtenerTerminoLenguage('ma','81') +email+'</strong><br><br>'+ obtenerTerminoLenguage('ma','82') +'<br><a href="'+link+'" style="background:#f51e7c; color:#fff!important; text-decoration: none; margin-top:10px; padding:5px 10px; border-radius: 3px; font-weight:bold;">'+ obtenerTerminoLenguage('ma','83') +'</a><br></p>';
  $(document).renderme('ma');
  var to = email;  
  enviocorreoSync(to, obtenerTerminoLenguage('ma','84'), body, actualurl + "/");
  $(document).renderme('ma');
}

function enviocorreoNotificacionNoAdmin(actualurl, email) //--OK
{   
  var body = '<p><strong>'+sessionStorage.getItem('nombreCompleto')+'</strong>, administrador(a) de propiedad horizontal  lo ha adicionado a la copropiedad <strong>'+sessionStorage.getItem('ncp')+'</strong> en <a href="http://www.copropiedad.co/">Copropiedad.co</a><br> Ahora, cuando usted ingrese a copropiedad.co podrá escoger la copropiedad '+sessionStorage.getItem('ncp')+' para conocer toda la información y servicios en línea que <strong>'+sessionStorage.getItem('nombreCompleto')+'</strong> ha habilitado para usted.';
  var to = email;  
  enviocorreoSync(to, "Invitación a nueva Copropiedad", body, actualurl + "/");
}


function enviocorreoNotificacionAdmin(actualurl, email, envioRolCp, estadoNuevo) //--OK
{
  var rutaAceptacion = actualurl + "/aceptar/aceptar.php?tk="+btoa(envioRolCp)+"&en="+btoa(estadoNuevo);
  var body = '<p><strong>'+sessionStorage.getItem('nombreCompleto')+'</strong> lo ha invitado a ser parte de la copropiedad <strong>'+sessionStorage.getItem('ncp')+'</strong>.<br><br>En el momento de aceptar esta invitación, cada vez que ingrese a Copropiedad.co se le preguntará si quiere entrar como administrador o como residente.<br><br><a href="'+rutaAceptacion+'" style="background:#f51e7c; color:#fff!important; text-decoration: none; margin-top:10px; padding:5px 10px; border-radius: 3px; font-weight:bold;">ACEPTAR INVITACION</a></p>';
  var to = email;  
  enviocorreoSync(to, "Invitación", body, actualurl + "/");
}

function enviocorreobienvenidaDos(actualurl, email, nombre) //--OK
{
  var rutaActivacion = actualurl + "/registrese/activar.php?token=";
  var code = btoa(encodeURIComponent(nombre) + "^cp-" + email);
  var link = rutaActivacion+ encodeURIComponent(sessionStorage.getItem('token')) + "&code=" + code;
  var metodo = "POST";
  
  var body = '<p> Su administrador de Propiedad Horizontal <strong>'+sessionStorage.getItem('nombreCompleto')+'</strong>, lo ha invitado a ser parte de copropiedad.co </p> <p> Ahora usted podrá ingresar a mi.copropiedad.co y conocer toda la información y servicios en línea que <strong>'+sessionStorage.getItem('nombreCompleto')+'</strong> ha habilitado para usted. <br/><br/><strong>El usuario de su cuenta es: '+email+'</strong><br/><br/> Para activar su cuenta, es necesario que asigne una contraseña haciendo click en el siguiente botón: <br/><a href="'+link+'" style="background:#f51e7c; color:#fff!important; text-decoration: none; margin-top:10px; padding:5px 10px; border-radius: 3px; font-weight:bold;">Asignar contraseña y activar</a><br/><br/> <!--Para ver los términos y condiciones aceptados, haga click en el siguiente boton: <br/><a href="http://www.copropiedad.co/terminos-y-condiciones" style="background:#f51e7c; color:#fff!important; text-decoration: none; padding:5px 10px; border-radius: 3px; font-weight:bold;">Términos y condiciones</a>--> </p>';
  var to = email;
  
  enviocorreoSync(to, "Bienvenido a Copropiedad.co", body, actualurl + "/");
}
function popularNuevoUsuario(inmueble)
{
	//alert("esta"+JSON.stringify(datos));
	var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
	$.each(inmueble, function(x , y) 
	{
		$('#inmueble_name').html(' del inmueble '+ y['nombre_inmueble']);
	});
}