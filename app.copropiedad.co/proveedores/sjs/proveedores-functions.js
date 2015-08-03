//funcion para popilar las tablas
function popularTabla(datos)
{
	if(datos != null || datos != undefined)
	$.each(datos, function(x , y) 
    {
    	$.each(y, function(alfa , beta) {if(alfa=="_id"){$.each(beta, function(uno ,dos){idmongo=dos});}});
        var t = $('#proveedores').DataTable();                            
        var enlacee ='<a class="btn editar solo inline ttip" teid="pr:title:5" href="proveedores-editar.php?idt='+idmongo+'"></a>';
        var enlaceb ='<a class="btn borrar solo inline ttip" teid="ctp:title:13" href="proveedores-eliminar.php?idt='+idmongo+'"></a>';
        //enlace='<a id="open-editarcopripiedad" class="btn editar solo inline" href="usuario-editar.php?idt='+idMongoFinal.$id+'"></a><a class="btn borrar solo inline" href="usuario-eliminar.php?idt='+idMongoFinal.$id+'"></a>'
        t.row.add( [
        '',
        y['nombre_inmueble'],
        enlaceb + enlacee
        ] ).draw();
        //$('#tableContainer > tbody:last').append('<tr><td>'+y['nombre_copropiedad']+'</td><td>'+y['tipo_unidad']+'</td><td>'+y['detalle']+'</td><td><a class="btn editar solo inline" href="inmueble-editar.html?idt='+idMongoFinal.$id+'"></a><a class="btn borrar solo inline" href="inmueble-eliminar.html?idt='+idMongoFinal.$id+'"></a></td></tr>')
    });
}
//funcion para popular la tabla de contactos
function popularTablaContactos(datos)
{
	var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
	var contador = 0;
	
	if(datos != null || datos != undefined)
		$.each(datos, function(x , y) 
	    {
		    $.each(y, function(alfa , beta) {if(alfa=="_id"){$.each(beta, function(uno ,dos){idmongo=dos});}});
		    var t = $('#contactos_tabla').DataTable();
		    var enlacee = '<a class="btn editar solo inline ttip" teid="pr:title:5" href="contacto-editar.php?idt='+idmongo+'&rg='+params['idt']+'"></a>';
		    var enlaceb = '<a class="btn borrar solo inline ttip" teid="ctp:title:13" href="contacto-eliminar.php?idt='+idmongo+'&rg='+params['idt']+'"></a>';
		    //var enlace='<a class="btn editar solo inline" title="Editar" href="usuario-editar.php?idt='+idmongo+'&rg='+params['idt']+'"></a><a class="btn borrar solo inline" title="Borrar" href="usuario-eliminar.php?idt='+idmongo+'&rg='+params['idt']+'"></a><a class="btn completar solo inline" title="Seleccionar como encargado" href="usuario-cambiar.php?idt='+idmongo+'&rg='+params['idt']+'"></a>';
		    //enlace='<a id="open-editarcopripiedad" class="btn editar solo inline" href="usuario-editar.php?idt='+idMongoFinal.$id+'"></a><a class="btn borrar solo inline" href="usuario-eliminar.php?idt='+idMongoFinal.$id+'"></a>'
		    if(contador == 0)
		    {
		    	t.row.add( [
		    	'',
		    	y['nombre'],
		    	y['telefono'],
		    	y['email'].toLowerCase(),
		    	enlacee
		    	] ).draw();
		    }
		    else
		    {
		    	t.row.add( [
		    	'',
		    	y['nombre'],
		    	y['telefono'],
		    	y['email'].toLowerCase(),
		    	enlaceb + " " + enlacee
		    	] ).draw();
		    }
		    contador ++;
		    //$('#tableContainer > tbody:last').append('<tr><td>'+y['nombre_copropiedad']+'</td><td>'+y['tipo_unidad']+'</td><td>'+y['detalle']+'</td><td><a class="btn editar solo inline" href="inmueble-editar.html?idt='+idMongoFinal.$id+'"></a><a class="btn borrar solo inline" href="inmueble-eliminar.html?idt='+idMongoFinal.$id+'"></a></td></tr>')
	    });
}
//funcion para popular los formulraios modificables
function popularDatosModificables(datos)
{
	var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
	if(datos != null || datos != undefined)
	$.each(datos, function(x , y) {               
	    var idmongo= JSON.stringify(y['_id']);
	    var idMongoFinal = JSON.parse(idmongo);               
	    if(idMongoFinal.$id==params['idt'])
	    {                            
	        sessionStorage.setItem('proveedorMuestra', y['nombre_inmueble'])
	        $('#id_unidad').val(idMongoFinal.$id);
	        $('#id_copropiedad').val(y['id_copropiedad']);
	        $('#id_crm_persona').val(y['id_crm_persona']);
	        $('#tipo_documento').val(y['tipo_documento']);
	        $('#tipo_unidad').val(y['tipo_unidad']);
	        $('#nombre_inmueble').val(y['nombre_inmueble']);
	        $('#nombremostrar').append(y['nombre_inmueble'])                            
	        $('#estado').val(y['estado']);
	        $('#fecha_creacion').val(y['fecha_creacion']);	        
	    }                    
	});
}
//funcion para popular el formulario de contactos independiente
function popularDatosUsuario(datos)
{
	//alert("esta"+JSON.stringify(datos));
	var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
	if(datos != null || datos != undefined)
	$.each(datos, function(x , y) {               
	    var idmongo= JSON.stringify(y['_id']);
	    var idMongoFinal = JSON.parse(idmongo);               
	    if(idMongoFinal.$id==params['idt'])
	    {                            
	        $('#id_usuario').val(idMongoFinal.$id);
	        $('#unidad').val(y['unidad']);
	        $('#nombre').val(y['nombre']);
	        $('#nombremostrar').text(y['nombre']);
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
function enviocorreo(numero)
{	
    /*var rutaAplicativo = traerDireccion()+"api/mailer/mail/registro/bienvenida/";
    var rutaActivacion = traerDireccion()+"registrese/activar.php?token=";
    var code = btoa(encodeURIComponent($('#nombre'+numero).val()) + "^cp-" + $('#email'+numero).val());
    //alert(rutaActivacion + encodeURIComponent(sessionStorage.getItem('token')) + "&code=" + encodeURIComponent(code));
    var metodo = "POST";
    var arr = {
    token:sessionStorage.getItem('token'),
    body:
    {  
          id_crm_persona:"registro",
          fecha_solicitud:new Date(),
          nombre_remitente:"registro",
          destinatarios:[  
             {  
                user: $('#email'+numero).val(),
                link: rutaActivacion + encodeURIComponent(sessionStorage.getItem('token')) + "&code=" + code,
                email: $('#email'+numero).val()
             }
          ],
    }
  }; 
    $.ajax(
    {
        url: rutaAplicativo,
        type: metodo,
        data: JSON.stringify(arr),
        contentType: 'application/json; charset=utf-8',
        dataType: 'json',
        async: false,
        success: function(msg) 
        {
            var msgDividido = JSON.stringify(msg);
            var mensaje =  JSON.parse(msgDividido);             
        }
    });*/
}