//funcion para popilar las tablas
function popularTabla(datos)
{
    if(datos != null || datos != undefined)
	$.each(datos, function(x , y) 
    {
        var idmongo= JSON.stringify(y['_id']);
        var idMongoFinal = JSON.parse(idmongo);
        var t = $('#copropiedades').DataTable();
        if(idMongoFinal.$id==sessionStorage.getItem("cp"))
        {
            var enlace = '<a id="open-editarcopripiedad" class="btn editar solo inline ttip" teid="ccp:title:8" href="copropiedad-editar.php?idt='+idMongoFinal.$id+'"></a><span style="vertical-align: middle; color:#f51e7c;">Copropiedad en uso</span></div>';
        }
        else
        {
            var enlace = '<a class="btn borrar solo inline ttip" teid="ccp:title:9" href="copropiedad-eliminar.php?idt='+idMongoFinal.$id+'"></a><a id="open-editarcopripiedad" class="btn editar solo inline ttip" teid="ccp:title:8" href="copropiedad-editar.php?idt='+idMongoFinal.$id+'"></a>';
        }
        t.row.add( [
            '',                            
            y['nombre'],
            y['direccion'],
            y['telefono'],
            y['nit'],
            enlace
        ] ).draw();
        //$('#example tr:last').after('<tr><td>'+y['nombre']+'</td><td>'+y['direccion']+'</td><td>'+y['telefono']+'</td><td>'+y['nit']+'</td><td><a class="btn editar solo inline" href="copropiedad-editar.html?idt='+idMongoFinal.$id+'"></a><a class="btn borrar solo inline" href="copropiedad-eliminar.html?idt='+idMongoFinal.$id+'"></a></td></tr>')
    })
}
//funcion para popular la tabla de contactos
function popularDatosModificables(datos)
{
	var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
	$.each(datos, function(x , y) {               
    var idmongo= JSON.stringify(y['_id']);
    var idMongoFinal = JSON.parse(idmongo);               
    if(idMongoFinal.$id==params['idt'])
    {
        //console.warn(y);
        $('#id_crm_persona').val(y['id_crm_persona']);
        $('#fecha_creacion').val(y['fecha_creacion']);
        $('#nombre').val(y['nombre']);
        $('#nombremostrar').append(" "+y['nombre']+"?");
        //alert("estamos dentro de la funcion que hace todas las cosas")
        $('#direccion').val(y['direccion']);
        $('#telefono').val(y['telefono']);
        $('#nit').val(y['nit']);
        $('#ciudad').val(y['ciudad']);        
        $('#referencia').val(y['referencia']);
        $('#vigencia').val(y['vigencia']);
        $('#pagosonline').val(y['pagosonline']);
        //$('#colores').append('<option value="'+y['color']+'" data-image="../images/msdropdown/color'+y['color']+'.png" data-description="Actual"></option>');
        //$('#colores > option[value="'+y['color']+'"]').attr('selected', 'selected');
    }                    
})	

}
//funcion para popular los formulraios modificables
// function popularDatosModificables(datos)
// {
// 	var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
// 	$.each(datos, function(x , y) {               
// 	    var idmongo= JSON.stringify(y['_id']);
// 	    var idMongoFinal = JSON.parse(idmongo);               
// 	    if(idMongoFinal.$id==params['idt'])
// 	    {                            
// 	        $('#id_unidad').val(idMongoFinal.$id);
// 	        $('#id_copropiedad').val(y['id_copropiedad']);
// 	        $('#id_crm_persona').val(y['id_crm_persona']);
// 	        $('#tipo_documento').val(y['tipo_documento']);
// 	        $('#tipo').val(y['tipo_unidad']);
// 	        $('#nombre_inmueble').val(y['nombre_inmueble']);                            
// 	        $('#estado').val(y['estado']);
// 	        $('#fecha_creacion').val(y['fecha_creacion']);	        
// 	    }                    
// 	});
// }
//funcion para popular el formulario de contactos independiente
function popularDatosUsuario(datos)
{
	//alert("esta"+JSON.stringify(datos));
	var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
	$.each(datos, function(x , y) {               
	    var idmongo= JSON.stringify(y['_id']);
	    var idMongoFinal = JSON.parse(idmongo);               
	    if(idMongoFinal.$id==params['idt'])
	    {                            
	        $('#id_usuario').val(idMongoFinal.$id);
	        $('#unidad').val(y['unidad']);
	        $('#nombre').val(y['nombre']);
	        $('#nombremostrar').text(obtenerTerminoLenguage('ccp','27')+y['nombre']);
	        $('#telefono').val(y['telefono']);
	        $('#email').val(y['email']);	        
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
function enviocorreo(numero){	
    var rutaAplicativo = traerDireccion()+"api/mailer/mail/registro/bienvenida/";
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
    });
}

function calculaVigenciaInicial(ref)
{
    if(ref == "Demo 45")
    {
        return agregarDias(45);
    }

    if(ref == "Demo 90")
    {
        return agregarDias(90);
    }
}

function enviocorreoDespedida(actualurl, email, nombre) //--OK
{ 
    $(document).renderme('ma'); 
    var body = '<p>'+obtenerTerminoLenguage('ma','55')+' <strong>'+sessionStorage.getItem('nombreCompleto')+'</strong>'+obtenerTerminoLenguage('ma','56')+'<strong>'+nombre+'</strong>'+obtenerTerminoLenguage('ma','57')+'<br><br>'+obtenerTerminoLenguage('ma','58')+'</p>';
    var resultado = enviocorreoSync(email.toString(), obtenerTerminoLenguage('ma','51'), body, actualurl + "/"); 
    $(document).renderme('ma'); 
}

function enviocorreoDespedidaCopropiedad(actualurl, email, nombre, id) //--OK
{ 
    $(document).renderme('ma'); 
    var body = '<p>'+obtenerTerminoLenguage('ma','59')+'<strong> '+sessionStorage.getItem('nombreCompleto')+' </strong>'+obtenerTerminoLenguage('ma','56')+'<strong>'+nombre+obtenerTerminoLenguage('ma','60')+id+' </strong>'+obtenerTerminoLenguage('ma','57')+'<br><br>'+obtenerTerminoLenguage('ma','58')+'</p>';
    var resultado = enviocorreoSync(email, obtenerTerminoLenguage('ma','51'), body, actualurl + "/"); 
    $(document).renderme('ma'); 
}